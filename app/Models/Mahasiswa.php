<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Mahasiswa extends Model
{
    protected $fillable = [
        'nim',
        'nama',
        'nama_mahasiswa',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'program_studi',
        'no_hp',
        'email',
        'angkatan',
    ];

    public function getNamaAttribute($value)
    {
        return $value ?? $this->attributes['nama_mahasiswa'] ?? null;
    }

    public function setNamaAttribute($value): void
    {
        $column = Schema::hasColumn($this->getTable(), 'nama')
            ? 'nama'
            : 'nama_mahasiswa';

        $this->attributes[$column] = $value;
    }

    public function getAngkatanAttribute($value)
    {
        return $value ?? '-';
    }
}
