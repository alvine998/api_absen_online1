@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center mt-[50px] px-10">
    <div class="bg-white shadow w-full rounded-md p-4">
        <h2 class="font-semibold text-xl">Tambah Data Pengguna</h2>
        <form action="{{route('user.update', $user->id)}}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PUT')
            <div class="w-full mt-5">
                <div class="flex flex-col gap-1">
                    <label for="name">Nama</label>
                    <input id="name" name="name" type="text" value="{{old('name', $user->name)}}" required placeholder="Masukkan Nama" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="nik">NIK</label>
                    <input id="nik" name="nik" type="text" value="{{old('nik', $user->nik)}}" required placeholder="Masukkan NIK" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="email">Email</label>
                    <input id="email" name="email" value="{{old('email', $user->email)}}" type="email" required placeholder="Masukkan Email" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="type">Peran</label>
                    <select name="type" class="w-full p-1 border border-gray-300" id="type">
                        <option value="">Pilih Peran</option>
                        <option value="spg" {{old('type', $user->type) == 'spg' ? 'selected' : ''}}>SPG</option>
                        <option value="sales" {{old('type', $user->type) == 'sales' ? 'selected' : ''}}>Sales</option>
                        <option value="admin" {{old('type', $user->type) == 'admin' ? 'selected' : ''}}>Admin</option>
                    </select>
                </div>
                <div id="radioRole" class="{{$user->type !== 'spg' ? 'hidden' : 'block'}} my-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="role" id="role" value="supervisor" {{$user->role == 'supervisor' ? 'checked' : ''}}>
                        <span class="ml-2">Supervisor</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" name="role" id="role" value="" {{$user->role == '' ? 'checked' : ''}}>
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
                    <input id="password" name="password" value="{{old('password')}}" type="password" placeholder="Masukkan Password" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <input type="hidden" name="user_name" value="alvine">
                <input type="hidden" name="user_type" value="admin">
                <input type="hidden" name="user_id" value="1">
            </div>

            <div class="mt-5 flex justify-between items-center gap-2">
                <a href="/user" class="w-full p-1 rounded text-center bg-red-500 text-white hover:bg-red-600 duration-200">Batal</a>
                <button type="submit" class="w-full p-1 rounded bg-blue-500 text-white hover:bg-blue-600 duration-200">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection