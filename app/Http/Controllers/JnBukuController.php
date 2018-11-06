<?php

namespace App\Http\Controllers;

use Validator;
use App\jn_buku;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;

class JnBukuController extends Controller
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
        $jebu = jn_buku::all();
        return DataTables::of($jebu)
        ->addColumn('action',function($jebu){
            return '<center><a href="#" class="btn btn-xs btn-primary edit" data-id="'.$jebu->id.'"><i class="glyphicon glyphicon-edit"></i> Edit</a> | <a href="#" class="btn btn-xs btn-danger delete" id="'.$jebu->id.'"><i class="glyphicon glyphicon-remove"></i> Delete</a></center>';
        })
        ->rawColumns(['action'])->make(true);
    }
    public function index()
    {
        return view('jnbuku.index');
    }
     function removedata(Request $request)
    {
        $jebu = jn_buku::find($request->input('id'));
        if($jebu->delete())
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
            'jenis'=>'required'
        ],[
            'jenis.required'=>'jenis tidak boleh kosong'
        ]);
        $jeni = new jn_buku;
        $jeni->jenis = $request->jenis;
        $jeni->save();
        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\jn_buku  $jn_buku
     * @return \Illuminate\Http\Response
     */
    public function show(jn_buku $jn_buku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\jn_buku  $jn_buku
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jeni = jn_buku::findOrFail($id);
        return $jeni;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\jn_buku  $jn_buku
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $this->validate($request,[
            'jenis'=>'required'
        ],[
            'jenis.required'=> 'Jenis Buku tidak boleh kosong'
        ]);
            $jeni = jn_buku::find($id);
            $jeni->jenis = $request->jenis;
            $jeni->save();
            return response()->json(['success'=>true]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\jn_buku  $jn_buku
     * @return \Illuminate\Http\Response
     */
    public function destroy(jn_buku $jn_buku)
    {
        //
    }
}
