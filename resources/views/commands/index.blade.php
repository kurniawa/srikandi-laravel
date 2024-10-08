@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>
        <h3>Masuk ke phpmyadmin lalu tambah table: warna_emas</h3>
        <p>Struktur table warna_emas:</p>
        <ul class="list-disc list-inside">
            <li>id -> bigInteger -> primary</li>
            <li>nama -> varchar(20) -> not null -> no default -> utf8mb4_unicode_ci</li>
            <li>codename -> varchar(50) -> nullable -> default(null) -> utf8mb4_unicode_ci</li>
            <li>created_at -> timestamps -> nullable -> default(null)</li>
            <li>updated_at -> timestamps -> nullable -> default(null)</li>
        </ul>
        <form action="{{ route('artisans.input_initial_data_warna_emas') }}" method="POST">
            @csrf
            <button type="submit" class="bg-orange-300 text-white rounded p-1">input initial data warna emas</button>
        </form>
    </main>
@endsection
