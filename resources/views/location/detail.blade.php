@extends('layouts.app')

@section('content')
@if(session()->has('success'))
<div class="bg-green-200 w-full p-2">
    <p class="text-green-500">Berhasil Menyimpan Data!</p>
</div>
@elseif(session()->has('error'))
<div class="bg-red-200 w-full p-2">
    <p class="text-red-500">Gagal Menyimpan Data!</p>
</div>
@endif

<div class="mt-[50px] px-10">
    <div class="my-4">
        <a href="{{route('location.index')}}" class="text-gray-700 hover:text-gray-600 text-xl border p-2 rounded"><i class="fas fa-chevron-left"></i> Kembali</a>
    </div>
    <h2 class="text-2xl font-bold">Detail Lokasi Pengguna</h2>
    <div class="bg-white shadow w-full rounded-md p-4 mt-2">
        <!-- <a href="{{route('location.create')}}" class="w-auto p-2 bg-blue-500 rounded text-white">Tambah Data</a> -->
        <div class="overflow-x-auto mt-5">
            <table class="w-full table-auto pb-2">
                <thead>
                    <tr>
                        <th class="border border-black bg-gray-300 px-4 py-2">Nama Pengguna</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Latitude</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Longitude</th>
                        <th class="border border-black bg-gray-300 px-4 py-2">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($location as $locations)
                    <tr>
                        <td class="border px-4 py-2 border-black text-center">
                            {{$locations->user_name}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            {{$locations->latt}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            {{$locations->long}}
                        </td>
                        <td class="border px-4 py-2 border-black text-center">
                            {{$locations->created_at}}
                        </td>
                    </tr>
                    @empty
                    <div class="bg-red-200 w-full p-2 rounded-md my-2">
                        <p class="text-red-500">Data Lokasi Tidak Tersedia</p>
                    </div>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{$location->links()}}
    </div>
</div>
<div class="px-10 mt-10">
    <div id="map"></div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // Initialize the map
    var locations = @json($location);
    var map = L.map('map').setView([locations.data[0].latt, locations.data[0].long], 13);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    var waypoints = [];

    // Add a marker
    locations.data.forEach(function(loc) {
        L.marker([loc.latt, loc.long]).addTo(map)
            .bindPopup(`${loc.latt}, ${loc.long}`)
        waypoints.push(L.latLng(loc.latt, loc.long));
    })

    // Add routing
    L.Routing.control({
        waypoints: waypoints,
        routeWhileDragging: false,
        show: false,
        router: L.Routing.osrmv1({
            language: 'en',
            units: 'metric'
        }),
        lineOptions: {
            styles: [{
                color: '#007bff',
                opacity: 0.7,
                weight: 5
            }]
        },
    }).addTo(map);
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