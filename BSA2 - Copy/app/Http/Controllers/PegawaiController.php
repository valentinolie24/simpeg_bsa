<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Daftar;
use App\Models\Lowongan;
use App\Models\PengumumanAkhir;
use App\Models\Jabatan;
use App\Models\Cabang;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_role = Auth::user()->role;
        $user_id = Auth::user()->id;

        // if ($user_role == 'sdm') {
        //     $pegawais = Pegawai::whereHas('user', function ($query) {
        //         $query->where('role', 'pegawai');
        //     })->get();
        // } elseif ($user_role == 'pegawai') {
        //     $pegawai = Pegawai::where('user_id', $user_id)->first();
        //     $pegawais = $pegawai ? collect([$pegawai]) : collect();
        // } else {
        //     $pegawais = collect();
        // }
    
        // return view('pegawai.index', compact('pegawais', 'user_role'));

        if ($user_role == 'sdm') {
            // Get all employees associated with the user role 'pegawai'
            $pegawais = Pegawai::whereHas('user', function ($query) {
                $query->where('role', 'pegawai');
            })->get();

            return view('pegawai.index', compact('pegawais', 'user_role'));                     // error dihalaman sdm kalau dikomen
        } elseif ($user_role == 'pegawai') {
            // Get the employee associated with the user_id
            $pegawai = Pegawai::where('user_id', $user_id)->first();

            if (is_null($pegawai)) {
                $pegawais = collect(); // Set variable to empty collection if employee not found
            } else {
                $pegawais = collect([$pegawai]); // Wrap in collection
            }

            // return view('pegawai.index', compact('pegawais', 'user_role', 'pegawai'));
        }

        // Handle other roles or return default view
        $pegawais = collect();
        return view('pegawai.index', compact('pegawais', 'user_role', 'pegawai'));
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
        $cabangs = Cabang::all();
        $jabatans = Jabatan::all(); // Ambil semua data jabatan
        $user = Auth::user();
    
        $daftar = Daftar::where('user_id', $user->id)->first();

        // Ambil posisi dari tabel daftar
        $posisi = $daftar ? Lowongan::find($daftar->lowongan_id)->nama : 'Tidak ada posisi';
    
        // Mengambil tanggal masuk dari tabel pengumuman_akhir berdasarkan user_id
        $pengumumanAkhir = PengumumanAkhir::where('user_id', $user->id)->latest('tanggal_masuk')->first();
        $tanggalMasuk = $pengumumanAkhir ? $pengumumanAkhir->tanggal_masuk : 'Tidak ada tanggal masuk';
    
        // Mengambil nama lowongan dari tabel lowongan berdasarkan lowongan_id yang ada di tabel daftar
        $lowongan = Lowongan::find($daftar->lowongan_id ?? null);
        $namaLowongan = $lowongan ? $lowongan->nama : 'Tidak ada lowongan';
    
        $pageTitle = 'Tambah Pegawai';
        return view('pegawai.create', compact('user', 'jabatans','lowongan', 'posisi', 'tanggalMasuk', 'namaLowongan', 'pageTitle', 'cabangs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        
        // Validasi input
        $request->validate([
            'nik' => 'required|unique:pegawais,nik',
            'nama' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'ttl' => 'required',
            'jabatan' => 'required',
            'tanggal_masuk' => 'required',
            'pendidikan' => 'required',
            // 'cabang_id' => 'required', // kalau dibuat cabang id, pegawai tidak bisa
            'status' => 'required',
            'agama' => 'required',
            'status_pekerjaan' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ],[
            'foto.image' => 'File yang dimasukkan bukan jenis foto',
            'foto.mimes' => 'Foto yang dimasukkan harus dengan format JPEG,PNG,JPG!',
            'foto.max' => 'Ukuran maksimal foto adalah 2MB',
            'nik.required' => 'NIK harus diisi',
            'nama.required' => 'Nama harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'tanggal_masuk.required' => 'Tanggal masuk harus diisi',
            'tempat_lahir.required' => 'Tempat lahir harus diisi',
            'jabatan.required' => 'Jabatan harus diisi',
            // 'cabang_id.required' => 'Cabang harus diisi',
            'pendidikan.required' => 'Pendidikan harus diisi',
            'status.required' => 'Status harus dipilih',
            'agama.required' => 'Agama harus dipilih',
            'status_pekerjaan.required' => 'Status Pekerjaan harus dipilih',
            'foto.required' => 'Foto harus dipilih',
            'nik.unique' => 'NIK sudah terdaftar',
        ]);
    
        // Jika role bukan pegawai, tambahkan user baru
        if (auth()->user()->role != 'pegawai') {
            $user = new User;
            $user->name = $request->nama;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->noWA = $request->noWA;
            $user->role = $request->role;
            $user->save();
            
            $userId = $user->id;  // Gunakan user_id dari user yang baru dibuat
        } else {
            $userId = auth()->user()->id;  // Gunakan user_id dari user yang login
        }
    
        // Proses foto
        $foto = time().'.'.$request->foto->extension();  
        $request->foto->move(public_path('foto'), $foto);
    
        // Simpan data pegawai
        $pegawai = new Pegawai();
        $pegawai->user_id = $userId;
        $pegawai->nik = $request->nik;
        $pegawai->nama = $request->nama;
        $pegawai->alamat = $request->alamat;
        $pegawai->tempat_lahir = $request->tempat_lahir;
        $pegawai->ttl = $request->ttl;
        $pegawai->jabatan = $request->jabatan;
        $pegawai->tanggal_masuk = $request->tanggal_masuk;
        $pegawai->pendidikan = $request->pendidikan;
        // $pegawai->cabang_id = $request->cabang_id;
        $pegawai->status = $request->status;
        $pegawai->agama = $request->agama;
        $pegawai->status_pekerjaan = $request->status_pekerjaan;
        $pegawai->foto = $foto;
        $pegawai->save();
    
        // Redirect dengan pesan sukses
        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil disimpan');
    }
    // public function store(Request $request)
    // {
    // // Validasi input menggunakan Validator
    //     $request->validate([
    //         'nik' => 'required|unique:pegawais,nik',
    //         'nama' => 'required',
    //         'alamat' => 'required',
    //         'tempat_lahir' => 'required',
    //         'ttl' => 'required',
    //         'jabatan' => 'required',
    //         'tanggal_masuk' => 'required',
    //         'pendidikan' => 'required',
    //         'status' => 'required',
    //         'agama' => 'required',
    //         'status_pekerjaan' => 'required',
    //         'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
    //     ],[
    //         'foto.image' => 'File yang dimasukkan bukan jenis foto',
    //         'foto.mimes' => 'Foto yang dimasukkan harus dengan format JPEG,PNG,JPG!',
    //         'foto.max' => 'Ukuran maksimal foto adalah 2MB',
    //         'nik.required' => 'NIK harus diisi',
    //         'nama.required' => 'Nama harus diisi',
    //         'alamat.required' => 'Alamat harus diisi',
    //         'tanggal_masuk.required' => 'Tanggal masuk harus diisi',
    //         'tempat_lahir.required' => 'Tempat lahir harus diisi',
    //         'jabatan.required' => 'Jabatan harus diisi',
    //         'pendidikan.required' => 'Pendidikan harus diisi',
    //         'status.required' => 'Status harus dipilih',
    //         'agama.required' => 'Agama harus dipilih',
    //         'status_pekerjaan.required' => 'Status Pekerjaan harus dipilih',
    //         'foto.required' => 'Foto harus dipilih',
    //         'nik.unique' => 'NIK sudah terdaftar',
    //     ]);
    //     // Buat objek Pegawai dan isi dengan data dari formulir
    // // Membuat instance baru dari model Pegawai
    // $pegawai = new Pegawai();
    // $pegawai->user_id = auth()->user()->id;
    // // Lanjutkan dengan pemrosesan form input lainnya...

    // $foto = time().'.'.$request->foto->extension();  
    // $request->foto->move(public_path('foto'), $foto);

    // $pegawai->nik = $request->nik;
    // $pegawai->nama = $request->nama;
    // $pegawai->alamat = $request->alamat;
    // $pegawai->tempat_lahir = $request->tempat_lahir;
    // $pegawai->ttl = $request->ttl;
    // $pegawai->jabatan = $request->jabatan;
    // $pegawai->tanggal_masuk = $request->tanggal_masuk;
    // $pegawai->pendidikan = $request->pendidikan;
    // $pegawai->status = $request->status;
    // $pegawai->agama = $request->agama;
    // $pegawai->status_pekerjaan = $request->status_pekerjaan;
    // $pegawai->foto = $foto;

    // // Simpan data pegawai ke dalam database
    // $pegawai->save();

    // if (auth()->user()->role != 'pegawai') {
    //     $user = new User;
    //     $user->name = $request->nama;
    //     $user->email = $request->email;
    //     $user->password = bcrypt($request->password);
    //     $user->noWA = $request->noWA;
    //     $user->role = $request->role;
    //     $userId = $user->id;
    //     $user->save();
    // }

    // // Redirect ke halaman index dengan pesan sukses
    // return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil disimpan');
        // $pegawai->user_id = auth()->user()->id;
        // $foto = time().'.'.$request->foto->extension();  
        // $request->foto->move(public_path('foto'), $foto);

        // Pegawai::create([
        //     'nik' => $request->nik,
        //     'nama' => $request->nama,
        //     'alamat' => $request->alamat,
        //     'ttl' => $request->ttl,
        //     'jabatan' => $request->jabatan,
        //     'tanggal_masuk' => $request->tanggal_masuk,
        //     'pendidikan' => $request->pendidikan,
        //     'status' => $request->status,
        //     'agama' => $request->agama,
        //     'status_pekerjaan' => $request->status_pekerjaan,
        //     'foto' => $foto,
        // ]);

        // // Redirect ke halaman index dengan pesan sukses
        // // Setelah berhasil menambahkan data
        // // return redirect()->route('pegawai.index')->with('success', true);
        // $request->session()->flash('info','Data pegawai berhasil di simpan');
        // return redirect()->route('pegawai.index');

    // }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Pegawai::findOrFail($id);
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
        'nama',
        'alamat' => 'required',
        'tempat_lahir' => 'required',
        'ttl' => 'required',
        'jabatan',
        'tanggal_masuk',
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
        'alamat.required' => 'Alamat harus diisi',
        'tempat_lahir.required' => 'Tempat lahir harus diisi',
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

    // // Temukan pegawai berdasarkan ID
    // $pegawai = Pegawai::findOrFail($id);

    // // Hapus foto pegawai jika ada
    // if (!empty($pegawai->foto)) {
    //     Storage::delete('foto/' . $pegawai->foto);
    // }

    // // Hapus data pegawai
    // $pegawai->delete();

    // // Redirect ke halaman index dengan pesan sukses
    // return redirect()->route('pegawai.index')->with('delete', "$pegawai->nama berhasil dihapus");
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
