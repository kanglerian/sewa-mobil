<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rental Cars') }}
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
                <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-2xl" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('errors') }}
                    </div>
                </div>
            @endif
            <form method="POST" action="{{ route('rentals.store') }}" class="max-w-sm">
                @csrf
                @if (Auth::user()->role == 'A')
                    <div class="mb-5">
                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900">Client</label>
                        <select id="user_id" name="user_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                @endif
                <div class="mb-5">
                    <label for="car_id" class="block mb-2 text-sm font-medium text-gray-900">Mobil</label>
                    <select id="car_id" name="car_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required>
                        @foreach ($cars as $car)
                            <option value="{{ $car->id }}">{{ $car->plate_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-5">
                    <label for="start" class="block mb-2 text-sm font-medium text-gray-900">Tanggal mulai</label>
                    <input type="date" id="start" name="start" value="{{ old('start') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required />
                </div>
                <div class="mb-5">
                    <label for="end" class="block mb-2 text-sm font-medium text-gray-900">Tanggal akhir</label>
                    <input type="date" id="end" name="end" value="{{ old('end') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required />
                </div>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
            </form>
        </div>
    </div>
</x-app-layout>
