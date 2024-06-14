<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\rewardpunishment;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;


class RewardpunishmentController extends Controller
{
    public function index()
    {
        $user_role = Auth::user()->role;
        $user_id = Auth::id(); // Get the authenticated user ID
    
        if ($user_role == 'sdm') {
            $rewardpunishment = rewardpunishment::with('pegawai')->get();
        } else {
            $rewardpunishment = rewardpunishment::with('pegawai')
                ->whereHas('pegawai', function ($query) use ($user_id) {
                    $query->where('user_id', $user_id); // Use the correct column name
                })
                ->get();
        }
    
        return view('rewardpunishment.index', compact('rewardpunishment'));
    }
    

    public function create()
    {
        $pageTitle = 'Tambah Reward & Punishment';
        $pegawai = Pegawai::all();
        return view('rewardpunishment.create', compact('pegawai', 'pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required',
            'jenis' => 'required',
            'tanggal' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'pegawai_id.required' => 'Nama harus dipilih',
            'jenis.required' => 'Jenis Reward atau Punishment harus dipilih',
            'tanggal.required' => 'Tanggal Reward atau Punishment harus diisi',
            'foto.required' => 'Foto harus dipilih',
            'foto.image' => 'File yang dimasukkan bukan jenis foto',
            'foto.mimes' => 'Foto yang dimasukkan harus dengan format JPEG,PNG,JPG!',
            'foto.max' => 'Ukuran maksimal foto adalah 2MB',
        ]);

        $foto = time().'.'.$request->foto->extension();  
        $request->foto->move(public_path('foto'), $foto);

        rewardpunishment::create([
            'pegawai_id' => $request->pegawai_id,
            'jenis' => $request->jenis,
            'tanggal' => $request->tanggal,
            'foto' => $foto,
        ]);

        return redirect()->route('rewardpunishment.index')->with('success', 'Data berhasil disimpan');
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

        $rewardpunishment = rewardpunishment::findOrFail($id);
        $rewardpunishment->catatan = $request->input($inputName);
        $rewardpunishment->save();

        return redirect()->route('rewardpunishment.index')->with('success', 'Catatan berhasil disimpan.');
    }

    public function Pencarian(Request $request)
    {
        $request->validate([
            'nama_pencarian' => 'required'
        ]);
    
        $data = rewardpunishment::with('pegawai')
            ->whereHas('pegawai', function ($query) use ($request) {
                $query->where('nama', 'LIKE', '%' . $request->nama_pencarian . '%');
            })
            ->get();
    
        return view('rewardpunishment.index', ['rewardpunishment' => $data]);
    }
}
