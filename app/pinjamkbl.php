<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pinjamkbl extends Model
{
    protected $fillable = ['nopjkb','id_agt','id_buku','tgl_pjm','tgl_hrs_kbl','tgl_kbl','denda'];
    public $timestamps = true;

    public function Anggota(){
        return $this->belongsTo('App\anggota','id_agt');
    }
    public function Buku(){
        return $this->belongsTo('App\buku','id_buku');
    }
}
