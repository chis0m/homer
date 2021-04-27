@component('mail::message')
Hello, {{$user['first_name']}}

{!! $message !!}

{!! $end_message !!}

@if($button_text)
@component('mail::button', ['url' => $url])
{{ $button_text }}
@endcomponent
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent

