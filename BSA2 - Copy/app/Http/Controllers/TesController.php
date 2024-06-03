<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TesController extends Controller
{

    public function index()
    {
        $user_role = Auth::user()->role;
        $user_id = Auth::user()->id;

        if ($user_role == 'calon_pegawai') {
            $calon_pegawai = User::where('id', $user_id)
                ->whereHas('daftar', function ($query) {
                    $query->where('status_administrasi', 'Diterima');
                })
                ->with('tes')
                ->first();

            return view('tes.index', compact('calon_pegawai'));
        } elseif ($user_role == 'sdm') {
            $calon_pegawai = User::whereHas('daftar', function ($query) {
                $query->where('status_administrasi', 'Diterima');
            })
            ->with('tes')
            ->get();

            return view('tes.index', compact('calon_pegawai'));
        } else {
            return view('tes.index');
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_tes' => 'required',
            'nilai_tes' => 'required',
        ], [
            'jenis_tes.required' => 'Jenis tes harus dipilih',
            'nilai_tes.required' => 'Nilai harus diisi',
        ]);

        // Cari entri tes yang sudah ada dengan user_id yang sama
        $existingTes = Tes::where('user_id', $request->user_id)->first();

        if ($existingTes) {
            // Jika sudah ada entri tes untuk user tersebut
            if ($existingTes->jenis_tes === null && $existingTes->nilai_tes === null) {
                // Jika jenis tes dan nilai tes kosong, maka update entri tersebut dengan data yang baru
                $existingTes->update([
                    'jenis_tes' => $request->jenis_tes,
                    'nilai_tes' => $request->nilai_tes,
                ]);
            } else {
                // Jika sudah ada jenis tes atau nilai tes, maka buat entri baru
                Tes::create([
                    'user_id' => $request->user_id,
                    'jenis_tes' => $request->jenis_tes,
                    'nilai_tes' => $request->nilai_tes,
                    'status_tes' => $existingTes->status_tes,
                    'catatan' => $existingTes->catatan,
                ]);
            }
        } else {
            // Jika belum ada entri tes untuk user tersebut, maka buat entri baru
            Tes::create([
                'user_id' => $request->user_id,
                'jenis_tes' => $request->jenis_tes,
                'nilai_tes' => $request->nilai_tes,
            ]);
        }

        return redirect()->route('tes.index')->with('success', 'Tes berhasil ditambahkan.');
    }


    public function accept(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Cek apakah ada entri tes yang sudah ada dengan jenis tes dan nilai tes untuk user yang sama
        $tes = Tes::where('user_id', $user->id)
                ->whereNotNull('jenis_tes')
                ->whereNotNull('nilai_tes')
                ->get();

        if ($tes->isNotEmpty()) {
            // Update status tes untuk setiap entri tes yang ditemukan
            foreach ($tes as $t) {
                $t->status_tes = 'Diterima';
                $t->save(); // Memperbarui status tes pada setiap entri
            }
        }

            // Buat entri tes baru jika tidak ada entri tes yang cocok
        if ($tes->isEmpty()) {
            Tes::create([
                'user_id' => $user->id,
                'jenis_tes' => $request->jenis_tes,
                'nilai_tes' => $request->nilai_tes,
                'status_tes' => 'Diterima',
            ]);
        }

        return redirect()->route('tes.index')->with('success', 'Pegawai lulus tahap tes');
    }

    public function reject(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Cek apakah ada entri tes yang sudah ada dengan jenis tes dan nilai tes untuk user yang sama
        $tes = Tes::where('user_id', $user->id)
                ->whereNotNull('jenis_tes')
                ->whereNotNull('nilai_tes')
                ->get();

        if ($tes->isNotEmpty()) {
            // Update status tes untuk setiap entri tes yang ditemukan
            foreach ($tes as $t) {
                $t->status_tes = 'Ditolak';
                $t->save(); // Memperbarui status tes pada setiap entri
            }
        }
           
        // Buat entri tes baru jika tidak ada entri tes yang cocok
           if ($tes->isEmpty()) {
            Tes::create([
                'user_id' => $user->id,
                'jenis_tes' => $request->jenis_tes,
                'nilai_tes' => $request->nilai_tes,
                'status_tes' => 'Ditolak',
            ]);
        }

        return redirect()->route('tes.index')->with('error', 'Pegawai tidak lulus tahap tes.');
    }
    
    
    public function saveNote(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string|max:1000',
        ], [
            'catatan.required' => 'Catatan harus diisi',
            'catatan.max' => 'Catatan maksimal 1000 karakter',
        ]);
    
        // Ambil user_id dari entri tes dengan id yang diberikan
        $tes = Tes::findOrFail($id);
        $user_id = $tes->user_id;
    
        // Perbarui semua entri tes yang sesuai dengan user_id
        Tes::where('user_id', $user_id)->update(['catatan' => $request->input('catatan')]);
    
        return redirect()->route('tes.index')->with('success', 'Catatan berhasil disimpan.');
    }
    


    public function pencarian(Request $request)
    {
        $request->validate([
            'nama_pencarian' => 'required'
        ]);

        // Mencari pengguna berdasarkan nama yang cocok dengan input pencarian
        $data = User::where('name', 'LIKE', '%' . $request->nama_pencarian . '%')
            ->whereHas('daftar', function ($query) {
                $query->where('status_administrasi', 'Diterima');
            })
            ->with('tes')
            ->get();

        return view('tes.index', compact('data'))->with('calon_pegawai', $data);
    }
}
