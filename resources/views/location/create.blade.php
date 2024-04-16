@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center mt-[50px] px-10">
    <div class="bg-white shadow w-full rounded-md p-4">
        <h2 class="font-semibold text-xl">Tambah Data Lokasi Pengguna</h2>
        <form action="{{route('location.store')}}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="w-full mt-5">

                <div class="flex flex-col gap-1 mt-2">
                    <label for="user_id">Pengguna</label>
                    <select name="user_id" class="w-full p-1 border border-gray-300" id="user_id">
                        <option value="">Pilih Pengguna</option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1 mt-2">
                    <label for="latt">Latitude</label>
                    <input id="latt" name="latt" type="text" value="{{old('latt')}}" required placeholder="Masukkan Latitude" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="long">Longitude</label>
                    <input id="long" name="long" type="text" value="{{old('long')}}" required placeholder="Masukkan Longitude" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
            </div>

            <div class="mt-5 flex justify-between items-center gap-2">
                <a href="/location" class="w-full p-1 rounded text-center bg-red-500 text-white hover:bg-red-600 duration-200">Batal</a>
                <button type="submit" class="w-full p-1 rounded bg-blue-500 text-white hover:bg-blue-600 duration-200">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection