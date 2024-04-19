@if ($errors->any())
<div id="session-errors" class="fixed bottom-10 text-pink-600 z-40 bg-red-300 border-2 border-red-500 p-2 rounded ml-2 flex justify-between gap-3 w-11/12 items-center">
    <div>
        @foreach ($errors->all() as $error)
        {{ $error }}
        @endforeach
    </div>
    <div>
        <button type="button" onclick="hideSessionErrors()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
<script>
    function hideSessionErrors() {
        $('#session-errors').hide(300);
    }
</script>
@endif
