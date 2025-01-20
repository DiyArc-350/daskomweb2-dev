<?php

namespace App\Http\Controllers\API;

use App\Models\Asisten;
use Illuminate\Http\Request;
use App\Models\LaporanPraktikan;
use App\Http\Controllers\Controller;
use Illuminate\Container\Attributes\Auth;

class LaporanPraktikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pesan' => 'required|string',
            'kode' => 'required|string|max:3',
            'modul_id' => 'required|integer',
        ]);

        $asisten = Asisten::where("kode",$request->kode)->first();
        $laporan = LaporanPraktikan::create([
            'pesan' => $request->pesan,
            'asisten_id' => $asisten->id,
            'modul_id' => $request->modul_id,
            'praktikan_id' => $request->praktikan_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Feedback berhasil dikirim',
        ]);
    
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $laporan = LaporanPraktikan::where('asisten_id', $id)
            ->leftJoin('moduls', 'moduls.id', '=', 'laporan_praktikans.modul_id')
            ->leftJoin('praktikans', 'praktikans.id', '=', 'laporan_praktikans.praktikan_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'praktikans.kelas_id')
            ->select(
                'laporan_praktikans.pesan',
                'laporan_praktikans.created_at',
                'laporan_praktikans.updated_at',
                'laporan_praktikans.id',
                'laporan_praktikans.asisten_id',
                'laporan_praktikans.modul_id',
                'laporan_praktikans.praktikan_id',
                'moduls.judul as modul_judul',
                'kelas.kelas as kelas',
                'kelas.id as id_kelas',
                'kelas.hari as hari',
                'kelas.shift as shift',
                'praktikans.nim as nim',
                'praktikans.nama as nama'
            )->get();


        return response()->json([
            'laporan' => $laporan,
            'message' => 'Laporan praktikan retrieved successfully.'
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
