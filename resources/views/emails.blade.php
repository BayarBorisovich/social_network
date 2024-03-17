<x-mail::message>
# Introduction

{{--  Password:  {{ $password }}--}}
  Password:  {{ $password }}

<x-mail::button :url="$url">
Перейдите по ссылке
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
