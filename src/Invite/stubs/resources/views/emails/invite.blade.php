<x-mail::message>
# You have recieved an invitation

Welcome,

You have been invited to join this [Insert Cool Novatura Project].

<x-mail::button :url="route('register', $invite->token)">
    Accept Invite
</x-mail::button>

Kind regards,

The Novatura Team
</x-mail::message>