@extends('layouts.app')

@section('content')
@if(session()->has('success'))
<div class="bg-green-200 w-full p-2">
    <p class="text-green-500">Berhasil Menyimpan Data!</p>
</div>
@elseif(session()->has('error'))
<div class="bg-red-200 w-full p-2">
    <p class="text-red-500">Gagal Menyimpan Data!</p>
</div>
@endif

<div class="mt-[50px] px-10">
    <h2 class="text-2xl font-bold">Set Interval</h2>
    <div class="bg-white shadow w-full rounded-md p-4 mt-2">
        <a href="{{route('interval.create')}}" class="w-auto p-2 bg-blue-500 rounded text-white">Tambah Data</a>
        <div class="overflow-x-auto mt-5">
            <table class="w-full table-auto pb-2">
                <thead>
                    <tr>
                        <th class="border border-black bg-gray-300 px-4 py-2">Nama Pengguna</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Interval (detik)</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($interval as $intervals)
                    <tr>
                        <td class="border px-4 py-2 border-black text-center uppercase">
                            {{$intervals->user_name}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            {{$intervals->interval}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center flex gap-5 justify-center items-center">
                            <a href="{{route('interval.edit', $intervals)}}" class="text-green-700 hover:text-green-600 text-3xl"><i class="fas fa-pen-square"></i></a>
                            <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')" action="{{route('interval.destroy', $intervals->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-700 hover:text-red-700 text-3xl"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <div class="bg-red-200 w-full p-2 rounded-md my-2">
                        <p class="text-red-500">Data Produk Tidak Tersedia</p>
                    </div>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{$interval->links()}}
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    let modal = document.getElementById('modal');
    let btn = document.getElementById('open-btn');
    let button = document.getElementById('ok-btn');

    btn.onclick = function() {
        modal.style.display = 'block';
    };

    button.onclick = function() {
        modal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection