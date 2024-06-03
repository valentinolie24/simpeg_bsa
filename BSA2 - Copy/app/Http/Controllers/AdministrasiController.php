<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Daftar;
use App\Models\User;

class AdministrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_role = Auth::user()->role;

        if ($user_role == 'calon_pegawai') {
            $user = Auth::user()->id;

            $daftars = Daftar::where('user_id', $user)->get();

            if ($daftars->isEmpty()) {
                $daftars = []; // Set variabel menjadi array kosong
            }   

            return view('administrasi.index', compact('daftars', 'user_role'));
        } elseif ($user_role == 'sdm') {
            $daftars = Daftar::all();

            if ($daftars->isEmpty()) {
                $daftars = []; // Set variabel menjadi array kosong
            }

            return view('administrasi.index', compact('daftars', 'user_role'));
        }
    }

    public function saveNote(Request $request, $id)
    {
        $request->validate([
            'catatan_' . $id => 'required|string|max:1000'
        ], [
            'catatan_' . $id . '.required' => 'Catatan harus diisi',
            'catatan_' . $id . '.max' => 'Catatan maksimal 1000 karakter',
        ]);
    
        $daftar = Daftar::findOrFail($id);
        $daftar->catatan = $request->input('catatan_' . $id); // Menyesuaikan dengan nama input yang benar
        $daftar->save();
    
        return redirect()->route('administrasi.index')->with('success', 'Catatan berhasil disimpan.');
    }
    

    public function accept(Request $request, $id)
    {
        $daftar = Daftar::findOrFail($id);
        $daftar->status_administrasi = 'Diterima';
        $daftar->save();
    
        // Lanjutkan dengan logika lain jika diperlukan
        $request->session()->flash('terima','Berkas calon pegawai diterima');
        return redirect()->route('administrasi.index');
    }

    public function reject(Request $request, $id)
    {
        $daftar = Daftar::findOrFail($id);
        $daftar->status_administrasi = 'Ditolak';
        $daftar->save();

        // Lanjutkan dengan logika lain jika diperlukan
        $request->session()->flash('tolak','Berkas calon pegawai ditolak');
        return redirect()->route('administrasi.index');
    }

    public function Pencarian(Request $request)
    {
        $Validasi = $request->validate([
            'nama_pencarian' => 'required'
        ]);

        $data = User::where('name', 'LIKE', '%' . $Validasi['nama_pencarian'] . '%')->get();

        // Mengambil daftar yang terkait dengan pengguna yang ditemukan
        $daftars = Daftar::whereIn('user_id', $data->pluck('id'))->get();

        return view('administrasi.index')->with('daftars', $daftars);
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
        //
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
