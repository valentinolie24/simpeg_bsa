<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // Ambil semua data lowongan dari database
        $jabatans = Jabatan::all();
    
        // Jika data lowongan kosong, buat variabel $lowongan menjadi array kosong
        if ($jabatans->isEmpty()) {
            $jabatan = []; // Set variabel menjadi array kosong
        }
    
        $pageTitle = 'Jabatan';
    
        // Kembalikan view dengan data yang sudah disiapkan
        return view('jabatan.index', compact('pageTitle', 'jabatans'));
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

        $data = Jabatan::where('nama_jabatan', 'LIKE', '%'. $Validasi['nama_pencarian'].'%')->get();
        return view('jabatan.index')->with('jabatans',$data);
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
            'kode_jabatan' => 'required|unique:jabatans,kode_jabatan',
            'nama_jabatan' => 'required|unique:jabatans,nama_jabatan',
            'deskripsi_jabatan' => 'required|string|max:1000',
        ],[
            'kode_jabatan.required' => 'Kode jabatan harus diisi',
            'deskripsi_jabatan.required' => 'Deskripsi jabatan harus diisi',
            'nama_jabatan.required' => 'Nama jabatan harus dipilih',
            'kode_jabatan.unique' => 'Kode jabatan sudah ada',
            'nama_jabatan.unique' => 'Jabatan sudah ada',
        ]);

        Jabatan::create([
            'kode_jabatan' => $request->kode_jabatan,
            'nama_jabatan' => $request->nama_jabatan,
            'deskripsi_jabatan' => $request->deskripsi_jabatan,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        // Setelah berhasil menambahkan data
        // return redirect()->route('pegawai.index')->with('success', true);
        $request->session()->flash('success','Jabatan berhasil ditambahkan');
        return redirect()->route('jabatan.index');

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
    public function edit(Jabatan $jabatan)
    {
        //
        $pageTitle = 'Edit Jabatan'; // Judul halaman untuk edit pegawai
        return view('jabatan.edit', compact('jabatan', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        //
        $request->validate([
            'kode_jabatan' => 'required|unique:jabatans,kode_jabatan',
            'nama_jabatan' => 'required',
            'deskripsi_jabatan' => 'required|string|max:1000',
        ],[
            'kode_jabatan.required' => 'Kode jabatan harus diisi',
            'deskripsi_jabatan.required' => 'Deskripsi jabatan harus diisi',
            'nama_jabatan.required' => 'Nama jabatan harus dipilih',
            'kode_jabatan.unique' => 'Kode jabatan sudah ada',
        ]);
    
    
        // Ambil semua data yang dikirimkan melalui form
        $data = $request->all();
        // Update data pegawai
        $jabatan->update($data);
        $request->session()->flash('success','Data jabatan berhasil di ubah');
        return redirect()->route('jabatan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Temukan Jabatan berdasarkan ID
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        // Setelah menghapus pegawai, cek apakah masih ada pegawai tersisa
        $jabatans = Jabatan::all();
        if ($jabatans->isEmpty()) {
            // Jika tidak ada pegawai tersisa, kembalikan view index dengan data kosong
            return view('jabatan.index')->with('jabatans', $jabatans);
        }

        // Jika masih ada pegawai tersisa, kembalikan view index dengan data pegawai yang tersisa
        return redirect()->route('jabatan.index')->with('delete', "$jabatan->nama_jabatan berhasil dihapus");
    }
}
