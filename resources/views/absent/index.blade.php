@extends('layouts.app')

@section('content')
@if(session()->has('success'))
<div class="bg-green-200 w-full p-2">
    <p class="text-green-500">Berhasil Menyimpan Data!</p>
</div>
@elseif(session()->has('error'))
<div class="bg-red-200 w-full p-2">
    <p class="text-red-500">Berhasil Menyimpan Data!</p>
</div>
@endif

<div class="mt-[50px] px-10">
    <h2 class="text-2xl font-bold">Absensi</h2>
    <div class="bg-white shadow w-full rounded-md p-4 mt-2">
        <div class="overflow-x-auto mt-5">
            <table class="w-full table-auto pb-2">
                <thead>
                    <tr>
                        <th class="border border-black bg-gray-300 px-4 py-2">Toko</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Nama</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Waktu</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Latitude</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Longitude</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Jenis Absen</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Gambar</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($absent as $absents)
                    <tr>
                        <td class="border px-4 py-2 border-black">
                            {{$absents->store_name}}
                        </td>
                        <td class="border px-4 py-2 border-black">
                            {{$absents->spg_name}}
                        </td>
                        <td class="border px-4 py-2 border-black">
                            <p>
                                {{$absents->date}} {{$absents->time}}
                            </p>
                        </td>
                        <td class="border px-4 py-2 border-black">
                            <p>
                                {{$absents->latt}}
                            </p>
                        </td>
                        <td class="border px-4 py-2 border-black">
                            <p>
                                {{$absents->long}}
                            </p>
                        </td>
                        <td class="border px-4 py-2 border-black">
                            <p>
                                {{$absents->type}}
                            </p>
                        </td>
                        <td class="border px-4 py-2 border-black">
                            <p>
                                {{$absents->note}}
                            </p>
                        </td>
                        <td class="border px-4 py-2 border-black flex items-center justify-center">
                            <img src="{{Storage::url('storage/').$absents->image}}" alt="img-absent" class="w-[150px] h-[150px]">
                        </td>
                    </tr>
                    @empty
                    <div class="bg-red-200 w-full p-2 rounded-md my-2">
                        <p class="text-red-500">Data Pengunjung Tidak Tersedia</p>
                    </div>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{$absent->links()}}
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