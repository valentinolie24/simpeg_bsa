<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user_role = Auth::user()->role;

        if ($user_role == 'sdm') {
            $pegawais = Pegawai::all();

            if ($pegawais->isEmpty()) {
                $pegawai = []; // Set variabel menjadi array kosong
            }

            return view('pegawai.index', compact('pegawais'));
        }

    }

    public function search(Request $request)
    {
        $keyword = $request->input('nama');
        $pegawais = Pegawai::where('nama', 'like', "%$keyword%")->get();
        return response()->json($pegawais);
    }

        // custom function
    public function Pencarian(Request $request){
        $Validasi=$request->validate([
            'nama_pencarian' => 'required'
        ]);

        $data = Pegawai::where('nama', 'LIKE', '%'. $Validasi['nama_pencarian'].'%')->get();
        return view('pegawai.index')->with('pegawais',$data);
    }
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $pageTitle = 'Tambah Pegawai';
        return view('pegawai.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    // Validasi input menggunakan Validator
        $request->validate([
            'nik' => 'required|unique:pegawais,nik',
            'nama' => 'required',
            'alamat' => 'required',
            'ttl' => 'required',
            'jabatan' => 'required',
            'tanggal_masuk' => 'required',
            'pendidikan' => 'required',
            'status' => 'required',
            'agama' => 'required',
            'status_pekerjaan' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ],[
            'foto.image' => 'File yang dimasukkan bukan jenis foto',
            'foto.mimes' => 'Foto yang dimasukkan harus dengan format JPEG,PNG,JPG!',
            'foto.max' => 'Ukuran maksimal foto adalah 2MB',
            'nik.required' => 'NIK harus diisi',
            'nama.required' => 'Nama harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'jabatan.required' => 'Jabatan harus diisi',
            'pendidikan.required' => 'Pendidikan harus diisi',
            'status.required' => 'Status harus dipilih',
            'agama.required' => 'Agama harus dipilih',
            'status_pekerjaan.required' => 'Status Pekerjaan harus dipilih',
            'foto.required' => 'Foto harus dipilih',
            'nik.unique' => 'NIK sudah terdaftar',
        ]);

        $foto = time().'.'.$request->foto->extension();  
        $request->foto->move(public_path('foto'), $foto);

        Pegawai::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'ttl' => $request->ttl,
            'jabatan' => $request->jabatan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'pendidikan' => $request->pendidikan,
            'status' => $request->status,
            'agama' => $request->agama,
            'status_pekerjaan' => $request->status_pekerjaan,
            'foto' => $foto,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        // Setelah berhasil menambahkan data
        // return redirect()->route('pegawai.index')->with('success', true);
        $request->session()->flash('info','Data pegawai berhasil di simpan');
        return redirect()->route('pegawai.index');

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit(Pegawai $pegawai)
    {
        
        $pageTitle = 'Edit Pegawai'; // Judul halaman untuk edit pegawai
        return view('pegawai.edit', compact('pegawai', 'pageTitle'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pegawai $pegawai)
{
    // Validasi data yang diterima dari form
    $request->validate([
        'nik' => 'required|unique:pegawais,nik,' . $pegawai->id,
        'nama' => 'required',
        'alamat' => 'required',
        'ttl' => 'required',
        'jabatan' => 'required',
        'tanggal_masuk' => 'required',
        'pendidikan' => 'required',
        'status' => 'required',
        'agama' => 'required',
        'status_pekerjaan' => 'required',
        'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
    ],[
        'foto.image' => 'File yang dimasukkan bukan jenis foto',
        'foto.mimes' => 'Foto yang dimasukkan harus dengan format JPEG,PNG,JPG!',
        'foto.max' => 'Ukuran maksimal foto adalah 2MB',
        'nik.required' => 'NIK harus diisi.',
        'nama.required' => 'Nama harus diisi',
        'alamat.required' => 'Alamat harus diisi',
        'jabatan.required' => 'Jabatan harus diisi',
        'pendidikan.required' => 'Pendidikan harus diisi',
        'status.required' => 'Status harus dipilih',
        'agama.required' => 'Agama harus dipilih',
        'status_pekerjaan.required' => 'Status Pekerjaan harus dipilih',
        'foto.required' => 'Foto harus dipilih',
        'nik.unique' => 'NIK sudah terdaftar.',
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
    $pegawai->update($data);

    // Redirect ke halaman index dengan pesan sukses
    // return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    $request->session()->flash('edit','Data pegawai berhasil di ubah');
    return redirect()->route('pegawai.index');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Temukan pegawai berdasarkan ID
        $pegawai = Pegawai::findOrFail($id);
        // Hapus foto pegawai jika ada
        if (!empty($pegawai->foto)) {
            $fotoPath = public_path('foto/' . $pegawai->foto);
            if (File::exists($fotoPath)) {
                File::delete($fotoPath);
            }
        }
        $pegawai->delete();

        // Setelah menghapus pegawai, cek apakah masih ada pegawai tersisa
        $pegawais = Pegawai::all();
        if ($pegawais->isEmpty()) {
            // Jika tidak ada pegawai tersisa, kembalikan view index dengan data kosong
            return view('pegawai.index')->with('pegawais', $pegawais);
        }

        // Jika masih ada pegawai tersisa, kembalikan view index dengan data pegawai yang tersisa
        return redirect()->route('pegawai.index')->with('delete', "$pegawai->nama berhasil dihapus");
    }
}
