@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center mt-[50px] px-10">
    <div class="bg-white shadow w-full rounded-md p-4">
        <h2 class="font-semibold text-xl">Tambah Data Toko</h2>
        <form action="{{route('store.store')}}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="w-full mt-5">
                <div class="flex flex-col gap-1">
                    <label for="code">Kode Toko</label>
                    <input id="code" name="code" type="text" value="{{old('code')}}" required placeholder="Masukkan Kode Toko" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="name">Nama Toko</label>
                    <input id="name" name="name" type="text" value="{{old('name')}}" required placeholder="Masukkan Nama Toko" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="user_id">Supervisor</label>
                    <select name="user_id" class="w-full p-1 border border-gray-300" id="user_id">
                        <option value="">Pilih Supervisor</option>
                        @foreach ($user as $users)
                        <option value="{{$users->id}}">{{$users->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="note1">Keterangan</label>
                    <textarea id="note1" name="note1" value="{{old('note1')}}" type="text" placeholder="Masukkan Keterangan" class="w-full p-1 pl-2 rounded border border-gray-300"></textarea>
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