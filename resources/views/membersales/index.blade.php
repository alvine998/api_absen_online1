@extends('layouts.app')

@section('content')
@if(session()->has('success'))
<div class="bg-green-200 w-full p-2">
    <p class="text-green-500">{{session('success')}}</p>
</div>
@elseif(session()->has('error'))
<div class="bg-red-200 w-full p-2">
    <p class="text-red-500">{{session('error')}}</p>
</div>
@endif

<div class="mt-[50px] px-10">
    <h2 class="text-2xl font-bold">Sales Toko</h2>
    <div class="bg-white shadow w-full rounded-md p-4 mt-2">
        <a href="{{route('membersales.create')}}" class="w-auto p-2 bg-blue-500 rounded text-white">Tambah Data</a>
        <div class="overflow-x-auto mt-5">
            <table class="w-full table-auto pb-2">
                <thead>
                    <tr>
                        <th class="border border-black bg-gray-300 px-4 py-2">Toko</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Sales</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($membersaless as $members)
                    <tr>
                        <td class="border px-4 py-2 border-black uppercase text-center">
                            {{$members->store_name}}
                        </td>
                        <td class="border px-4 py-2 border-black uppercase text-center">
                            {{$members->user_name}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center flex gap-5 justify-center items-center">
                            <!-- <a href="{{route('user.edit', $members)}}" class="text-green-700 hover:text-green-600 text-3xl"><i class="fas fa-pen-square"></i></a> -->
                            <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')" action="{{route('membersales.destroy', $members->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-700 hover:text-red-700 text-3xl"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <div class="bg-red-200 w-full p-2 my-2 rounded-md">
                        <p class="text-red-500">Data Sales Toko Tidak Tersedia</p>
                    </div>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{$membersaless->links()}}
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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