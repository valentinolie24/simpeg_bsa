<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promosi;
use App\Models\Pegawai;
use App\Models\Jabatan;

class PromosiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $promosi = Promosi::with('pegawai')->get(); // Mengambil semua data promosi beserta pegawai terkait
        return view('promosi.index', compact('promosi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $pageTitle = 'Tambah Promosi';
        $pegawai = Pegawai::all();
        $jabatans = Jabatan::all();
        return view('promosi.create', compact('pegawai', 'jabatans', 'pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'pegawai_id' => 'required',
            'jabatan_baru' => 'required',
            'tanggal_promosi' => 'required',
        ],[
            'pegawai_id.required' => 'Nama harus dipilih',
            'jabatan_baru.required' => 'Alamat harus dipilih',
            'tanggal_promosi.required' => 'Tanggal promosi harus diisi',
        ]);
    
        // Simpan data promosi
        $promosi = new Promosi();
        $promosi->pegawai_id = $pegawaiId;
        $promosi->jabatan_baru = $request->jabatan_baru;
        $promosi->tanggal_promosi = $request->tanggal_promosi;
        $pegawai->save();
    
        // Redirect dengan pesan sukses
        return redirect()->route('promosi.index')->with('success', 'Data promosi berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
