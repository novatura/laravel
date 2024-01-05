<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Inertia\Inertia;
use OTPHP\TOTP;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TwoFactorController extends Controller
{
    public function setup(Request $request)
    {
        $otp = TOTP::generate();
        $otp->setLabel(config('app.name') . ' - ' . $request->user()->email);
        $request->session()->put('two-factor-secret', $otp->getSecret());

        $secret = $otp->getSecret();
        $uri = $otp->getProvisioningUri();
        $qr_code = 'data:image/png;base64,' . base64_encode(QrCode::style("round")->format('png')->size(512)->generate($uri));

        return Inertia::render("Auth/TwoFactor/Create", [
            'secret' => $secret,
            'qr_code' => $qr_code,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $otp = TOTP::create($request->session()->get('two-factor-secret'));
        if (!$otp->verify($validated['code'])) {
            return back()->withErrors([
                'code' => 'The provided code is invalid.',
            ]);
        }

        $codes = [];
        for ($i = 0; $i < 10; $i++) {
            $codes[] = bin2hex(random_bytes(16));
        }

        $user = User::find($request->user()->id);
        $user->two_factor_secret = encrypt($request->session()->get('two-factor-secret'));
        $user->two_factor_recovery_codes = encrypt($codes);
        $user->save();

        $request->session()->forget('two-factor-secret');

        return redirect()->route("profile.edit");
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->user()->id);
        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->save();

        return redirect()->back();
    }

    public function verify(Request $request)
    {
        if (!$request->session()->has('two-factor:auth')) {
            return redirect()->route('login');
        }

        return Inertia::render("Auth/TwoFactor/Verify");
    }

    public function verify_store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $auth = $request->session()->get('two-factor:auth');
        $user = User::find($auth['user_id']);

        $otp = TOTP::create(decrypt($user->two_factor_secret));
        if (!$otp->verify($validated['code'])) {
            return back()->withErrors([
                'code' => 'The provided code is invalid.',
            ]);
        }

        $request->session()->forget('two-factor:auth');

        Auth::login($user, $auth['remember']);

        $request->session()->regenerate();
    }

    public function recover(Request $request)
    {
        if (!$request->session()->has('two-factor:auth')) {
            return redirect()->route('login');
        }

        return Inertia::render("Auth/TwoFactor/Recover");
    }

    public function recover_store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required'],
        ]);

        $auth = $request->session()->get('two-factor:auth');

        if (!$auth) {
            return redirect()->route('login');
        }

        $user = User::find($auth['user_id']);
        $codes = decrypt($user->two_factor_recovery_codes);

        if (!in_array($validated['code'], $codes)) {
            return back()->withErrors([
                'code' => 'The provided code is invalid.',
            ]);
        }

        $request->session()->forget('two-factor:auth');

        Auth::login($user, $auth['remember']);

        $request->session()->regenerate();

        $codes = array_values(array_diff($codes, [$validated['code']]));

        User::where('id', $user->id)->update([
            'two_factor_recovery_codes' => encrypt($codes),
        ]);

        return redirect()->route("profile.edit");
    }

    public function recovery_codes(Request $request)
    {
        $codes = array_values(decrypt($request->user()->two_factor_recovery_codes));
        return Inertia::render("Auth/TwoFactor/RecoveryCodes", [
            'recovery_codes' => $codes,
        ]);
    }

    public function download_recovery_codes()
    {
        $codes = decrypt(Auth::user()->two_factor_recovery_codes);
        $codes = implode("\n", $codes);

        return response($codes)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="recovery-codes.txt"');
    }
}
