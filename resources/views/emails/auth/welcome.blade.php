@component('mail::message')
Hi {{ $user->first_name }},

Use the link below to set a new password and access your {{ config('app.name') }} account.

@component('mail::button', ['url' => route('users.welcome', ['token' => $token, 'email' => $user->email])])
Set Account Password
@endcomponent

@include('emails.includes.regards')
@endcomponent
