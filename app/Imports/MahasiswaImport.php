<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    private array $columns;

    public function __construct()
    {
        $this->columns = Schema::getColumnListing((new Mahasiswa)->getTable());
    }

    public function model(array $row)
    {
        $data = [
            'nim' => $row['nim'],
            'program_studi' => $row['jurusan'] ?? $row['program_studi'] ?? null,
            'email' => $row['email'],
        ];

        if (in_array('nama', $this->columns, true)) {
            $data['nama'] = $row['nama'];
        }

        if (in_array('nama_mahasiswa', $this->columns, true)) {
            $data['nama_mahasiswa'] = $row['nama'];
        }

        if (in_array('tempat_lahir', $this->columns, true)) {
            $data['tempat_lahir'] = $row['tempat_lahir'] ?? '-';
        }

        if (in_array('tanggal_lahir', $this->columns, true)) {
            $data['tanggal_lahir'] = $row['tanggal_lahir'] ?? '2000-01-01';
        }

        if (in_array('jenis_kelamin', $this->columns, true)) {
            $data['jenis_kelamin'] = $row['jenis_kelamin'] ?? 'Laki-laki';
        }

        if (in_array('alamat', $this->columns, true)) {
            $data['alamat'] = $row['alamat'] ?? '-';
        }

        if (in_array('no_hp', $this->columns, true)) {
            $data['no_hp'] = $row['no_hp'] ?? '0000000000';
        }

        if (in_array('angkatan', $this->columns, true)) {
            $data['angkatan'] = $row['angkatan'] ?? now()->year;
        }

        return new Mahasiswa($data);
    }
}
