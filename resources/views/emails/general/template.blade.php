@component('mail::message')
Hello, {{$user['first_name']}}

{!! $message !!}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

