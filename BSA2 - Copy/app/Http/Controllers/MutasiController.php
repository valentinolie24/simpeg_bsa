<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mutasi;
use App\Models\Pegawai;
use App\Models\Cabang;
use Illuminate\Support\Facades\Auth;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_role = Auth::user()->role;
        $user_id = Auth::id(); // Get the authenticated user ID
    
        if ($user_role == 'sdm') {
            $mutasi = Mutasi::with('pegawai')->get();
        } else {
            $mutasi = Mutasi::with('pegawai')
                ->whereHas('pegawai', function ($query) use ($user_id) {
                    $query->where('user_id', $user_id); // Use the correct column name
                })
                ->get();
        }
    
        return view('mutasi.index', compact('mutasi'));
    }

    public function getCabangLama($pegawaiId)
    {
        $pegawai = Pegawai::with('cabang')->find($pegawaiId);
        return response()->json([
            'id' => $pegawai->cabang_id,
            'nama_cabang' => $pegawai->cabang->nama_cabang
        ]);
    }

    public function create()
    {
        $pageTitle = 'Tambah Mutasi';
        $pegawai = Pegawai::all();
        $cabangs = Cabang::all();
        return view('mutasi.create', compact('pegawai', 'cabangs', 'pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required',
            'cabang_lama' => 'required|string',
            'cabang_baru' => 'required|string',
            'tanggal_mutasi' => 'required|date',
        ], [
            'pegawai_id.required' => 'Nama harus dipilih',
            'cabang_lama.required' => 'Cabang lama harus diisi',
            'cabang_baru.required' => 'Cabang baru harus dipilih',
            'tanggal_mutasi.required' => 'Tanggal mutasi harus diisi',
        ]);

        $pegawai = Pegawai::find($request->pegawai_id);

        Mutasi::create([
            'pegawai_id' => $request->pegawai_id,
            'cabang_lama' => $request->cabang_lama, // Simpan nama cabang lama
            'cabang_baru' => $request->cabang_baru, // Simpan nama cabang baru
            'tanggal_mutasi' => $request->tanggal_mutasi,
        ]);

        return redirect()->route('mutasi.index')->with('success', 'Data mutasi berhasil disimpan');
    }

    public function accept(Request $request, $id)
    {
        $mutasi = Mutasi::findOrFail($id);
        $mutasi->status_mutasi = 'Diterima';
        $mutasi->save();

        // Update cabang pegawai hanya jika mutasi diterima
        $pegawai = Pegawai::findOrFail($mutasi->pegawai_id);
        
        // Mendapatkan cabang baru berdasarkan nama cabang yang diterima
        $cabangBaru = Cabang::where('nama_cabang', $mutasi->cabang_baru)->firstOrFail();

        $pegawai->cabang_id = $cabangBaru->id;
        $pegawai->save();

        $request->session()->flash('success', 'Mutasi pegawai telah diterima');
        return redirect()->route('mutasi.index');
    }

    public function reject(Request $request, $id)
    {
        $mutasi = Mutasi::findOrFail($id);
        $mutasi->status_mutasi = 'Ditolak';
        $mutasi->save();

        $request->session()->flash('delete', 'Mutasi pegawai telah ditolak.');
        return redirect()->route('mutasi.index');
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

        $mutasi = Mutasi::findOrFail($id);
        $mutasi->catatan = $request->input($inputName);
        $mutasi->save();

        return redirect()->route('mutasi.index')->with('success', 'Catatan berhasil disimpan.');
    }

    public function Pencarian(Request $request)
    {
        $request->validate([
            'nama_pencarian' => 'required'
        ]);
    
        $data = Mutasi::with('pegawai')
            ->whereHas('pegawai', function ($query) use ($request) {
                $query->where('nama', 'LIKE', '%' . $request->nama_pencarian . '%');
            })
            ->get();
    
        return view('mutasi.index', ['mutasi' => $data]);
    }
}
