<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cabangs = Cabang::all();
        if ($cabangs->isEmpty()) {
            $cabang = []; // Set variabel menjadi array kosong
        }
    
        $pageTitle = 'Cabang';
    
        // Kembalikan view dengan data yang sudah disiapkan
        return view('cabang.index', compact('pageTitle', 'cabangs'));
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

    public function Pencarian(Request $request){
        $Validasi=$request->validate([
            'nama_pencarian' => 'required'
        ]);

        $data = Cabang::where('nama_cabang', 'LIKE', '%'. $Validasi['nama_pencarian'].'%')->get();
        return view('cabang.index')->with('cabangs',$data);
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
            'nama_cabang' => 'required|unique:cabangs,nama_cabang',
            'deskripsi_cabang' => 'required|string|max:1000',
        ],[
            'deskripsi_cabang.required' => 'Deskripsi cabang harus diisi',
            'nama_cabang.required' => 'Nama cabang harus dipilih',
            'nama_cabang.unique' => 'Cabang sudah ada',
        ]);

        Cabang::create([
            'nama_cabang' => $request->nama_cabang,
            'deskripsi_cabang' => $request->deskripsi_cabang,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        // Setelah berhasil menambahkan data
        // return redirect()->route('pegawai.index')->with('success', true);
        $request->session()->flash('success','Cabang berhasil ditambahkan');
        return redirect()->route('cabang.index');
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
    public function edit(Cabang $cabang)
    {
        //
        $pageTitle = 'Edit Cabang'; // Judul halaman untuk edit pegawai
        return view('cabang.edit', compact('cabang', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cabang $cabang)
    {
        //
        $request->validate([
            'nama_cabang',
            'deskripsi_cabang' => 'required|string|max:1000',
        ],[
            'deskripsi_cabang.required' => 'Deskripsi cabang harus diisi',
        ]);
    
    
        // Ambil semua data yang dikirimkan melalui form
        $data = $request->all();
        // Update data pegawai
        $cabang->update($data);
        $request->session()->flash('success','Data cabang berhasil di ubah');
        return redirect()->route('cabang.index');
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
        $cabang = cabang::findOrFail($id);
        $cabang->delete();

        // Setelah menghapus pegawai, cek apakah masih ada pegawai tersisa
        $cabangs = Cabang::all();
        if ($cabangs->isEmpty()) {
            // Jika tidak ada pegawai tersisa, kembalikan view index dengan data kosong
            return view('cabang.index')->with('cabangs', $cabangs);
        }

        // Jika masih ada pegawai tersisa, kembalikan view index dengan data pegawai yang tersisa
        return redirect()->route('cabang.index')->with('delete', "$cabang->nama_cabang berhasil dihapus");
    }
}
