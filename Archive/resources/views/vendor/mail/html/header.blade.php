@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{asset("images/logo/madini.png")}}" class="logo" alt="Madini">
@else
<img src="{{asset("images/logo/madini.png")}}" class="logo" alt="Madini">
{{ $slot }}
@endif
</a>
</td>
</tr>
