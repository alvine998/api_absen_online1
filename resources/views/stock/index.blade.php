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
    <h2 class="text-2xl font-bold">Stok</h2>
    <div class="bg-white shadow w-full rounded-md p-4 mt-2">
        <!-- <a href="{{route('stock.create')}}" class="w-auto p-2 bg-blue-500 rounded text-white">Tambah Data</a> -->
        <div class="overflow-x-auto mt-5">
            <table class="w-full table-auto pb-2">
                <thead>
                    <tr>
                        <th class="border border-black bg-gray-300 px-4 py-2">Tanggal</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">No Referensi</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Kode SO</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Nama Sales</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Kode Toko</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Nama Toko</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Produk</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Jumlah Produk</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Total Harga</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stock as $stocks)
                    <tr>
                        <td class="border px-4 py-2 border-black text-center">
                            {{$stocks->created_at}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            {{$stocks->ref_no ? $stocks->ref_no : "-"}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            {{$stocks->so_code}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            {{$stocks->user_name}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            {{$stocks->store_code ? $stocks->store_code : "-"}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            {{$stocks->store_name ? $stocks->store_name : "-"}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            <ul>
                                @foreach($stocks->products as $item)
                                <ol>{{ $item['code'] ? $item['code'] : "" }} - {{ $item['name'] }} - {{ $item['qty'] }} - Rp {{ number_format($item['price'], 0) }}</ol>
                                @endforeach
                            </ul>
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            {{number_format($stocks->total_qty, 0)}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            Rp {{number_format($stocks->total_price, 0)}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            <button onclick="toggleModal('modal')" class="bg-green-700 p-2 rounded text-white">
                                Kode Referensi
                            </button>
                        </td>
                    </tr>
                    <!-- Modal Component -->
                    <x-modal-component>
                        <form action="{{route('stock.update', $stocks->id)}}" enctype="multipart/form-data" method="post">
                            @csrf
                            @method('PUT')
                            <div class="flex flex-col gap-1">
                                <label for="ref_no">Kode Refensi</label>
                                <input id="ref_no" name="ref_no" type="text" value="{{old('ref_no', $stocks->ref_no)}}" required placeholder="Masukkan Kode Referensi" class="w-full p-1 pl-2 rounded border border-gray-300" />
                            </div>
                            <button type="submit" class="w-full p-1 rounded bg-blue-500 text-white hover:bg-blue-600 duration-200 mt-4">Simpan</button>
                        </form>
                    </x-modal-component>
                    @empty
                    <div class="bg-red-200 w-full p-2 rounded-md my-2">
                        <p class="text-red-500">Data Toko Tidak Tersedia</p>
                    </div>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{$stock->links()}}
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    function toggleModal(modalID) {
        document.getElementById(modalID).classList.toggle("hidden");
        document.getElementById(modalID).classList.toggle("flex");
    }
</script>
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