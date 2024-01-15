<x-mail::message>
# You have recieve a ADAS Certificate

Welcome,

You have been invited to join the Storm Auto Services Dashboard,

<x-mail::button :url="route('register', $invite->token)">
    Accept Invite
</x-mail::button>

Kind regards,

Storm Auto Services
</x-mail::message>