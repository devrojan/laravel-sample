@component('mail::message')
# Introduction

Hi, you are invited. Please sign up.

@component('mail::button', ['url' => ''])
Sign Up
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
