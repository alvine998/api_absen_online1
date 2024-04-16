@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center mt-[50px] px-10">
    <div class="bg-white shadow w-full rounded-md p-4">
        <h2 class="font-semibold text-xl">Ubah Data Produk</h2>
        <form action="{{route('product.update', $product->id)}}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PUT')
            <div class="w-full mt-5">
                <div class="flex flex-col gap-1">
                    <label for="code">Kode Produk</label>
                    <input id="code" name="code" type="text" value="{{old('code', $product->code)}}" required placeholder="Masukkan Kode Produk" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="name">Nama</label>
                    <input id="name" name="name" type="text" value="{{old('name', $product->name)}}" required placeholder="Masukkan Nama" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="qty">Jumlah Produk</label>
                    <input id="qty" name="qty" type="number" value="{{old('qty', $product->qty)}}" required placeholder="Masukkan Jumlah Produk" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="price">Harga Satuan (Rp)</label>
                    <input id="price" name="price" type="number" value="{{old('price', $product->price)}}" required placeholder="Masukkan Harga Satuan" class="w-full p-1 pl-2 rounded border border-gray-300" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="note">Keterangan</label>
                    <textarea id="note" name="note" value="{{old('note', $product->note)}}" type="text" placeholder="Masukkan Keterangan" class="w-full p-1 pl-2 rounded border border-gray-300"></textarea>
                </div>
            </div>

            <div class="mt-5 flex justify-between items-center gap-2">
                <a href="/product" class="w-full p-1 rounded text-center bg-red-500 text-white hover:bg-red-600 duration-200">Batal</a>
                <button type="submit" class="w-full p-1 rounded bg-blue-500 text-white hover:bg-blue-600 duration-200">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection