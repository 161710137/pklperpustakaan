<?php

namespace App\Http\Controllers;

use App\pinjamkbl;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use App\anggota;
use App\buku;
use Carbon\Carbon;

class PinjamkblController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        $this->middleware('auth');
    }
    public function json()
    {
        $pinjam = pinjamkbl::where('tgl_kbl','=',null)->get();
        return DataTables::of($pinjam)
        ->addColumn('buku',function($data){
            return $data->Buku->judul;
        })
        
        ->addColumn('anggota',function($data){
            return $data->Anggota->nama_agt;
        })
        ->addColumn('action',function($pinjam){
            return '<center><a href="#" class="btn btn-xs btn-primary edit" data-id="'.$pinjam->id.'"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
        })
        ->rawColumns(['action','anggota','buku'])->make(true);
    }
    public function json_kbl()
    {
        $pinjam = pinjamkbl::all();
        return DataTables::of($pinjam)
        ->addColumn('buku',function($data){
            return $data->Buku->judul;
        })
        
        ->addColumn('anggota',function($data){
            return $data->Anggota->nama_agt;
        })
        ->rawColumns(['anggota','buku'])->make(true);
    }
    public function index()
    {
        $anggota = anggota::where('status','=',0)->get();
        $buku = buku::where('tersedia','>',0)->get();
        return view('pinjam.index',compact('anggota','buku'));
    }
    public function indexkembali()
    {
        $kembali = pinjamkbl::where('tgl_kbl','=',null)->get();
        return view('kembali.index',compact('kembali'));
    }
    public function myformAjax($id,Request $request)
    {
        $sub = pinjamkbl::find($id);
        $sub['agt']= $sub->Anggota->nama_agt;
        $sub['uku']= $sub->Buku->judul;
        $sub['pjm']= $sub->tgl_pjm;
        $sub['hrs_kbl']= $sub->tgl_hrs_kbl;
        return $sub;
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
            'tgl_pjm'=>'required',
            'tgl_hrs_kbl'=>'required'
        ],[
            'nopjkb.required'=>'nopjkb tidak boleh kosong',
            'tgl_pjm.required'=>'tgl_pjm tidak boleh kosong',
            'tgl_hrs_kbl.required'=>'tgl_hrs_kbl tidak boleh kosong'
        ]);
        $pinjam = new pinjamkbl;
        $pinjam->nopjkb = $request->nopjkb;
        $pinjam->id_agt = $request->id_agt;
        $pinjam->id_buku = $request->id_buku;
        $pinjam->tgl_pjm = $request->tgl_pjm;
        $pinjam->tgl_hrs_kbl = $request->tgl_hrs_kbl;
        $pinjam->save();

        $stock = buku::where('id', $pinjam->id_buku)->first();
        $stock->tersedia = $stock->tersedia - 1;
        $stock->save();

        $agt = anggota::where('id',$pinjam->id_agt)->first();
        $agt->status = $agt->status + 1;
        $agt->save();

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
            // 'id_agt'=>'required',
            // 'id_buku'=>'required',
            'tgl_pjm'=>'required',
            'tgl_hrs_kbl'=>'required',
            'denda'=>'required'
        ],[
            'nopjkb.required'=> 'nopjkb Buku tidak boleh kosong',
            'id_agt.required'=> 'id_agt Wajib diisi',
            'id_buku.required'=> 'ISBN tidak boleh kosong',
            'tgl_pjm.required'=> 'Tahun terbit harus diisi',
            'tgl_hrs_kbl.required'=> 'Penerbit harus diisi',
            'denda.required'=> 'Isi stok yang ada'
        ]);
            $pinjam = pinjamkbl::find($id);
            $pinjam->nopjkb = $request->nopjkb;
            // $pinjam->id_agt  = $request->id_agt;
            // $pinjam->id_buku = $request->id_buku;
            $pinjam->tgl_pjm = $request->tgl_pjm;
            $pinjam->tgl_hrs_kbl = $request->tgl_hrs_kbl;
            $pinjam->denda = $request->denda;
            $pinjam->save();
            return response()->json(['success'=>true]);
    }
     public function updatekembali($id,Request $request)
    {
        $this->validate($request,[
            'tgl_kbl'=>'required'
        ],[
            'tgl_kbl.required'=> 'Penerebit harus diisi'
        ]);
            $pinjam = pinjamkbl::find($id);
            $pinjam->tgl_kbl = $request->tgl_kbl;

            $tanggal= new Carbon($pinjam->tgl_kbl);
            $kembali= new Carbon($pinjam->tgl_hrs_kbl);
            $all = $tanggal ->diffInDays($kembali);
            $pinjam->denda= $all*2000;

            if ($tanggal <= $kembali){
                $pinjam->denda = $all*0;
            }elseif ($tanggal > $kembali) {
                $pinjam->denda = $all*2000;
            }
            $pinjam->save();

            $stock = buku::where('id', $pinjam->id_buku)->first();
            $stock->tersedia = $stock->tersedia + 1;
            $stock->save();

            $agt = anggota::where('id',$pinjam->id_agt)->first();
            $agt->status = $agt->status - 1;
            $agt->save();

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
