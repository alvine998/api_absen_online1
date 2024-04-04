<div class="bg-blue-500">
    <div class="flex justify-between items-center h-[60px]">
        <div class="lg:ml-5">
            <h2 class="text-white text-2xl font-semibold">Absen Online</h2>
        </div>
        <div class="flex items-center justify-end px-10 gap-10">
            @if(Session::has('user'))
            <p class="text-white uppercase">Welcome, {{Session::get('user')->name}}</p>
            @endif
            <a href="{{route('welcome.logout')}}" class="text-white bg-red-700 hover:bg-red-600 p-2 rounded-md font-bold">Logout</a>
        </div>
    </div>

</div>