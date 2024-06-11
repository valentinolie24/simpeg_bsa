<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tes;
use App\Models\User;
use App\Models\PengumumanAkhir;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengumumanAkhirController extends Controller
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
        $user_id = Auth::user()->id;

        if ($user_role == 'calon_pegawai') {
            $calon_pegawai = User::where('id', $user_id)
                ->whereHas('tes', function ($query) {
                    $query->where('status_tes', 'Diterima');
                })
                ->with('pengumuman_akhir')
                ->first();

            return view('pengumuman-akhir.index', compact('calon_pegawai'));
        } elseif ($user_role == 'sdm') {
            $calon_pegawai = User::whereHas('tes', function ($query) {
                $query->where('status_tes', 'Diterima');
            })
            ->with('pengumuman_akhir')
            ->get();

            return view('pengumuman-akhir.index', compact('calon_pegawai'));
        } else {
            return view('pengumuman-akhir.index');
        }

    }

    public function pencarian(Request $request)
    {
        $request->validate([
            'nama_pencarian' => 'required'
        ]);

        // Mencari pengguna berdasarkan nama yang cocok dengan input pencarian
        $data = User::where('name', 'LIKE', '%' . $request->nama_pencarian . '%')
            ->whereHas('tes', function ($query) {
                $query->where('status_tes', 'Diterima');
            })
            ->with('pengumuman_akhir')
            ->get();

        return view('pengumuman-akhir.index', compact('data'))->with('calon_pegawai', $data);
    }


    public function accept(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Temukan atau buat entri pengumuman akhir
        $pengumumanAkhir = PengumumanAkhir::firstOrNew(['user_id' => $user->id]);

        // Perbarui status akhir
        $pengumumanAkhir->status_akhir = 'Diterima';
        $pengumumanAkhir->save();

        return redirect()->route('pengumuman-akhir.index')->with('success', 'Calon Pegawai lulus tahap akhir');
    }

    public function reject(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Temukan atau buat entri pengumuman akhir
        $pengumumanAkhir = PengumumanAkhir::firstOrNew(['user_id' => $user->id]);

        // Perbarui status akhir
        $pengumumanAkhir->status_akhir = 'Ditolak';
        $pengumumanAkhir->save();

        return redirect()->route('pengumuman-akhir.index')->with('error', 'Calon Pegawai tidak lulus tahap akhir');
    }

    public function saveNote(Request $request, $id)
    {
        // Ambil ID pengumuman_akhir dari request dan sesuaikan nama inputnya
        $inputName = 'catatan_' . $id;
        
        // Validasi input dengan nama yang dinamis
        $request->validate([
            $inputName => 'required|string|max:1000',
        ], [
            $inputName . '.required' => 'Catatan harus diisi',
            $inputName . '.max' => 'Catatan maksimal 1000 karakter',
        ]);
    
        // Cari entri pengumuman_akhir berdasarkan ID dan update catatan
        $pengumuman_akhir = PengumumanAkhir::findOrFail($id);
        $pengumuman_akhir->catatan = $request->input($inputName);
        $pengumuman_akhir->save();
    
        return redirect()->route('pengumuman-akhir.index')->with('success', 'Catatan berhasil disimpan.');
    }
    

    public function updateTanggalMasuk(Request $request, $id)
    {
        $now = Carbon::now();
        $request->validate([
            'tanggal_masuk' => 'required|date|after_or_equal:' . $now->format('Y-m-d\TH:i'),
        ]);

        $pengumumanAkhir = PengumumanAkhir::findOrFail($id);
        $pengumumanAkhir->tanggal_masuk = $request->input('tanggal_masuk');
        $pengumumanAkhir->save();

        return redirect()->route('pengumuman-akhir.index')->with('success', 'Tanggal masuk kerja berhasil disimpan.');
    }

    public function updateRole(Request $request, $id)
    {
        $pengumumanAkhir = PengumumanAkhir::findOrFail($id);
        $user = User::findOrFail($pengumumanAkhir->user_id);
        $user->role = $request->input('role');
        $user->save();

        return response()->json(['success' => true]);
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
