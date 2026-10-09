<?php

namespace App\Http\Controllers;

use App\Jobs\ImportMahasiswaJob;
use Illuminate\Http\Request;

class MahasiswaImportController extends Controller
{
    /**
     * Menampilkan halaman import.
     */
    public function create()
    {
        return view('mahasiswa.import');
    }

    /**
     * Upload dan memasukkan proses import ke dalam queue.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'file' => [
                    'required',
                    'file',
                    'mimes:xlsx,xls',
                    'max:10240',
                ],
            ],
            [
                'file.required' => 'File Excel wajib dipilih.',
                'file.file' => 'File yang diupload tidak valid.',
                'file.mimes' => 'File harus berformat XLS atau XLSX.',
                'file.max' => 'Ukuran file maksimal 10 MB.',
            ]
        );

        $path = $request->file('file')->store('imports');

        ImportMahasiswaJob::dispatch($path);

        return redirect()
            ->route('mahasiswa.import')
            ->with(
                'success',
                'File berhasil diupload dan sedang diproses.'
            );
    }
}
