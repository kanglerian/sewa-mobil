<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cars') }}
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
            <a href="{{ route('cars.create') }}" class="inline-block underline mb-5">Tambah</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        No.
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Merk
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Model
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Plat Nomor
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Harga / Hari
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Ketersediaan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($data as $key => $item)
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $data->perPage() * ($data->currentPage() - 1) + $key + 1 }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $item->brand }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $item->type }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $item->plate_number }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $item->rates }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $item->available ? 'Tersedia' : 'Tidak tersedia' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('cars.edit', $item->id) }}" class="underline">Edit</a>
                                            <a href="{{ route('cars.show', $item->id) }}" class="underline">Show</a>
                                            <form action="{{ route('cars.destroy', $item->id) }}" method="post" class="inline" onsubmit="return confirm('Are you sure you want to delete?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="underline">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center">Data not available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
