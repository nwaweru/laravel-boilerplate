@component('mail::message')
Hi {{ $user->first_name }},

Click on the link below to verify your email address and access your account.

@component('mail::button', ['url' => $url])
Verify Email Address
@endcomponent

The above <b>link expires in {{ config('auth.passwords.users.expire') }} minutes</b>.

If you did not create an account with us, no further action is required.

@include('emails.includes.regards')
@endcomponent
