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
            <a href="{{ route('rentals.create') }}" class="inline-block underline mb-5">Tambah</a>
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
                                        Plat Nomor
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Mobil
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Client
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Periode
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        @if (Auth::user()->role == 'U')
                                            Estimasi Biaya
                                        @else
                                            Potensi Omset
                                        @endif
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        @if (Auth::user()->role == 'U')
                                            Total Biaya
                                        @else
                                            Pendapatan
                                        @endif
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
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
                                            {{ $item->cars->plate_number }}
                                        </td>
                                        <td class="px-6 py-4 text-nowrap">
                                            {{ $item->cars->brand }}
                                        </td>
                                        <td class="px-6 py-4 text-nowrap">
                                            {{ $item->users->name }}
                                        </td>
                                        <td class="px-6 py-4 text-nowrap">
                                            {{ $item->start }} s/d
                                            {{ $item->end }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $start = Carbon\Carbon::parse($item->start);
                                                $end = Carbon\Carbon::parse($item->end);
                                                $days = $start->diffInDays($end);
                                            @endphp
                                            Rp{{ $days * $item->cars->rates }}
                                        </td>
                                        <td class="px-6 py-4">
                                            Rp{{ $item->rates ?? 0 }}
                                        </td>
                                        <td class="px-6 py-4 text-nowrap">
                                            @php
                                                $today = Carbon\Carbon::parse('2024-09-04');
                                                // $today = Carbon\Carbon::now();
                                                $start = Carbon\Carbon::parse($item->start);
                                                $end = Carbon\Carbon::parse($item->end);
                                                $available = $item->cars->available;
                                                $status = $item->status;

                                                if ($available && !$status) {
                                                    if ($today->between($start, $end)) {
                                                        $statusText = 'Ambil Sekarang';
                                                    } else {
                                                        $statusText = 'Hangus / Belum jadwal';
                                                    }
                                                } elseif (!$available && !$status) {
                                                    if ($today->between($start, $end)) {
                                                        $statusText = 'Sedang Dipakai';
                                                    } else {
                                                        $statusText = 'Kembalikan / Menunggu';
                                                    }
                                                } elseif ($available && $status) {
                                                    $statusText = 'Selesai';
                                                } else {
                                                    $statusText = 'Status Tidak Diketahui';
                                                }
                                            @endphp
                                            {{ $statusText }}
                                        </td>
                                        <td class="px-6 py-4 text-nowrap">
                                            @if ($statusText === 'Ambil Sekarang')
                                                <form action="{{ route('rentals.status', $item->id) }}" method="post"
                                                    class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="car_id" value="{{ $item->car_id }}">
                                                    <input type="hidden" name="user_id" value="{{ $item->user_id }}">
                                                    <input type="hidden" name="available" value="0">
                                                    <input type="hidden" name="status" value="0">
                                                    <button type="submit" class="underline">Ambil</button>
                                                </form>
                                            @elseif ($statusText === 'Sedang Dipakai')
                                                <form action="{{ route('rentals.status', $item->id) }}" method="post"
                                                    class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="car_id" value="{{ $item->car_id }}">
                                                    <input type="hidden" name="user_id" value="{{ $item->user_id }}">
                                                    <input type="hidden" name="available" value="1">
                                                    <input type="hidden" name="status" value="1">
                                                    @php
                                                        $start = Carbon\Carbon::parse($item->start);
                                                        $end = Carbon\Carbon::parse($item->end);
                                                        $days = $start->diffInDays($end);
                                                    @endphp
                                                    <input type="hidden" name="rates"
                                                        value="{{ $days * $item->cars->rates }}">
                                                    <button type="submit" class="underline">Kembalikan</button>
                                                </form>
                                            @endif
                                            @if (Auth::user()->role == 'A')
                                                <a href="{{ route('rentals.edit', $item->id) }}"
                                                    class="underline">Edit</a>
                                                <form action="{{ route('rentals.destroy', $item->id) }}" method="post"
                                                    class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="underline">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-4 text-center">Data not available</td>
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
