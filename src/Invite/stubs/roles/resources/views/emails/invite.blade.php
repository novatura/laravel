<x-mail::message>
# You have recieve an invitation

Welcome,

<x-mail::button :url="route('register', $invite->token)">
    Accept Invite
</x-mail::button>

Kind regards,

</x-mail::message>