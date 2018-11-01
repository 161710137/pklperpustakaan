<?php

namespace App\Http\Controllers;

use App\pinjamkbl;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use App\anggota;
use App\buku;

class PinjamkblController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json(){
        $pinjam = pinjamkbl::all();
        return DataTables::of($pinjam)
        ->addColumn('anggota',function($pinjam){
            return $pinjam->anggota->nama_agt;
        })
        ->addColumn('buku',function($pinjam){
            return $pinjam->buku->judul;
        })
        ->addColumn('action',function($pinjam){
            return '<center><a href="#" class="btn btn-xs btn-primary edit" data-id_jb="'.$pinjam->id_jb.'"><i class="glyphicon glyphicon-edit"></i> Edit</a> | <a href="#" class="btn btn-xs btn-danger delete" id_jb="'.$pinjam->id_jb.'"><i class="glyphicon glyphicon-remove"></i> Delete</a></center>';
        })
        ->rawColumns(['action','anggota','buku'])->make(true);
    }
    public function index()
    {
        $anggota = anggota::all();
        $buku = buku::all();
        return view('pinjam.index',compact('anggota','buku'));
    }
    function removedata(Request $request)
    {
        $pinjam = pinjamkbl::find($request->input('id'));
        if($pinjam->delete())
        {
            echo 'Data Deleted';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request,[
            'nopjkb'=>'required',
            'id_agt'=>'required',
            'id_buku'=>'required|unique:bukus',
            'tgl_pjm'=>'required',
            'tgl_hs_kbl'=>'required',
            'denda'=>'required'
        ],[
            'nopjkb.required'=>'nopjkb tidak boleh kosong',
            'id_agt.required'=>'id_agt tidak boleh kosong',
            'id_buku.required'=>'id_buku tidak boleh kosong',
            'tgl_pjm.required'=>'tgl_pjm tidak boleh kosong',
            'tgl_hs_kbl.required'=>'tgl_hs_kbl tidak boleh kosong',
            'denda.required'=>'denda tidak boleh kosong'
        ]);
        $buku = new buku;
        $buku->nopjkb = $request->nopjkb;
        $buku->id_agt = $request->id_agt;
        $buku->id_buku = $request->id_buku;
        $buku->tgl_pjm = $request->tgl_pjm;
        $buku->tgl_hs_kbl = $request->tgl_hs_kbl;
        $buku->denda = $request->denda;
        $buku->save();
        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\pinjamkbl  $pinjamkbl
     * @return \Illuminate\Http\Response
     */
    public function show(pinjamkbl $pinjamkbl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pinjamkbl  $pinjamkbl
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pinjam = pinjamkbl::findOrFail($id);
        return $pinjam;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pinjamkbl  $pinjamkbl
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $this->validate($request,[
            'nopjkb'=>'required',
            'id_agt'=>'required',
            'id_buku'=>'required',
            'tgl_pjm'=>'required',
            'tgl_hs_kbl'=>'required',
            'denda'=>'required'
        ],[
            'nopjkb.required'=> 'nopjkb Buku tidak boleh kosong',
            'id_agt.required'=> 'id_agt Wajib diisi',
            'id_buku.required'=> 'ISBN tidak boleh kosong',
            'tgl_pjm.required'=> 'Tahun terbit harus diisi',
            'tgl_hs_kbl.required'=> 'Penerebit harus diisi',
            'denda.required'=> 'Isi stok yang ada'
        ]);
            $pinjam = pinjam::find($id);
            $pinjam->nopjkb = $request->nopjkb;
            $pinjam->id_agt  = $request->id_agt;
            $pinjam->id_buku = $request->id_buku;
            $pinjam->tgl_pjm = $request->tgl_pjm;
            $pinjam->tgl_hs_kbl = $request->tgl_hs_kbl;
            $pinjam->denda = $request->denda;
            $pinjam->save();
            return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pinjamkbl  $pinjamkbl
     * @return \Illuminate\Http\Response
     */
    public function destroy(pinjamkbl $pinjamkbl)
    {
        //
    }
}
