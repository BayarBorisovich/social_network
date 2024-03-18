<x-mail::message>
# Introduction

{{--  Password:  {{ $password }}--}}
  Password:  {{ $password['password'] }}

<x-mail::button :url="$password['url']">
Перейдите по ссылке
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
