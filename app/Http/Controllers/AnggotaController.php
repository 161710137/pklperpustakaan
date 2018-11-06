<?php

namespace App\Http\Controllers;

use App\anggota;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;

class AnggotaController extends Controller
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
        $agt = anggota::all();
        return DataTables::of($agt)
        ->addColumn('action',function($agt){
            return '<center><a href="#" class="btn btn-xs btn-primary edit" data-id="'.$agt->id.'"><i class="glyphicon glyphicon-edit"></i> Edit</a> | <a href="#" class="btn btn-xs btn-danger delete" id="'.$agt->id.'"><i class="glyphicon glyphicon-remove"></i> Delete</a></center>';
        })
        ->rawColumns(['action'])->make(true);
    }
    public function index()
    {
         return view('anggota.index');
    }
     function removedata(Request $request)
    {
        $agt = anggota::find($request->input('id'));
        if($agt->delete())
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
            'no_agt'=>'required',
            'nama_agt'=>'required',
            'alamat'=>'required',
            'kota'=>'required',
            'telp'=>'required'

        ],[
            'no_agt.required'=>'no anggota tidak boleh kosong',
            'nama_agt.required'=>'nama anggota tidak boleh kosong',
            'alamat.required'=>'alamat tidak boleh kosong',
            'kota.required'=>'kota tidak boleh kosong',
            'telp.required'=>'telp tidak boleh kosong'
        ]);
        $agt = new anggota;
        $agt->no_agt = $request->no_agt;
        $agt->nama_agt = $request->nama_agt;
        $agt->alamat = $request->alamat;
        $agt->kota = $request->kota;
        $agt->telp = $request->telp;
        $agt->save();
        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function show(anggota $anggota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agt = anggota::findOrFail($id);
        return $agt;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $this->validate($request,[
            'no_agt'=>'required',
            'nama_agt'=>'required',
            'alamat'=>'required',
            'kota'=>'required',
            'telp'=>'required'
        ],[
            'no_agt.required'=> 'No Anggota tidak boleh kosong',
            'nama_agt.required'=> 'Nama Anggota tidak boleh kosong',
            'alamat.required'=> 'Alamat tidak boleh kosong',
            'kota.required'=> 'Kota tidak boleh kosong ',
            'telp.required'=> 'Telepon tidak boleh kosong'
        ]);
            $agt = anggota::find($id);
            $agt->no_agt = $request->no_agt;
            $agt->nama_agt = $request->nama_agt;
            $agt->alamat = $request->alamat;
            $agt->kota = $request->kota;
            $agt->telp = $request->telp;
            $agt->save();
            return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function destroy(anggota $anggota)
    {
        //
    }
}
