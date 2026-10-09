<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Import Data Mahasiswa
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">
                        Import Data Mahasiswa
                    </h3>
                    <p class="text-gray-600">
                        Upload file Excel untuk menambahkan data mahasiswa ke dalam sistem.
                    </p>
                </div>

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-6 rounded border border-gray-200 bg-gray-50 p-4">
                    <h4 class="font-semibold text-gray-900 mb-2">
                        Format File Excel
                    </h4>
                    <p class="text-sm text-gray-600 mb-3">
                        Pastikan baris pertama Excel memiliki nama kolom berikut:
                    </p>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse bg-white text-sm">
                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="border p-2">NIM</th>
                                    <th class="border p-2">Nama</th>
                                    <th class="border p-2">Jurusan</th>
                                    <th class="border p-2">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border p-2">230001</td>
                                    <td class="border p-2">Budi Santoso</td>
                                    <td class="border p-2">Informatika</td>
                                    <td class="border p-2">budi@gmail.com</td>
                                </tr>
                                <tr>
                                    <td class="border p-2">230002</td>
                                    <td class="border p-2">Siti Aminah</td>
                                    <td class="border p-2">Sistem Informasi</td>
                                    <td class="border p-2">siti@gmail.com</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <form action="{{ route('mahasiswa.import.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-5">
                        <label for="file" class="block mb-2 font-semibold text-gray-700">
                            File Excel <span class="text-red-600">*</span>
                        </label>
                        <input
                            type="file"
                            id="file"
                            name="file"
                            class="w-full rounded border border-gray-300 p-3 text-sm focus:border-blue-600 focus:outline-none"
                            accept=".xlsx,.xls"
                            required
                        >
                        <p class="mt-2 text-sm text-gray-500">
                            Format yang diperbolehkan: XLS dan XLSX. Maksimal ukuran file 10 MB.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="rounded bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
                            Import Data
                        </button>
                        <a href="{{ route('mahasiswa.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                            Kembali ke Data Mahasiswa
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
