<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Absen Online</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

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
    <div class="flex justify-center items-center mt-[150px]">
        <div class="bg-blue-200 lg:w-[350px] lg:h-[250px] rounded-md p-4">
            <h2 class="text-2xl font-semibold text-center">LOGIN</h2>
            <form action="{{route('welcome.login')}}" method="POST">
                @csrf
                <div class="flex flex-col gap-1">
                    <label for="nik">NIK</label>
                    <input id="nik" name="nik" type="text" value="{{old('nik')}}" autofocus placeholder="Masukkan NIK" class="w-full p-1 pl-2 rounded" />
                </div>
                <div class="flex flex-col gap-1 mt-2">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" placeholder="Masukkan Password" class="w-full p-1 pl-2 rounded" />
                </div>
                <div class="mt-5">
                    <button type="submit" class="w-full p-1 rounded bg-blue-500 text-white">Masuk</button>
                </div>
            </form>
            @if ($errors->any())
            <div class="mt-10">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li class="text-red-500">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>

</body>

</html>