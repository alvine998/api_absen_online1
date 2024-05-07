@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center mt-[50px] px-10">
    <div class="bg-white shadow w-full rounded-md p-4">
        <h2 class="font-semibold text-xl">Tambah Data Pengguna</h2>
        <form action="{{route('user.store')}}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="w-full mt-5">
                <div class="flex flex-col gap-1">
                    <label for="name">Nama</label>
                    <input id="name" name="name" type="text" value="{{old('name')}}" required placeholder="Masukkan Nama" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="nik">NIK</label>
                    <input id="nik" name="nik" type="text" value="{{old('nik')}}" required placeholder="Masukkan NIK" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="type">Peran</label>
                    <select name="type" class="w-full p-1 border border-gray-300" id="type">
                        <option value="">Pilih Peran</option>
                        <option value="spg">SPG</option>
                        <option value="sales">Sales</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div id="radioRole" class="hidden my-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="role" id="role" value="supervisor">
                        <span class="ml-2">Supervisor</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" name="role" id="role" value="">
                        <span class="ml-2">Not Supervisor</span>
                    </label>
                </div>

                <script>
                    document.getElementById('type').addEventListener('change', function() {
                        var selected = this.value;
                        var radioSelect = document.getElementById('radioRole');

                        if (selected !== "spg") {
                            radioSelect.classList.add('hidden')
                        } else {
                            radioSelect.classList.remove('hidden')
                        }
                    })
                </script>

                <div class="flex flex-col gap-1 mt-2">
                    <label for="password">Password</label>
                    <input id="password" name="password" value="{{old('password')}}" type="password" required placeholder="Masukkan Password" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="photo">Foto</label>
                    <input id="photo" name="photo" value="{{old('photo')}}" type="file" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="notes">Keterangan</label>
                    <input id="notes" name="notes" value="{{old('notes')}}" placeholder="Masukkan Keterangan" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <input type="hidden" name="user_name" value="{{Session::get('user')->name}}">
                <input type="hidden" name="user_type" value="{{Session::get('user')->type}}">
                <input type="hidden" name="user_id" value="{{Session::get('user')->id}}">
            </div>

            <div class="mt-5 flex justify-between items-center gap-2">
                <a href="/user" class="w-full p-1 rounded text-center bg-red-500 text-white hover:bg-red-600 duration-200">Batal</a>
                <button type="submit" class="w-full p-1 rounded bg-blue-500 text-white hover:bg-blue-600 duration-200">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection