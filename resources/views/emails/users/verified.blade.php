@component('mail::message')
# Introduction

Hi {{$user->name}}, <br>

Here is you 6 pin digit code to verify your account: <b>{{$verificationCode}}</b>

@component('mail::button', ['url' => ''])
Go here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
