<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jn_buku extends Model
{
    protected $fillable = ['jenis'];
    public $timestamps = true;

    public function buku()
    {
    	return $this->hasMany('App\buku','id_jb');
    }
}
