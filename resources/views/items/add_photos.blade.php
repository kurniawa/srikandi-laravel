@extends('layouts.main')
@section('content')
<main>
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <div>
        @csrf
        <div class="p-2">
            <div class="mb-5 border border-emerald-300 rounded p-1">
                <label id="label_nama_short" for="nama_short" class="block text-sm font-medium text-gray-900 dark:text-white">nama_short</label>
                @if (old('nama_short'))
                <input type="text" id="nama_short" name="nama_short" value="{{ old('nama_short') }}" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                @else
                <input type="text" id="nama_short" name="nama_short" value="{{ $item->nama_short }}" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                @endif
                <label id="label_nama_long" for="nama_long" class="mt-1 block text-sm font-medium text-gray-900 dark:text-white">nama_long</label>
                @if (old('nama_long'))
                <textarea id="nama_long" name="nama_long" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('nama_long') }}</textarea>
                @else
                <textarea id="nama_long" name="nama_long" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $item->nama_long }}</textarea>
                @endif
                {{-- <input type="text" id="nama_long" name="nama_long" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"> --}}
            </div>
        </div>

        <div class="p-2">
            @for ($i = 0; $i < 5; $i++)
            @if ($item_photos[$i])
            <div class="flex gap-2">
                <div class="w-28 max-h-28 mb-2">
                    <img src="{{ asset("storage/" . $photos[$i]->path) }}" alt="item_photo" class="w-full">
                </div>
                <form action="{{ route('items.delete_photo', [$item->id, $item_photos[$i]->id, $photos[$i]->id]) }}" method="POST" onsubmit="return confirm('Anda yakin ingin hapus photo_item ini?')" class="flex items-center">
                    @csrf
                    <button type="submit" class="bg-pink-300 text-pink-500 rounded p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </form>
            </div>
            @else
            <form method="POST" action="{{ route('items.add_photo', $item->id) }}" class="mb-1" enctype="multipart/form-data">
                @csrf
                <label for="input-photo-{{ $i }}" class="inline-block hover:cursor-pointer" id="label-input-photo-{{ $i }}">
                    <div class="text-white bg-sky-300 rounded p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-20 h-20">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                        </svg>
                    </div>
                </label>
                <input id="input-photo-{{ $i }}" type="file" name="photo" onchange="previewImage(this.files[0], 'div-preview-photo-{{ $i }}', 'preview-photo-{{ $i }}', 'label-input-photo-{{ $i }}')" class="hidden">
                <input type="hidden" name="photo_index" value="{{ $i }}">
                <div id="div-preview-photo-{{ $i }}" class="hidden">
                    <div class="flex justify-end">
                        <button type="button" class="text-red-400" onclick="removeImage('input-photo-{{ $i }}', 'div-preview-photo-{{ $i }}', 'preview-photo-{{ $i }}', 'label-input-photo-{{ $i }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <img id="preview-photo-{{ $i }}"></img>
                    <div class="flex justify-center mt-1">
                        <button type="submit" class="bg-emerald-300 text-white border-2 border-emerald-400 font-bold rounded px-3 py-1 text-sm">+ Tambah Photo</button>
                    </div>
                </div>
            </form>
            @endif
            @endfor
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('items.show', $item->id) }}" class="loading-spinner bg-rose-300 text-white px-3 py-2 rounded font-bold">Kembali</a>
        </div>
    </div>

    {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
</main>
<script src="{{ asset('js/item.js') }}"></script>


@endsection

