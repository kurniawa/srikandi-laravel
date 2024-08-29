@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <div>
        @if ($cart_item->photo_path)
        <div class="w-full">
            <img src="{{ asset("storage/" . $cart_item->photo_path) }}" alt="item_photo" class="w-full">
        </div>
        <form action="{{ route('photos.delete_cart_item_photo', $cart_item->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin hapus foto cart_item ini?')" class="mt-5">
            @csrf
            <div class="flex justify-center">
                <button type="submit" class="loading-spinner bg-pink-300 text-white rounded p-1 flex gap-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    <span>Hapus Foto Cart Item</span>
                </button>
            </div>
        </form>
        @else
        <form method="POST" action="{{ route('photos.add_cart_item_photo', $cart_item->id) }}" class="mb-1" enctype="multipart/form-data">
            @csrf
            <label for="input-photo" class="inline-block hover:cursor-pointer" id="label-input-photo">
                <div class="text-white bg-sky-300 rounded p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-20 h-20">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                </div>
            </label>
            <input id="input-photo" type="file" name="photo" ="previewImage(this.files[0], 'div-preview-photo', 'preview-photo', 'label-input-photo')" class="hidden">
            {{-- <input type="hidden" name="photo_index" value="{{ $key }}"> --}}
            <div id="div-preview-photo" class="hidden">
                <div class="flex justify-end">
                    <button type="button" class="text-red-400" onclick="removeImage('input-photo', 'div-preview-photo', 'preview-photo', 'label-input-photo')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <img id="preview-photo"></img>
                <div class="flex justify-center mt-1">
                    <button type="submit" class="loading-spinner bg-emerald-300 text-white border-2 border-emerald-400 font-bold rounded px-3 py-1 text-sm">+ Tambah Photo</button>
                </div>
            </div>
        </form>
        @endif
    </div>
    {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
</main>

<script src="{{ asset('js/item.js') }}"></script>

@endsection

