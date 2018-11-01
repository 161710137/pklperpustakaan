<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class buku extends Model
{
    protected $fillable = ['id_jb','judul','pengarang','isbn','thn_terbit','penerbit','tersedia'];
    public $timestamps = true;

    public function jn_buku()
    {
    	return $this->belongsTo('App\jn_buku','id_jb');
    }
}
