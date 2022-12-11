@component('mail::message')
# Introduction

<p>Password reset token {{$token}}</p>

@component('mail::button', ['url' => ''])
Reset
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
