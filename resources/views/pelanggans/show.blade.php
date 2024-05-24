@extends('layouts.main')
@section('content')

<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <div class="flex gap-2 items-center">
        <div class="inline-block rounded p-2 bg-white shadow drop-shadow">
            <div class="flex items-center text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                <h1 class="ml-1 font-bold">Detail Pelanggan</h1>
            </div>
        </div>
        <a href="{{ route("pelanggans.edit", [$pelanggan->id]) }}" class="text-slate-400 bg-white shadow drop-shadow rounded p-1" >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
        </a>
    </div>

    <div class="mx-2">
        <div class="mt-5">
            <label class="text-slate-500">Nama :</label>
            <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">{{ $pelanggan->nama }}</div>
        </div>

        <div class="mt-3">
            <label class="text-slate-500">Username :</label>
            <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">{{ $pelanggan->username }}</div>
        </div>

        <div class="mt-3">
            <label class="text-slate-500">Gender :</label>
            <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">{{ $pelanggan->gender }}</div>
        </div>

        <div class="mt-3">
            <label class="text-slate-500">NIK / Nomor ID :</label>
            <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">{{ $pelanggan->nik }}</div>
        </div>

        <div class="mt-3">
            <label class="text-slate-500">No. WA :</label>
            <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">{{ $pelanggan->nomor_wa }}</div>
        </div>

        <div class="mt-3">
            <label class="text-slate-500">Email :</label>
            <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">{{ $pelanggan->email }}</div>
        </div>

        <div class="mt-3">
            <label class="text-slate-500">Alamat :</label>
            <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">
                <div>{{ $pelanggan->alamat_baris_1 }}</div>
                <div>{{ $pelanggan->alamat_baris_2 }}</div>
                <div>{{ $pelanggan->alamat_baris_3 }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="text-slate-500">Provinsi :</label>
                    <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">{{ $pelanggan->provinsi }}</div>
                </div>
                <div>
                    <label class="text-slate-500">Kota :</label>
                    <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">{{ $pelanggan->kota }}</div>
                </div>
                <div>
                    <label class="text-slate-500">Kode POS :</label>
                    <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">{{ $pelanggan->kodepos }}</div>
                </div>
            </div>
        </div>
    </div>
</main>

<x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button>

@endsection
