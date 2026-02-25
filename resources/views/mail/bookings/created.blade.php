<x-mail::message>
# {{ __('mail.hello', ['name' => $userName]) }}

{{ __('mail.booking.success.created_successfully', ['reservableName' => $reservableName]) }}
<br><br>
{{ __('mail.booking.success.start_at', ['date' => $startAt]) }}
<br>
{{ __('mail.booking.success.end_at', ['date' => $endAt]) }}
</x-mail::message>
