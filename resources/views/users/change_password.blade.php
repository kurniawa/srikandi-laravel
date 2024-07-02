@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>

        <div class="flex gap-2 items-center">
            <div class="inline-block rounded p-2 bg-white shadow drop-shadow">
                <div class="flex items-center text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                    </svg>

                    <h1 class="ml-1 font-bold">Ubah Password</h1>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('users.update_password', $user->id) }}"
            class="p-5 border rounded bg-white shadow drop-shadow mt-2">
            @csrf
            <div class="">
                <label for="displayName">Old Password :</label>
                <div>
                    <input type="password" id="displayName" name="old_password" class="rounded text-slate-600 w-full"
                        required />
                </div>
            </div>

            <div class="mt-3">
                <label for="new_password">New Password :</label>
                <div>
                    <input type="password" id="new_password" name="new_password" class="rounded text-slate-600 w-full"
                        required />
                </div>
            </div>

            <div class="mt-3">
                <label for="confirm_password">Confirm Password :</label>
                <div>
                    <input name="new_password_confirmation" type="password" id="confirm_password"
                        class="rounded text-slate-600 w-full" />
                </div>
            </div>

            <div class="mt-5 text-center">
                <button type="submit"
                    class="loading-spinner bg-emerald-300 rounded text-white font-bold px-3 py-2 hover:bg-emerald-400 disabled:opacity-25">Ubah
                    Password</button>
            </div>
            <div class="mt-3 text-center">
                <a href="{{ route('users.show', $user->id) }}"
                    class="loading-spinner bg-rose-300 rounded text-white font-bold px-3 py-2 hover:bg-rose-400 disabled:opacity-25">Cancel</a>
            </div>
        </form>
    </main>

    {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
    <script src="{{ asset('js/item.js') }}"></script>
@endsection
