@extends('layouts.main')
@section('content')
    <main>
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>

        <div>
            @csrf
            <div class="p-2">
                <div class="mb-5 border border-emerald-300 rounded p-1">
                    <label id="label_shortname" for="shortname"
                        class="block text-sm font-medium text-gray-900 dark:text-white">shortname</label>
                    @if (old('shortname'))
                        <input type="text" id="shortname" name="shortname" value="{{ old('shortname') }}"
                            class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    @else
                        <input type="text" id="shortname" name="shortname" value="{{ $item->shortname }}"
                            class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    @endif
                    <label id="label_longname" for="longname"
                        class="mt-1 block text-sm font-medium text-gray-900 dark:text-white">longname</label>
                    @if (old('longname'))
                        <textarea id="longname" name="longname" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('longname') }}</textarea>
                    @else
                        <textarea id="longname" name="longname" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $item->longname }}</textarea>
                    @endif
                    {{-- <input type="text" id="longname" name="longname" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"> --}}
                </div>
            </div>

            {{-- PENAMBAHAN PHOTO MELALUI LINK KE SARAN PHOTO --}}
            <div class="p-1 mx-2 border-2 rounded">
                <div class="inline-block bg-white shadow drop-shadow p-1">
                    <h2 class="text-slate-500 font-bold">Saran foto untuk index ke-{{ $index+1 }}</h2>
                </div>
                <div>
                    <form action="{{ route('items.add_photo_from_sugestion', [$item->id]) }}" method="POST" class="mt-2">
                        @csrf
                        <div class="grid grid-cols-3 gap-3">
                            @foreach ($saran_photos as $key => $saran_photo)
                            <div class="flex gap-1 items-center">
                                <input type="radio" name="photo_id" id="saran_photo-{{ $key }}" value="{{ $saran_photo['photo_id'] }}">
                                <label for="saran_photo-{{ $key }}">
                                    <img src="{{ asset('storage/' . $saran_photo['photo_path']) }}" alt="" class="w-full">
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-2">
                            <input type="hidden" name="photo_index" value="{{ $index }}">
                            <button type="submit" class="bg-emerald-300 font-bold text-white p-2 rounded">Konfirmasi</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- END - PENAMBAHAN PHOTO MELALUI LINK KE SARAN PHOTO --}}

            {{-- PENAMBAHAN PHOTO DENGAN INPUT PHOTO BARU --}}
            <div class="p-1 mx-2 mt-5 border-2 rounded">
                <div class="inline-block bg-white shadow drop-shadow p-1">
                    <h2 class="text-slate-500 font-bold">Foto baru untuk index ke-{{ $index+1 }}</h2>
                </div>
                <form method="POST" action="{{ route('items.add_photo', $item->id) }}" class="mt-2"
                    enctype="multipart/form-data">
                    @csrf
                    <label for="input-photo" class="inline-block hover:cursor-pointer"
                        id="label-input-photo">
                        <div class="text-white bg-sky-300 rounded p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-20 h-20">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                        </div>
                    </label>
                    <input id="input-photo" type="file" name="photo"
                        onchange="previewImage(this.files[0], 'div-preview-photo', 'preview-photo', 'label-input-photo')"
                        class="hidden">
                    <input type="hidden" name="photo_index" value="{{ $index }}">
                    <div id="div-preview-photo" class="hidden">
                        <div class="flex justify-end">
                            <button type="button" class="text-red-400"
                                onclick="removeImage('input-photo', 'div-preview-photo', 'preview-photo', 'label-input-photo')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="3" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <img id="preview-photo"></img>
                        <div class="flex justify-center mt-1">
                            <button type="submit"
                                class="loading-spinner bg-emerald-300 text-white border-2 border-emerald-400 font-bold rounded px-3 py-1 text-sm">+
                                Tambah Foto</button>
                        </div>
                    </div>
                </form>
            </div>
            {{-- END - PENAMBAHAN PHOTO DENGAN INPUT PHOTO BARU --}}

            <div class="text-center mt-10">
                <a href="{{ route('items.add_photo', $item->id) }}"
                    class="loading-spinner bg-rose-300 text-white px-3 py-2 rounded font-bold">Kembali</a>
            </div>
        </div>

    </main>
    <script src="{{ asset('js/item.js') }}"></script>
@endsection
