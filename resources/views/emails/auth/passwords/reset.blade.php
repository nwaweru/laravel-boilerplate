@component('mail::message')
Hi {{ $user->first_name }},

We have received a password reset for your account.

@component('mail::button', ['url' => route('password.reset', ['token' => $token, 'email' => $user->email])])
Reset Password
@endcomponent

This password reset link will expire in {{ config('auth.passwords.users.expire') }} minutes.

If you did not request a password reset, no further action is required.

@include('emails.includes.regards')
@endcomponent
