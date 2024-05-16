@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center mt-[50px] px-10">
    <div class="bg-white shadow w-full rounded-md p-4">
        <h2 class="font-semibold text-xl">Tambah Data Sales Toko</h2>
        <form action="{{route('membersales.store')}}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="w-full mt-5">
                <div class="flex flex-col gap-1 mt-2">
                    <label for="store_id">Toko</label>
                    <select name="store_id" class="w-full p-1 border border-gray-300" id="store_id">
                        <option value="">Pilih Toko</option>
                        @foreach ($stores as $store)
                        <option class="uppercase" value="{{$store->id}}">{{$store->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1 mt-2">
                    <label for="members">Sales</label>
                    <select name="members" class="w-full p-1 border border-gray-300" id="selectOptions">
                        <option value="">Pilih Sales</option>
                    </select>
                </div>

                <input type="hidden" name="users" id="users">

                <div id="selectedOptions" class="flex justify-center items-center gap-2">

                </div>

                <script>
                    const selectElements = document.getElementById('selectOptions');
                    const selectedElements = document.getElementById('selectedOptions');

                    let selectedOptions = [];
                    let members = [];
                    let usrs = [];
                    document.addEventListener('DOMContentLoaded', function() {
                        members = @json($sales).data;
                        selectedOptions = [];

                        members.forEach(member => {
                            const option = document.createElement('option');
                            option.value = member.id;
                            option.className = "uppercase";
                            option.textContent = member.name;
                            selectElements.appendChild(option);
                        })
                    })

                    selectElements.addEventListener('change', function() {
                        const selectedOption = this.options[this.selectedIndex];
                        if (selectedOption.value !== "") {
                            selectElements.removeChild(selectedOption);
                            selectedOptions.push(selectedOption);
                            usrs.push({id: selectedOption.value})
                            $('#users').val(JSON.stringify(usrs));

                            const div = document.createElement('div');
                            const icon = document.createElement('i');
                            div.className = "bg-blue-500 p-2 rounded w-auto my-2 text-white flex items-center gap-2 uppercase";
                            div.textContent = selectedOption.textContent;
                            icon.className = "text-white fas fa-times cursor-pointer"
                            icon.onclick = function() {
                                selectedElements.removeChild(div);
                                selectElements.append(selectedOption);
                            }
                            div.appendChild(icon)
                            selectedElements.appendChild(div);
                        }
                    });
                </script>

            </div>

            <div class="mt-5 flex justify-between items-center gap-2">
                <a href="/membersales" class="w-full p-1 rounded text-center bg-red-500 text-white hover:bg-red-600 duration-200">Batal</a>
                <button type="submit" class="w-full p-1 rounded bg-blue-500 text-white hover:bg-blue-600 duration-200">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection