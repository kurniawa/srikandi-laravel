<div>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
    <div class="flex gap-2 items-center bg-white text-xs text-slate-400 rounded-lg border-slate-300 border-2 px-2">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </div>
        <div class="">
            <input type="text" name="longname" id="search-longname" oninput="searchSimilarItems(this, 'result-similar-items')" class="border-none w-full p-1" placeholder="nama barang/item...">
        </div>
    </div>
</div>

<script>
    const similar_items_x_photos = {!! json_encode($similaritemsxphotos, JSON_HEX_TAG) !!};
    const window_main_url = window.location.protocol + '//' + window.location.host + '/';

    function searchSimilarItems(input, result_id) {
        if (input.value.trim()) {
            const filtered = similar_items_x_photos.filter(function (item) {
            if (item.longname.toLowerCase().includes(input.value.trim().toLowerCase()) && this.count < 10) {
                this.count++;
                return true;
            }
            return false;
            }, {count:0});
        // console.log(filtered);
        let html_result = `<div class="absolute bg-white shadow drop-shadow p-1 text-xs font-bold z-10">`;
        
        filtered.forEach(item => {
            html_photo = `<div class="col-span-3 bg-indigo-100 text-indigo-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                </div>`;
            if (item.photo_path) {
                html_photo = `<div class="col-span-3">
                    <img class="w-full" src="${window_main_url}storage/${item.photo_path}">
                    </div>`;
            }
            html_result += `<a href="${window_main_url}${item.url_path}"><div class="loading-spinner border-b hover:cursor-pointer hover:bg-slate-100 grid grid-cols-12 gap-2 items-center">
                ${html_photo}
                <div class="col-span-9">${item.longname}</div>
                </div></a>`;
        });
        html_result += '</div>';

        document.getElementById(result_id).innerHTML = html_result;
        } else {
            document.getElementById(result_id).innerHTML = '';

        }
        
    }
</script>