<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Jabatan;



class LowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil semua data lowongan dari database
        $lowongans = Lowongan::all();
    
        // Jika data lowongan kosong, buat variabel $lowongan menjadi array kosong
        if ($lowongans->isEmpty()) {
            $lowongan = []; // Set variabel menjadi array kosong
        }
    
        $pageTitle = 'Lowongan';
    
        // Kembalikan view dengan data yang sudah disiapkan
        return view('lowongan.index', compact('pageTitle', 'lowongans'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('posisi');
        $lowongans = Lowongan::where('posisi', 'like', "%$keyword%")->get();
        return response()->json($lowongans);
    }

            // custom function
    public function Pencarian(Request $request){
        $Validasi=$request->validate([
            'nama_pencarian' => 'required'
        ]);

        $data = Lowongan::where('posisi', 'LIKE', '%'. $Validasi['nama_pencarian'].'%')->get();
        return view('lowongan.index')->with('lowongans',$data);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $jabatans = Jabatan::all();
        $pageTitle = 'Tambah Lowongan';
        return view('lowongan.create', compact('pageTitle', 'jabatans'));
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
            'posisi' => 'required|unique:lowongans,posisi',
            'deskripsi' => 'required',
            'gaji' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ],[
            'foto.image' => 'File yang dimasukkan bukan jenis foto',
            'foto.mimes' => 'Foto yang dimasukkan harus dengan format JPEG,PNG,JPG!',
            'foto.max' => 'Ukuran maksimal foto adalah 2MB',
            'posisi.required' => 'Posisi harus diisi',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'gaji.required' => 'Kisaran Gaji harus dipilih',
            'foto.required' => 'Foto harus dipilih',
            'posisi.unique' => 'Posisi sudah ada',
        ]);

        $foto = time().'.'.$request->foto->extension();  
        $request->foto->move(public_path('foto'), $foto);

        Lowongan::create([
            'posisi' => $request->posisi,
            'deskripsi' => $request->deskripsi,
            'gaji' => $request->gaji,
            'foto' => $foto,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        // Setelah berhasil menambahkan data
        // return redirect()->route('pegawai.index')->with('success', true);
        $request->session()->flash('success','Lowongan berhasil ditambahkan');
        return redirect()->route('lowongan.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lowongan  $lowongan
     * @return \Illuminate\Http\Response
     */
    public function show(Lowongan $lowongan)
    {
        //
        $lowongan = Lowongan::findOrFail($id); // Misalnya Anda mengambil data lowongan berdasarkan ID
    return view('nama_view', compact('lowongan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lowongan  $lowongan
     * @return \Illuminate\Http\Response
     */
    public function edit(Lowongan $lowongan)
    {
        //
        $jabatans = Jabatan::all();
        $pageTitle = 'Edit Lowongan'; // Judul halaman untuk edit pegawai
        return view('lowongan.edit', compact('jabatans', 'pageTitle', 'lowongan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lowongan  $lowongan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        //
        // Validasi data yang diterima dari form
        $request->validate([
            'posisi',
            'deskripsi' => 'required',
            'gaji' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ],[
            'foto.image' => 'File yang dimasukkan bukan jenis foto',
            'foto.mimes' => 'Foto yang dimasukkan harus dengan format JPEG,PNG,JPG!',
            'foto.max' => 'Ukuran maksimal foto adalah 2MB',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'gaji.required' => 'Kisaran Gaji harus dipilih',
            'foto.required' => 'Foto harus dipilih',
        ]);

        // Ambil semua data yang dikirimkan melalui form
    $data = $request->all();

    // Cek apakah ada file foto yang diunggah
    if ($request->hasFile('foto')) {
        // Upload foto baru
        $foto = $request->file('foto');
        $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
        $foto->move(public_path('foto'), $namaFoto);

        // Ubah nama foto dalam data
        $data['foto'] = $namaFoto;
    }

    // Update data pegawai
    $lowongan->update($data);

    // Redirect ke halaman index dengan pesan sukses
    // return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    $request->session()->flash('success','Lowongan berhasil di ubah');
    return redirect()->route('lowongan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lowongan  $lowongan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // Temukan lowongan berdasarkan ID
        $lowongan = Lowongan::findOrFail($id);
        // Hapus foto pegawai jika ada
        if (!empty($lowongan->foto)) {
            $fotoPath = public_path('foto/' . $lowongan->foto);
            if (File::exists($fotoPath)) {
                File::delete($fotoPath);
            }
        }
        $lowongan->delete();

        // Setelah menghapus pegawai, cek apakah masih ada pegawai tersisa
        $lowongans = Lowongan::all();
        if ($lowongans->isEmpty()) {
            // Jika tidak ada pegawai tersisa, kembalikan view index dengan data kosong
            return view('lowongan.index')->with('lowongans', $lowongans);
        }

        // Jika masih ada pegawai tersisa, kembalikan view index dengan data pegawai yang tersisa
        return redirect()->route('lowongan.index')->with('delete', "$lowongan->posisi berhasil dihapus");
    
    }
}
