<?php

namespace App\Model;

use App\Model\Ref\RefKecamatanSijali;
use App\Model\Ref\RefKelurahanSijali;
use Illuminate\Database\Eloquent\Model;

use App\Model\Jalan\JalanLingkunganFoto;
use App\Model\Jalan\JalanLingkunganUpdate;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocalJalanLingkungan extends Model
{
    use HasFactory;
    protected $table = 'jalan_lingkungan';

    use SoftDeletes;
    const DELETED_AT = 'Deleted_at';

    public function kec()
    {
        return $this->belongsTo(RefKecamatanSijali::class, 'Kecamatan', 'id_kecamatan');
    }

    public function kel()
    {
        return $this->belongsTo(RefKelurahanSijali::class, 'Kelurahan', 'id_kelurahan');
    }

    public function data_update()
    {
        return $this->hasOne(JalanLingkunganUpdate::class, 'jalan_lingkungan_id');
    }

    public function data_foto()
    {
        return $this->hasMany(JalanLingkunganFoto::class, 'jalan_lingkungan_id');
    }
    public function jalan(): HasMany
    {
        return $this->hasMany(LocalJalanLingkunganCoord::class, 'FID', 'FID');
    }
}
