@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>
        
        <h1>Initial Commands Center</h1>
        
        {{-- <h3 class="text-lg font-bold text-slate-500">1. Ubah Value Codename Pada Table Matas</h3>
        <form action="{{ route('artisans.update_codename_in_table_matas') }}" method="POST" onsubmit="return confirm('Anda yakin?')">
            @csrf
            <button class="p-2 bg-orange-300 text-white font-bold rounded">Ubah Value Codename Pada Table Matas</button>
        </form>

        <h3 class="mt-3 text-lg font-bold text-slate-500">2. Ubah Value Codename Pada Table Mainans</h3>
        <form action="{{ route('artisans.update_codename_in_table_mainans') }}" method="POST" onsubmit="return confirm('Anda yakin?')">
            @csrf
            <button class="p-2 bg-orange-300 text-white font-bold rounded">Ubah Value Codename Pada Table Mainans</button>
        </form> --}}

        <h3 class="mt-3 text-lg font-bold text-slate-500">3. Backup data dalam bentuk json. Namun sebelum itu, ada baiknya juga download file .sql nya.</h3>
        <form action="{{ route('artisans.backup_data') }}" method="POST" onsubmit="return confirm('Anda yakin?')">
            @csrf
            <button class="p-2 bg-orange-300 text-white font-bold rounded">Backup Data Dalam Bentuk JSON</button>
        </form>

        <form action="{{ route('artisans.resorting_jenisPerhiasan_berdasarkan_tipePerhiasan_dan_nama') }}" method="POST" onsubmit="return confirm('Anda yakin?')" class="mt-5">
            @csrf
            <button class="p-2 bg-orange-300 text-white font-bold rounded">resorting_jenisPerhiasan_berdasarkan_tipePerhiasan_dan_nama</button>
        </form>

        {{-- <h3 class="mt-3 text-lg font-bold text-slate-500">4. Jalankan perintah "php artisan migrate:fresh --seed"</h3>

        <h3 class="mt-3 text-lg font-bold text-slate-500">5. Update Jenis Perhiasan</h3>
        <form action="{{ route('artisans.update_jenis_perhiasans_d_caps') }}" method="POST" onsubmit="return confirm('Anda yakin?')">
            @csrf
            <button class="p-2 bg-orange-300 text-white font-bold rounded">Update Jenis Perhiasan & Caps</button>
        </form>
        
        <ol class="list-decimal list-inside">
            <li>php artisan migrate</li>
            <li>php artisan db:seed --class=AddUsernameToAccountingsTable</li>
        </ol> --}}
        {{-- <form action="{{ route('artisans.update_name_in_caps') }}" method="POST">
            @csrf
            <button class="p-2 bg-orange-300 text-white font-bold">update_name_in_caps</button>
        </form>
        <form action="{{ route('artisans.re_sorting_barcodes_in_caps') }}" method="POST" class="mt-2">
            @csrf
            <button class="p-2 bg-orange-300 text-white font-bold">re_sorting_barcodes_in_caps</button>
        </form> --}}
    </main>
@endsection
