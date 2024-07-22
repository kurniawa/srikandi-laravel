@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>
    <div class="flex justify-between items-center">
        <div class="bg-white shadow drop-shadow rounded p-2 flex gap-1 text-slate-400 items-center">
            <h1 class="text-xl font-bold">Merk</h1>
        </div>
        <a href="{{ route('attributes.merks.create') }}">
            <button class="bg-emerald-400 p-1 rounded text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </button>
        </a>
    </div>

    <div class="mt-2 border rounded p-1">
        <form action="{{ route('attributes.merks.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-1">
                <div class="col-span-1">
                    <input type="text" name="nama" id="nama" placeholder="nama merk" class="rounded w-full">
                </div>
                <div class="col-span-1">
                    <input type="text" name="codename" id="codename" placeholder="codename merk" class="rounded w-full">
                </div>
            </div>
            <div class="flex justify-center mt-2">
                <div class="rounded p-2 bg-emerald-300 text-white font-bold">
                    <button type="submit">+Tambah Merk</button>
                </div>
            </div>
        </form>
    </div>

    <div class="border-2 border-orange-300 rounded p-1 mt-5">
        <div class="text-center mt-2">
            <h3 class="font-bold text-slate-500">Daftar Merk</h3>
        </div>
        <div class="mt-2">
            <table class="table-slim w-full">
                <tr><th>nama</th><th>codename</th></tr>
                @foreach ($merks as $merk)
                <tr>
                    <td class="text-center">{{ $merk->nama }}</td>
                    <td class="text-center">{{ $merk->codename }}</td>
                    <td>
                        <div class="flex gap-1">
                            <a href="{{ route('attributes.merks.edit', $merk->id) }}">
                                <button class="p-1 rounded bg-blue-400 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </button>
                            </a>
                            <form action="{{ route('attributes.merks.destroy', $merk->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus merk ini?')">
                                @csrf
                                <button type="submit" class="p-1 bg-rose-300 text-white rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</main>
@endsection

