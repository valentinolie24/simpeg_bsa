<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhkPengundurandiri;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;


class PhkPengundurandiriController extends Controller
{
    public function index()
    {
        $user_role = Auth::user()->role;
        $user_id = Auth::id(); // Get the authenticated user ID
    
        if ($user_role == 'sdm') {
            $phkpengundurandiri = PhkPengundurandiri::with('pegawai')->get();
        } else {
            $phkpengundurandiri = PhkPengundurandiri::with('pegawai')
                ->whereHas('pegawai', function ($query) use ($user_id) {
                    $query->where('user_id', $user_id); // Use the correct column name
                })
                ->get();
        }
    
        return view('phkpengundurandiri.index', compact('phkpengundurandiri'));
    }
    

    public function create()
    {
        $pageTitle = 'Tambah PHK & Pengunduran Diri';
        $pegawai = Pegawai::all();
        return view('phkpengundurandiri.create', compact('pegawai', 'pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required',
            'tanggal' => 'required',
            'status_pekerjaan' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'pegawai_id.required' => 'Nama harus dipilih',
            'status_pekerjaan.required' => 'Status pekerjaan harus dipilih',
            'tanggal_promosi.required' => 'Tanggal harus diisi',
            'foto.required' => 'Foto harus dipilih',
            'foto.image' => 'File yang dimasukkan bukan jenis foto',
            'foto.mimes' => 'Foto yang dimasukkan harus dengan format JPEG,PNG,JPG!',
            'foto.max' => 'Ukuran maksimal foto adalah 2MB',
        ]);

        $foto = time().'.'.$request->foto->extension();  
        $request->foto->move(public_path('foto'), $foto);

        PhkPegundurandiri::create([
            'pegawai_id' => $request->pegawai_id,
            'status_pekerjaan' => $request->status_pekerjaan,
            'tanggal' => $request->tanggal,
            'foto' => $foto,
        ]);

        return redirect()->route('phkpengundurandiri.index')->with('success', 'Data berhasil disimpan');
    }

    public function accept(Request $request, $id)
    {
        $phkpengundurandiri = PhkPengundurandiri::findOrFail($id);
        $phkpengundurandiri->status = 'Diterima';
        $phkpengundurandiri->save();

        // Update jabatan pegawai hanya jika phkpengundurandiri diterima
        $pegawai = Pegawai::findOrFail($phkpengundurandiri->pegawai_id);
        $pegawai->jabatan = $phkpengundurandiri->jabatan_baru;
        $pegawai->save();

        $request->session()->flash('success', 'PHK atau Pengunduran diri diterima');
        return redirect()->route('phkpengundurandiri.index');
    }

    public function reject(Request $request, $id)
    {
        $phkpengundurandiri = PhkPengundurandiri::findOrFail($id);
        $phkpengundurandiri->status = 'Ditolak';
        $phkpengundurandiri->save();

        $request->session()->flash('delete', 'Phk atau Pengunduran diri pegawai ditolak.');
        return redirect()->route('phkpengundurandiri.index');
    }

    public function saveNote(Request $request, $id)
    {
        $inputName = 'catatan_' . $id;
        $request->validate([
            $inputName => 'required|string|max:1000',
        ], [
            $inputName . '.required' => 'Catatan harus diisi',
            $inputName . '.max' => 'Catatan maksimal 1000 karakter',
        ]);

        $phkpengundurandiri = PhkPengundurandiri::findOrFail($id);
        $phkpengundurandiri->catatan = $request->input($inputName);
        $phkpengundurandiri->save();

        return redirect()->route('phkpengundurandiri.index')->with('success', 'Catatan berhasil disimpan.');
    }

    public function Pencarian(Request $request)
    {
        $request->validate([
            'nama_pencarian' => 'required'
        ]);
    
        $data = PhkPengundurandiri::with('pegawai')
            ->whereHas('pegawai', function ($query) use ($request) {
                $query->where('nama', 'LIKE', '%' . $request->nama_pencarian . '%');
            })
            ->get();
    
        return view('phkpengundurandiri.index', ['phkpengundurandiri' => $data]);
    }
}
