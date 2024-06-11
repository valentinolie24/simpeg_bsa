<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promosi;
use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Auth;

class PromosiController extends Controller
{
    public function index()
    {
        $user_role = Auth::user()->role;
        $user_id = Auth::id(); // Get the authenticated user ID
    
        if ($user_role == 'sdm') {
            $promosi = Promosi::with('pegawai')->get();
        } else {
            $promosi = Promosi::with('pegawai')
                ->whereHas('pegawai', function ($query) use ($user_id) {
                    $query->where('user_id', $user_id); // Use the correct column name
                })
                ->get();
        }
    
        return view('promosi.index', compact('promosi'));
    }
    

    public function create()
    {
        $pageTitle = 'Tambah Promosi';
        $pegawai = Pegawai::all();
        $jabatans = Jabatan::all();
        return view('promosi.create', compact('pegawai', 'jabatans', 'pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required',
            'jabatan_lama' => 'required',
            'jabatan_baru' => 'required',
            'tanggal_promosi' => 'required',
        ], [
            'pegawai_id.required' => 'Nama harus dipilih',
            'jabatan_baru.required' => 'Jabatan baru harus dipilih',
            'jabatan_lama.required' => 'Jabatan lama harus diisi',
            'tanggal_promosi.required' => 'Tanggal promosi harus diisi',
        ]);

        Promosi::create([
            'pegawai_id' => $request->pegawai_id,
            'jabatan_lama' => $request->jabatan_lama,
            'jabatan_baru' => $request->jabatan_baru,
            'tanggal_promosi' => $request->tanggal_promosi,
        ]);

        return redirect()->route('promosi.index')->with('success', 'Data promosi berhasil disimpan');
    }

    public function accept(Request $request, $id)
    {
        $promosi = Promosi::findOrFail($id);
        $promosi->status_promosi = 'Diterima';
        $promosi->save();

        // Update jabatan pegawai hanya jika promosi diterima
        $pegawai = Pegawai::findOrFail($promosi->pegawai_id);
        $pegawai->jabatan = $promosi->jabatan_baru;
        $pegawai->save();

        $request->session()->flash('success', 'Promosi pegawai telah diterima');
        return redirect()->route('promosi.index');
    }

    public function reject(Request $request, $id)
    {
        $promosi = Promosi::findOrFail($id);
        $promosi->status_promosi = 'Ditolak';
        $promosi->save();

        $request->session()->flash('delete', 'Promosi pegawai telah ditolak.');
        return redirect()->route('promosi.index');
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

        $promosi = Promosi::findOrFail($id);
        $promosi->catatan = $request->input($inputName);
        $promosi->save();

        return redirect()->route('promosi.index')->with('success', 'Catatan berhasil disimpan.');
    }

    public function Pencarian(Request $request)
    {
        $request->validate([
            'nama_pencarian' => 'required'
        ]);
    
        $data = Promosi::with('pegawai')
            ->whereHas('pegawai', function ($query) use ($request) {
                $query->where('nama', 'LIKE', '%' . $request->nama_pencarian . '%');
            })
            ->get();
    
        return view('promosi.index', ['promosi' => $data]);
    }
    
}

