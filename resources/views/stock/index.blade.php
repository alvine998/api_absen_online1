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
                        <th class="border border-black bg-gray-300 px-4 py-2">Nama Produk</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Jumlah Produk</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stock as $stocks)
                    <tr>
                        <td class="border px-4 py-2 border-black text-center">
                            {{$stocks->created_at}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            @foreach($stocks->products as $item)
                            <p>{{ $item['name'] }} - {{ $item['qty'] }} - Rp {{ number_format($item['price'], 0) }}</p>
                            @endforeach
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            {{number_format($stocks->total_qty, 0)}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            Rp {{number_format($stocks->total_price, 0)}}
                        </td>
                        <!-- <td class="border px-4 py-2 border-black text-center flex gap-5 justify-center items-center">
                            <a href="{{route('stock.edit', $stocks)}}" class="text-green-700 hover:text-green-600 text-3xl"><i class="fas fa-pen-square"></i></a>
                            <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')" action="{{route('stock.destroy', $stocks->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-700 hover:text-red-700 text-3xl"><i class="fas fa-trash"></i></button>
                            </form>
                        </td> -->
                    </tr>
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