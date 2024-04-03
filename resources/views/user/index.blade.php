<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Absen Online</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <!-- Styles -->
    <link rel="stylesheet" href="../css/app.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body class="antialiased">
    @if(session()->has('success'))
    <div class="bg-green-200 w-full p-2">
        <p class="text-green-500">Berhasil Menyimpan Data!</p>
    </div>
    @elseif(session()->has('error'))
    <div class="bg-red-200 w-full p-2">
        <p class="text-red-500">Berhasil Menyimpan Data!</p>
    </div>
    @endif

    <div class="flex justify-center items-center mt-[50px] px-10">
        <div class="bg-white shadow w-full rounded-md p-4">
            <a href="{{route('user.create')}}" class="w-auto p-2 bg-blue-500 rounded text-white">Tambah Data</a>
            <div class="overflow-x-auto mt-5">
                <table class="w-full table-auto pb-2">
                    <thead>
                        <tr>
                            <th class="border border-black bg-gray-300 px-4 py-2">Nama</th>
                            <th class="border border-black bg-gray-300 px-4 py-2">NIK</th>
                            <th class="border border-black bg-gray-300 px-4 py-2">Email</th>
                            <th class="border border-black bg-gray-300 px-4 py-2">Peran</th>
                            <th class="border border-black bg-gray-300 px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user as $users)
                        <tr>
                            <td class="border px-4 py-2 border-black">
                                {{$users->name}}
                            </td>
                            <td class="border px-4 py-2 border-black">
                                {{$users->nik}}
                            </td>
                            <td class="border px-4 py-2 border-black">
                                {{$users->email}}
                            </td>
                            <td class="border px-4 py-2 border-black">
                                {{$users->type}}
                            </td>
                            <td class="border px-4 py-2 border-black text-center flex gap-5 justify-center items-center">
                                <a href="{{route('user.edit', $users)}}" class="text-green-700 hover:text-green-600 text-3xl"><i class="fas fa-pen-square"></i></a>
                                <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')" action="{{route('user.destroy', $users->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-700 hover:text-red-700 text-3xl"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <div class="bg-red-200 w-full">
                            <p class="text-red-500">Data Pengguna Tidak Tersedia</p>
                        </div>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{$user->links()}}
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
</body>

</html>