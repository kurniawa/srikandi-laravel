<div>
    <div class="flex gap-1 items-center mt-2 bg-slate-300 p-1">
        <select name="hari" id="hari" class="border py-1 rounded">
            @if (old('hari'))
                @for ($i = 1; $i < 32; $i++)
                    <option value="{{ $i }}" {{ old('hari') == $i ? 'selected' : '' }}>
                        {{ $i }}</option>
                @endfor
            @else
                @for ($i = 1; $i < 32; $i++)
                    @if ($i == date('d'))
                        <option value="{{ $i }}" selected>{{ $i }}</option>
                    @else
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endif
                @endfor
            @endif
        </select>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
            </svg>
        </div>
        <select name="bulan" id="bulan" class="border py-1 rounded">
            @if (old('bulan'))
                @for ($i = 1; $i < 13; $i++)
                    <option value="{{ $i }}" {{ old('bulan') == $i ? 'selected' : '' }}>
                        {{ $i }}</option>
                @endfor
            @else
                @for ($i = 1; $i < 13; $i++)
                    @if ($i == date('m'))
                        <option value="{{ $i }}" selected>{{ $i }}</option>
                    @else
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endif
                @endfor
            @endif
        </select>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
            </svg>
        </div>
        <input type="text" name="tahun" class="border rounded p-1 w-1/3" value="{{ old("tahun") ? old("tahun") : date('Y') }}">
    </div>
</div>