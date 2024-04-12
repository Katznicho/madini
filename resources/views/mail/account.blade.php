<x-mail::message>

Hello, {{$name}} your account with {{ config('app.name') }} has been created

Welcome to the family

You can use {{$password }}  as your password to login into {{ config('app.name') }}

<x-mail::button :url="$url">
  Login
</x-mail::button>

Thanks
{{ config('app.name') }}
</x-mail::message>
