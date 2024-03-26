<x-mail::message>
# Introduction

Ваш друг {{ $name }} опубликовал новый пост: {{$data['content']}}

<x-mail::button :url="$url">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
