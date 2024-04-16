@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center mt-[50px] px-10">
    <div class="bg-white shadow w-full rounded-md p-4">
        <h2 class="font-semibold text-xl">Ubah Data Interval Pengguna</h2>
        <form action="{{route('interval.update', $interval->id)}}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PUT')
            <div class="w-full mt-5">
                <div class="flex flex-col gap-1 mt-2">
                    <label for="user_id">Pengguna</label>
                    <select name="user_id" class="w-full p-1 border border-gray-300 uppercase" id="user_id">
                        <option value="">Pilih Pengguna</option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}" {{old('user_id', $interval->user_id) == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1 mt-2">
                    <label for="interval">Interval (detik)</label>
                    <input id="interval" name="interval" type="number" value="{{old('interval', $interval->interval)}}" required placeholder="60" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
            </div>

            <div class="mt-5 flex justify-between items-center gap-2">
                <a href="/interval" class="w-full p-1 rounded text-center bg-red-500 text-white hover:bg-red-600 duration-200">Batal</a>
                <button type="submit" class="w-full p-1 rounded bg-blue-500 text-white hover:bg-blue-600 duration-200">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection