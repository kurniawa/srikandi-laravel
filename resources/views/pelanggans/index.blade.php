@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>

        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-slate-500">Daftar Pelanggan</h1>
            <div>
                <a href="{{ route('pelanggans.create', $user->id) }}" class="bg-emerald-300 text-white font-bold rounded-lg px-2 py-1">+ NEW P</a>
            </div>
        </div>
        <table class="w-full mt-5 text-slate-500">
            @foreach ($pelanggans as $key => $pelanggan)
            <tr class="border-t">
                <td class="py-2"><div class="text-center text-slate-500"></div></td>
                <td class="py-2"><div class="">{{ $pelanggan->nama }}</div></td>
                <td class="py-2"><div class="">{{ $pelanggan->username }}</div></td>
                <td class="py-2">
                    <div class="flex justify-end">
                        <a href="{{ route('pelanggans.show', $pelanggan->id) }}" class="bg-orange-300 text-white rounded px-2">Detail</a>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
        {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
    </main>
@endsection
