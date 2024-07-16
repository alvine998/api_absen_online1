@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center mt-[50px] px-10">
    <div class="bg-white shadow w-full rounded-md p-4">
        <h2 class="font-semibold text-xl">Ubah Data Toko</h2>
        <form action="{{route('store.update', $store->id)}}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PUT')
            <div class="w-full mt-5">
                <div class="flex flex-col gap-1">
                    <label for="code">Kode Toko</label>
                    <input id="code" name="code" type="text" value="{{old('code', $store->code)}}" required placeholder="Masukkan Kode Toko" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="name">Nama Toko</label>
                    <input id="name" name="name" type="text" value="{{old('name', $store->name)}}" required placeholder="Masukkan Nama Toko" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>

                <div id="radioRole" class="my-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="role" id="role" value="spg" onchange="handleRadio(this)" {{$store->user_id !== 0 ? "checked" : ""}}>
                        <span class="ml-2">SPG</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" name="role" id="role" value="sales" onchange="handleRadio(this)" {{$store->user_id == 0 ? "checked" : ""}}>
                        <span class="ml-2">Sales</span>
                    </label>
                </div>

                <div id="radioSPV" class="flex flex-col gap-1 mt-2">
                    <label for="user_id">Supervisor</label>
                    <select name="user_id" class="w-full p-1 border border-gray-300" id="user_id">
                        <option value="">Pilih Supervisor</option>
                        @foreach ($user as $users)
                        <option value="{{$users->id}}" {{old('user_id', $store->user_id) == $users->id ? 'selected' : ''}}>{{$users->name}}</option>
                        @endforeach
                    </select>
                </div>

                <script>
                    var store = @json($store);

                    function handleFirst() {
                        var radioSelect = document.getElementById('radioSPV');
                        if (store.user_id == 0) {
                            radioSelect.classList.add('hidden')
                        }
                    }

                    function handleRadio(item) {
                        var radioSelect = document.getElementById('radioSPV');
                        var selected = item.value
                        if (selected !== "spg") {
                            radioSelect.classList.add('hidden')
                        } else {
                            radioSelect.classList.remove('hidden')
                        }
                    }

                    window.onload = handleFirst();
                </script>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="note1">Keterangan</label>
                    <textarea id="note1" name="note1" value="{{old('note1', $store->note1)}}" type="text" placeholder="Masukkan Keterangan" class="w-full p-1 pl-2 rounded border border-gray-300"></textarea>
                </div>
            </div>

            <div class="mt-5 flex justify-between items-center gap-2">
                <a href="/store" class="w-full p-1 rounded text-center bg-red-500 text-white hover:bg-red-600 duration-200">Batal</a>
                <button type="submit" class="w-full p-1 rounded bg-blue-500 text-white hover:bg-blue-600 duration-200">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection