<!-- Modal Background -->
<div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-10 mx-auto p-5 border w-96 shadow-lg h-[500px] rounded-md bg-white">
        <!-- Modal Header -->
        <div class="flex justify-between items-center pb-3">
            <p class="text-2xl font-bold">Kode Referensi</p>
            <div class="modal-close cursor-pointer z-50" onclick="toggleModal('modal')">
                <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"/>
                </svg>
            </div>
        </div>
        <!-- Modal Body -->
        <div class="mt-10">
            {{ $slot }}
        </div>
    </div>
</div>
