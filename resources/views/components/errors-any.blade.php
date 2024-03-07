@if ($errors->any())
<div class="fixed bottom-10 text-pink-600">
@foreach ($errors->all() as $error)
{{ $error }}
@endforeach
</div>
@endif
