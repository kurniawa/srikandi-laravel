@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>

        <div class="flex justify-between items-center">
            <div class="p-2 bg-white shadow drop-shadow rounded">
                <h1 class="text-xl font-bold text-slate-500">Daftar User</h1>
            </div>
            <div>
                <a href="{{ route('users.create', $user->id) }}"
                    class="bg-emerald-300 text-white font-bold rounded-lg px-2 py-1">+ NEW P</a>
            </div>
        </div>
        <table class="w-full mt-5 text-slate-500">
            @foreach ($users as $key => $user)
                <tr class="border-t">
                    <td class="py-2">
                        <div class="text-center text-slate-500"></div>
                    </td>
                    <td class="py-2">
                        <div class="">{{ $user->username }}</div>
                    </td>
                    <td class="py-2">
                        <div class="">{{ $user->nama }}</div>
                    </td>
                    <td class="py-2">
                        <div class="flex justify-end">
                            <a href="{{ route('users.show', $user->id) }}"
                                class="bg-yellow-400 text-white rounded px-2">Detail</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
    </main>
@endsection
