<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demosi;
use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Auth;

class DemosiController extends Controller
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
            $demosi = Demosi::with('pegawai')->get();
        } else {
            $demosi = Demosi::with('pegawai')
                ->whereHas('pegawai', function ($query) use ($user_id) {
                    $query->where('user_id', $user_id); // Use the correct column name
                })
                ->get();
        }
    
        return view('demosi.index', compact('demosi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $pageTitle = 'Tambah Demosi';
        $pegawai = Pegawai::all();
        $jabatans = Jabatan::all();
        return view('demosi.create', compact('pegawai', 'jabatans', 'pageTitle'));
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
            'pegawai_id' => 'required',
            'jabatan_lama' => 'required',
            'jabatan_baru' => 'required',
            'tanggal_demosi' => 'required',
        ], [
            'pegawai_id.required' => 'Nama harus dipilih',
            'jabatan_baru.required' => 'Jabatan baru harus dipilih',
            'jabatan_lama.required' => 'Jabatan lama harus diisi',
            'tanggal_demosi.required' => 'Tanggal demosi harus diisi',
        ]);

        Demosi::create([
            'pegawai_id' => $request->pegawai_id,
            'jabatan_lama' => $request->jabatan_lama,
            'jabatan_baru' => $request->jabatan_baru,
            'tanggal_demosi' => $request->tanggal_demosi,
        ]);

        return redirect()->route('demosi.index')->with('success', 'Data demosi berhasil disimpan');
    }

    public function accept(Request $request, $id)
    {
        $demosi = Demosi::findOrFail($id);
        $demosi->status_demosi = 'Diterima';
        $demosi->save();

        // Update jabatan pegawai hanya jika demosi diterima
        $pegawai = Pegawai::findOrFail($demosi->pegawai_id);
        $pegawai->jabatan = $demosi->jabatan_baru;
        $pegawai->save();

        $request->session()->flash('success', 'Demosi pegawai telah diterima');
        return redirect()->route('demosi.index');
    }

    public function reject(Request $request, $id)
    {
        $demosi = Demosi::findOrFail($id);
        $demosi->status_demosi = 'Ditolak';
        $demosi->save();

        $request->session()->flash('delete', 'Demosi pegawai telah ditolak.');
        return redirect()->route('demosi.index');
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

        $demosi = Demosi::findOrFail($id);
        $demosi->catatan = $request->input($inputName);
        $demosi->save();

        return redirect()->route('demosi.index')->with('success', 'Catatan berhasil disimpan.');
    }

    public function Pencarian(Request $request)
    {
        $request->validate([
            'nama_pencarian' => 'required'
        ]);
    
        $data = Demosi::with('pegawai')
            ->whereHas('pegawai', function ($query) use ($request) {
                $query->where('nama', 'LIKE', '%' . $request->nama_pencarian . '%');
            })
            ->get();
    
        return view('demosi.index', ['demosi' => $data]);
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
