<?php

namespace App\Http\Controllers;

use App\buku;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use App\jn_buku;

class BukuController extends Controller
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
    public function json(){
        $buku = buku::all();
        return DataTables::of($buku)
        ->addColumn('jebu',function($buku){
            return $buku->jn_buku['jenis'];
        })
        ->addColumn('action',function($buku){
            return '<center><a href="#" class="btn btn-xs btn-primary edit" data-id="'.$buku->id.'"><i class="glyphicon glyphicon-edit"></i> Edit</a> | <a href="#" class="btn btn-xs btn-danger delete" id="'.$buku->id.'"><i class="glyphicon glyphicon-remove"></i> Delete</a></center>';
        })
        ->rawColumns(['action','jebu'])->make(true);
    }
    public function index()
    {
        $buku = jn_buku::all();
        return view('buku.index',compact('buku'));
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
            'judul'=>'required',
            'pengarang'=>'required',
            'isbn'=>'required|unique:bukus',
            'thn_terbit'=>'required',
            'penerbit'=>'required',
            'tersedia'=>'required'
        ],[ 
            'judul.required'=>'judul tidak boleh kosong',
            'pengarang.required'=>'pengarang tidak boleh kosong',
            'isbn.required'=>'isbn tidak boleh kosong',
            'isbn.unique'=>'isbn tidak boleh kosong',
            'thn_terbit.required'=>'thn_terbit tidak boleh kosong',
            'penerbit.required'=>'penerbit tidak boleh kosong',
            'tersedia.required'=>'tersedia tidak boleh kosong'
        ]);
        $buku = new buku;
        $buku->id_jb = $request->id_jb;
        $buku->judul = $request->judul;
        $buku->pengarang = $request->pengarang;
        $buku->isbn = $request->isbn;
        $buku->thn_terbit = $request->thn_terbit;
        $buku->penerbit = $request->penerbit;
        $buku->tersedia = $request->tersedia;
        $buku->save();
        return response()->json(['success'=>true]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function show(buku $buku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $buku = buku::findOrFail($id);
        return $buku;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $this->validate($request,[
            'judul'=>'required',
            'pengarang'=>'required',
            // 'isbn'=>'required|unique:bukus',
            'thn_terbit'=>'required',
            'penerbit'=>'required',
            'tersedia'=>'required'
        ],[
            'judul.required'=> 'Judul Buku tidak boleh kosong',
            'pengarang.required'=> 'Pengarang Wajib diisi',
            // 'isbn.required'=> 'ISBN tidak boleh kosong',
            // 'isbn.unique'=> 'ISBN tidak boleh kosong',
            'thn_terbit.required'=> 'Tahun terbit harus diisi',
            'penerbit.required'=> 'Penerebit harus diisi',
            'tersedia.required'=> 'Isi stok yang ada'
        ]);
            $buku = buku::find($id);
            $buku->judul = $request->judul;
            $buku->pengarang  = $request->pengarang;
            // $buku->isbn = $request->isbn;
            $buku->thn_terbit = $request->thn_terbit;
            $buku->penerbit = $request->penerbit;
            $buku->tersedia = $request->tersedia;
            $buku->save();
            return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = buku::find($request->input('id'));
        if($data->delete())
        {
            echo 'Data Deleted';
        }
    }

    public function removedata(Request $request)
    {
        $data = buku::find($request->input('id'));
        if($data->delete())
        {
            echo 'Data Deleted';
        }
    }
}
