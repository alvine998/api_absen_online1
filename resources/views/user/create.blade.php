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
    <div class="flex justify-center items-center mt-[50px] px-10">
        <div class="bg-white shadow w-full rounded-md p-4">
            <h2 class="font-semibold text-xl">Tambah Data Pengguna</h2>
            <form action="{{route('user.store')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="w-full mt-5">
                    <div class="flex flex-col gap-1">
                        <label for="name">Nama</label>
                        <input id="name" name="name" type="text" value="{{old('name')}}" required placeholder="Masukkan Nama" class="w-full p-1 pl-2 rounded border border-gray-300" />
                    </div>
                    <div class="flex flex-col gap-1 mt-2">
                        <label for="nik">NIK</label>
                        <input id="nik" name="nik" type="text" value="{{old('nik')}}" required placeholder="Masukkan NIK" class="w-full p-1 pl-2 rounded border border-gray-300" />
                    </div>
                    <div class="flex flex-col gap-1 mt-2">
                        <label for="email">Email</label>
                        <input id="email" name="email" value="{{old('email')}}" type="email" required placeholder="Masukkan Email" class="w-full p-1 pl-2 rounded border border-gray-300" />
                    </div>
                    <div class="flex flex-col gap-1 mt-2">
                        <label for="type">Peran</label>
                        <select name="type" class="w-full p-1 border border-gray-300" id="type">
                            <option value="">Pilih Peran</option>
                            <option value="spg">SPG</option>
                            <option value="sales">Sales</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1 mt-2">
                        <label for="password">Password</label>
                        <input id="password" name="password" value="{{old('password')}}" type="password" required placeholder="Masukkan Password" class="w-full p-1 pl-2 rounded border border-gray-300" />
                    </div>
                    <input type="hidden" name="user_name" value="alvine">
                    <input type="hidden" name="user_type" value="admin">
                    <input type="hidden" name="user_id" value="1">
                </div>

                <div class="mt-5 flex justify-between items-center gap-2">
                    <button type="button" class="w-full p-1 rounded bg-red-500 text-white hover:bg-red-600 duration-200">Batal</button>
                    <button type="submit" class="w-full p-1 rounded bg-blue-500 text-white hover:bg-blue-600 duration-200">Simpan</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>