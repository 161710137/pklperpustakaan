<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anggota extends Model
{
    protected $fillable = ['id_agt','no_agt','nama_agt','alamat','kota','telp'];
    public $timestamps = true;
}
