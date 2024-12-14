<div>
    <!-- Simplicity is an acquired taste. - Katharine Gerould -->
    <div id="div-filter" class="bg-white shadow drop-shadow p-2 rounded text-slate-500 mt-2 hidden text-xs">
        <form action="" method="GET">
            <table>
                <tr>
                    <td>Admin</td>
                    <td>:</td>
                    <td>
                        <select name="target_user_id" id="filter-username" class="p-1 rounded">
                            @if ($targetUser)
                                @foreach ($userLists as $user)
                                @if ($user->id == $targetUser->id)
                                <option value="{{ $user->id }}" selected>{{ $user->username }}</option>
                                @else
                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                                @endif
                                @endforeach
                            @else
                                @foreach ($userLists as $user)
                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                                @endforeach
                            @endif
                        </select>
                    </td>
                </tr>
            </table>
            <div class="flex gap-2 items-center mt-2">
                <div class="flex items-center"><input type="radio" name="timerange" value="today" id="now"
                        onclick="set_time_range('now')"><label for="now" class="ml-1 whitespace-nowrap">now</label>
                </div>
                <div class="flex items-center"><input type="radio" name="timerange" value="7d" id="7d"
                        onclick="set_time_range('7d')"><label for="7d" class="ml-1 whitespace-nowrap">7d</label>
                </div>
                {{-- <div class=""><input type="radio" name="timerange" value="30d" id="30d" onclick="set_time_range('30d')"><label for="30d" class="ml-1 whitespace-nowrap">30d</label></div> --}}
                <div class="flex items-center"><input type="radio" name="timerange" value="bulan_ini" id="bulan_ini"
                        onclick="set_time_range('bulan_ini')"><label for="bulan_ini"
                        class="ml-1 whitespace-nowrap">bulan ini</label></div>
            </div>
            <div class="flex gap-2 items-center mt-2">
                <div class="flex items-center"><input type="radio" name="timerange" value="bulan_lalu" id="bulan_lalu"
                        onclick="set_time_range('bulan_lalu')"><label for="bulan_lalu"
                        class="ml-1 whitespace-nowrap">bulan lalu</label></div>
                <div class="flex items-center"><input type="radio" name="timerange" value="this_year" id="tahun_ini"
                        onclick="set_time_range('tahun_ini')"><label for="tahun_ini"
                        class="ml-1 whitespace-nowrap">tahun ini</label></div>
                <div class="flex items-center"><input type="radio" name="timerange" value="last_year" id="tahun_lalu"
                        onclick="set_time_range('tahun_lalu')"><label for="tahun_lalu"
                        class="ml-1 whitespace-nowrap">tahun lalu</label></div>
            </div>
            <div>
                <label>Dari:</label>
                <div class="flex">
                    <select name="from_day" id="from_day" class="rounded py-1">
                        <option value="">-</option>
                        @for ($i = 1; $i < 32; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <select name="from_month" id="from_month" class="rounded py-1 ml-1">
                        <option value="">-</option>
                        @for ($i = 1; $i < 13; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <select name="from_year" id="from_year" class="rounded py-1 ml-1">
                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                        <option value="">-</option>
                        @for ($i = (int) date('Y') - 30; $i < (int) date('Y') + 30; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="mt-2">
                <label>Sampai:</label>
                <div class="flex items-center">
                    <select name="to_day" id="to_day" class="rounded py-1">
                        <option value="">-</option>
                        @for ($i = 1; $i < 32; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <select name="to_month" id="to_month" class="rounded py-1 ml-1">
                        <option value="">-</option>
                        @for ($i = 1; $i < 13; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <select name="to_year" id="to_year" class="rounded py-1 ml-1">
                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                        <option value="">-</option>
                        @for ($i = (int) date('Y') - 30; $i < (int) date('Y') + 30; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    {{-- <button type="submit" class="ml-2 flex items-center bg-orange-500 text-white py-1 px-3 rounded hover:bg-orange-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <span class="ml-1">filter/search</span>
                    </button> --}}
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-yellow-200 text-gray-400 rounded-lg p-1 flex gap-1 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <span>Filter</span>
                </button>
            </div>
        </form>
    </div>
</div>