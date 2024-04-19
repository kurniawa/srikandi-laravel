<div id="feedback-messages" class="fixed bottom-10 text-sm z-40">
<!-- He who is contented is rich. - Laozi -->
    @if (session()->has('success_') && session('success_')!=="")
    <div class="font-semibold px-3 py-2 rounded bg-emerald-200 text-emerald-600 opacity-70 w-11/12 flex justify-between items-center">
        <div>
            {{ session('success_') }}
        </div>
        <div>
            <button type="button" onclick="hideFeedbackMessages()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    @endif
    @if (session()->has('warnings_') && session('warnings_')!=="")
    <div class="font-semibold px-3 py-2 rounded bg-yellow-200 text-yellow-600 opacity-70 w-11/12 flex justify-between items-center">
        <div>
            {{ session('warnings_') }}
        </div>
        <div>
            <button type="button" onclick="hideFeedbackMessages()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    @endif
    @if (session()->has('danger_') && session('danger_')!=="")
    <div class="font-semibold px-3 py-2 rounded bg-red-200 text-red-600 opacity-70 w-11/12 flex justify-between items-center">
        <div>
            {{ session('danger_') }}
        </div>
        <div>
            <button type="button" onclick="hideFeedbackMessages()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    @endif
    @if (session()->has('errors_') && session('errors_')!=="")
    <div class="font-semibold px-3 py-2 rounded bg-red-200 text-red-600 opacity-70 w-11/12 flex justify-between items-center">
        <div>
            {{ session('errors_') }}
        </div>
        <div>
            <button type="button" onclick="hideFeedbackMessages()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    @endif
    @if (session()->has('failed_') && session('failed_')!=="")
    <div class="font-semibold px-3 py-2 rounded bg-red-200 text-red-600 opacity-70 w-11/12 flex justify-between items-center">
        <div>
            {{ session('failed_') }}
        </div>
        <div>
            <button type="button" onclick="hideFeedbackMessages()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    @endif
</div>

<script>
    function hideFeedbackMessages() {
        $('#feedback-messages').hide(300);
    }
</script>
