<?php

namespace App\Jobs;

use App\Imports\MahasiswaImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportMahasiswaJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $filePath
    ) {
    }

    public function handle(): void
    {
        Log::info('Import mahasiswa dimulai.', [
            'file' => $this->filePath,
        ]);

        Excel::import(
            new MahasiswaImport,
            $this->filePath
        );

        Log::info('Import mahasiswa selesai.', [
            'file' => $this->filePath,
        ]);
    }
}
