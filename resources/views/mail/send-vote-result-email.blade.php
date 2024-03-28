<x-mail::message>
Vote Results

@foreach ($voteResults as $question => $voteResult)
Question: {{ $question}}
<br>
Vote results: {{ $voteResult}}
<hr/>
@endforeach

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
