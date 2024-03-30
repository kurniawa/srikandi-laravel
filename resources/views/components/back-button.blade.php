@if ($back === true)
<div class="fixed bottom-0 left-0 w-full">
    <div class="flex justify-end">
        <form action="{{ route($backRoute, $backRouteParams) }}" method="GET">
            <button type="submit" class="loading-spinner bg-orange-400 text-white w-12 h-12 flex justify-center items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </button>
        </form>
    </div>
</div>
@endif
