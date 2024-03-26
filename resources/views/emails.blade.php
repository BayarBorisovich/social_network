<x-mail::message>
# Introduction

  Content:  {{ $password['user'] }}
  Password:  {{ $password['content'] }}

<x-mail::button :url="$password['url']">
Перейдите по ссылке
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
