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
    <h2 class="text-2xl font-bold">Kunjungan</h2>
    <div class="bg-white shadow w-full rounded-md p-4 mt-2">
        <div class="overflow-x-auto mt-5">
            <table class="w-full table-auto pb-2">
                <thead>
                    <tr>
                        <th class="border border-black bg-gray-300 px-4 py-2">Nama Sales</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Kode Toko</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Nama Toko</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Waktu</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Latitude</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Longitude</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Foto</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($visitor as $visitors)
                    <tr>
                        <td class="border px-4 py-2 border-black">
                            {{json_decode(str_replace("'",'"',$visitors->user_login), true)["user_name"]}}
                        </td>
                        <td class="border px-4 py-2 border-black">
                            {{$visitors->store_code}}
                        </td>
                        <td class="border px-4 py-2 border-black">
                            {{$visitors->store_name}} ({{$visitors->store_type}})
                        </td>
                        <td class="border px-4 py-2 border-black">
                            <p>
                                Check In: {{$visitors->in_date}} {{$visitors->in_time}}<br />
                                Check Out: {{$visitors->out_date}} {{$visitors->out_time}}
                            </p>
                        </td>
                        <td class="border px-4 py-2 border-black">
                            <p>
                                Check In: {{$visitors->in_lat}}<br />
                                Check Out: {{$visitors->out_lat}}
                            </p>
                        </td>
                        <td class="border px-4 py-2 border-black">
                            <p>
                                Masuk: {{$visitors->in_long}}<br />
                                Pulang: {{$visitors->out_long}}
                            </p>
                        </td>
                        <td class="border px-4 py-2 border-black justify-center h-full">
                            @php
                                $images = json_decode($visitors->image, true);
                            @endphp
                            
                            @if(is_array($images))
                                @foreach ($images as $item)
                                    <a href="{{ Storage::url($item) }}" target="_blank" class="block">{{ $item }}</a>
                                @endforeach
                            @else
                                <p>No images available</p>
                            @endif
                            <!-- <img src="{{Storage::url('storage/').$visitors->image}}" alt="img-absent" class="w-[150px] h-[150px]"> -->
                        </td>
                        <td class="border px-4 py-2 border-black">
                            {{$visitors->note}}
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

        {{$visitor->links()}}
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
