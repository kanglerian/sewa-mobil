<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Car') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-emerald-500 text-emerald-50 rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if (session('errors'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('errors') }}
                    </div>
                </div>
            @endif
            <form method="POST" action="{{ route('cars.update', $car->id) }}" class="max-w-sm">
                @csrf
                @method('PATCH')
                <div class="mb-5">
                    <label for="brand" class="block mb-2 text-sm font-medium text-gray-900">Merk</label>
                    <input type="text" id="brand" name="brand" value="{{ $car->brand }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Merk" required />
                </div>
                <div class="mb-5">
                    <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Model</label>
                    <input type="text" id="type" name="type" value="{{ $car->type }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Model" required />
                </div>
                <div class="mb-5">
                    <label for="plate_number" class="block mb-2 text-sm font-medium text-gray-900">Plat Nomor</label>
                    <input type="text" id="plate_number" name="plate_number" value="{{ $car->plate_number }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Plat Nomor" required />
                </div>
                <div class="mb-5">
                    <label for="rates" class="block mb-2 text-sm font-medium text-gray-900">Harga Sewa/Jam</label>
                    <input type="number" id="rates" name="rates" value="{{ $car->rates }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Rp0" required />
                </div>
                <div class="mb-5">
                    <label for="available" class="block mb-2 text-sm font-medium text-gray-900">Ketersediaan</label>
                    <select id="available" name="available" value="{{ $car->available }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required>
                        <option value="{{ $car->available }}">{{ $car->available ? 'Tersedia' : 'Tidak tersedia' }}</option>
                        <option value="1">Tersedia</option>
                        <option value="0">Tidak tersedia</option>
                    </select>
                </div>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
            </form>
        </div>
    </div>
</x-app-layout>
