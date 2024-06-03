<?php

namespace App\Http\Controllers;

use App\Models\Daftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LowonganController;
use Illuminate\Support\Facades\Session;
use App\Models\Lowongan;



class DaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // private $lowonganController;

    // public function __construct(LowonganController $lowonganController)
    // {
    //     $this->lowonganController = $lowonganController;
    // }
    
    public function index(Request $request)
    {
        //
        // $pageTitle = 'Daftar';
        // $daftars = Daftar::all();
        // return view('daftar.index', compact('pageTitle', 'daftars'));
        // $id_lowongan = Session::get('id');
        // if($id_lowongan == null){
        //     return $this->lowonganController->index();
        // }
        // $id_lowongan = Session::get('id');
        $lowongan_id = $request->input('lowongan_id');
        // dd($lowongan_id);
        $lowongan = Lowongan::find($lowongan_id);
        // dd($lowongan);
        
        // dd($lowongan);

        // $id_lowongan = Session::get('id');
        // $lowongan = Lowongan::find($id_lowongan);

        $pageTitle = 'Daftar';
        $daftars = Daftar::all();
        return view('daftar.index', compact('pageTitle', 'daftars', 'lowongan'));
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

        // dd($request->lowongan_id);
        $validatedData = $request->validate([
            'cv' => 'required|file|mimes:pdf|max:2000', // CV dalam format PDF dengan maksimal 2MB
            'surat_lamaran' => 'required|file|mimes:pdf|max:2000', // Surat lamaran dalam format PDF dengan maksimal 2MB
            'data_pendukung' => 'file|mimes:pdf|max:2000', // Data pendukung dalam format PDF dengan maksimal 2MB (opsional)
            'lowongan_id' => 'required|exists:lowongans,id'
            
        ], [
            'cv.required' => 'File CV harus diunggah.',
            'cv.file' => 'File CV harus berupa file PDF.',
            'cv.mimes' => 'File CV harus berformat PDF.',
            'cv.max' => 'Ukuran file CV tidak boleh lebih dari 2MB.',
            'surat_lamaran.required' => 'File surat lamaran harus diunggah.',
            'surat_lamaran.file' => 'File surat lamaran harus berupa file PDF.',
            'surat_lamaran.mimes' => 'File surat lamaran harus berformat PDF.',
            'surat_lamaran.max' => 'Ukuran file surat lamaran tidak boleh lebih dari 2MB.',
            'data_pendukung.file' => 'File data pendukung harus berupa file PDF.',
            'surat_lamaran.required' => 'File surat lamaran harus diunggah.',
            'data_pendukung.mimes' => 'File data pendukung harus berformat PDF.',
            'data_pendukung.max' => 'Ukuran file data pendukung tidak boleh lebih dari 2MB.',
        ]);

        // CV
        $cvName = 'cv-' . time() . '.pdf';
        $cvPath = $request->file('cv')->storeAs('public/daftar', $cvName);

        $suratLamaranName = 'surat_lamaran-' . time() . '.pdf';
        $suratLamaranPath = $request->file('surat_lamaran')->storeAs('public/daftar', $suratLamaranName);

        $dataPendukungName = null;
        if ($request->hasFile('data_pendukung')) {
            $dataPendukungName = 'data_pendukung-' . time() . '.pdf';
            $dataPendukungPath = $request->file('data_pendukung')->storeAs('public/daftar', $dataPendukungName);
        }
        $lowongan_id = $request->lowongan_id;

        $daftar = new Daftar();
        $daftar->user_id = Auth::id();
        $daftar->cv = $cvName;
        $daftar->lowongan_id = $lowongan_id; // Simpan id lowongan
        $daftar->surat_lamaran = $suratLamaranName;
        $daftar->data_pendukung = $dataPendukungName;
        $daftar->save();

        return redirect()->route('lowongan.index')->with('success', 'CV dan surat lamaran telah diunggah.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Daftar  $daftar
     * @return \Illuminate\Http\Response
     */
    public function show(Daftar $daftar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Daftar  $daftar
     * @return \Illuminate\Http\Response
     */
    public function edit(Daftar $daftar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Daftar  $daftar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Daftar $daftar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Daftar  $daftar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Daftar $daftar)
    {
        //
    }
}
