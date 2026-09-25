<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Mahasiswa
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('mahasiswa.create') }}"
                       class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        + Tambah Mahasiswa
                    </a>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="p-2 border">NIM</th>
                                <th class="p-2 border">Nama</th>
                                <th class="p-2 border">Program Studi</th>
                                <th class="p-2 border">Email</th>
                                <th class="p-2 border">Angkatan</th>
                                @if(auth()->user()->role === 'admin')
                                    <th class="p-2 border">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mahasiswas as $m)
                            <tr>
                                <td class="p-2 border">{{ $m->nim }}</td>
                                <td class="p-2 border">{{ $m->nama }}</td>
                                <td class="p-2 border">{{ $m->program_studi }}</td>
                                <td class="p-2 border">{{ $m->email }}</td>
                                <td class="p-2 border">{{ $m->angkatan }}</td>
                                @if(auth()->user()->role === 'admin')
                                <td class="p-2 border space-x-2 whitespace-nowrap">
                                    <a href="{{ route('mahasiswa.edit', $m) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('mahasiswa.destroy', $m) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td class="p-2 border text-center" colspan="6">Belum ada data mahasiswa.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
