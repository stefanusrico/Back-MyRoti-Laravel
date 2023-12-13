<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Alokasi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_alokasi' => 'required',
            'lapak' => 'required|string',
            'jumlah_roti_terjual' => 'required|integer',
            'pendapatan' => 'required|numeric',
            'hutang' => 'required|numeric',
            'catatan' => 'nullable|string',
            'tanggal_transaksi' => 'required|date',
        ]);

        $jumlahRotiAlokasi = Alokasi::findOrFail($request->id_alokasi)->jumlah_roti_alokasi;

        $jumlahRotiTidakTerjual = $jumlahRotiAlokasi - $request->jumlah_roti_terjual;

        $validatedData['jumlah_roti_tidak_terjual'] = max(0, $jumlahRotiTidakTerjual);

        $transaksi = Transaksi::create($validatedData);

        return response()->json(['message' => 'Transaksi created successfully', 'data' => $transaksi], 201);
    }

    public function getDataHarian(Request $request)
    {
        try {
            $request->validate([
                'tanggal' => 'required|date_format:Y-m-d',
            ]);

            $tanggal = $request->input('tanggal');

            $formattedTanggal = Carbon::createFromFormat('Y-m-d', $tanggal)->format('m/d/y');

            $transaksi = DB::table('transaksi')
                ->join('alokasi', 'transaksi.id_alokasi', '=', 'alokasi.id')
                ->join('lapak', 'alokasi.id_lapak', '=', 'lapak.id')
                ->join('kurir', 'lapak.id_kurir', '=', 'kurir.id')
                ->join('users', 'kurir.id_user', '=', 'users.id')
                ->select('transaksi.id as id', 'transaksi.id_alokasi as id_alokasi', 'transaksi.lapak as lapak', 'transaksi.jumlah_roti_terjual as jumlah_roti_terjual', 'transaksi.jumlah_roti_tidak_terjual as jumlah_roti_tidak_terjual', 'transaksi.pendapatan as pendapatan', 'transaksi.hutang as hutang', 'transaksi.catatan as catatan', 'transaksi.tanggal_transaksi as tanggal_transaksi', 'users.name as kurir')
                ->where('tanggal_transaksi', $formattedTanggal)
                ->get();

            return response()->json(['message' => $transaksi], 200);
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDataBulanan(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $transaksi = DB::table('transaksi')
            ->join('alokasi', 'transaksi.id_alokasi', '=', 'alokasi.id')
            ->join('lapak', 'alokasi.id_lapak', '=', 'lapak.id')
            ->join('kurir', 'lapak.id_kurir', '=', 'kurir.id')
            ->join('users', 'kurir.id_user', '=', 'users.id')
            ->select('transaksi.id as id', 'transaksi.id_alokasi as id_alokasi', 'transaksi.lapak as lapak', 'transaksi.jumlah_roti_terjual as jumlah_roti_terjual', 'transaksi.jumlah_roti_tidak_terjual as jumlah_roti_tidak_terjual', 'transaksi.pendapatan as pendapatan', 'transaksi.hutang as hutang', 'transaksi.catatan as catatan', 'transaksi.tanggal_transaksi as tanggal_transaksi', 'users.name as kurir')
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->get();

        return response()->json(['message' => $transaksi], 200);
    }

    public function destroy($id)
    {
        try {
            $transaksi = DB::table('transaksi')->where('id', $id)->delete();
            if ($transaksi) {
                return response()->json(['message' => 'Transaksi deleted sucessfully'], 200);
            } else {
                return response()->json(['message' => 'Transaksi not found'], 404);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting transaksi'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $transaksi = DB::table('transaksi')->where('id', $id)->first();

            if (!$transaksi) {
                return response()->json(['message' => 'Transaksi not found'], 404);
            }

            $validatedData = $request->validate([
                'jumlah_roti_terjual' => 'required|integer',
                'jumlah_roti_tidak_terjual' => 'required|integer',
                'catatan' => 'required|string',
                'tanggal_transaksi' => 'required|date',
            ]);

            DB::table('transaksi')->where('id', $id)->update([
                'jumlah_roti_terjual' => $validatedData['jumlah_roti_terjual'],
                'jumlah_roti_tidak_terjual' => $validatedData['jumlah_roti_tidak_terjual'],
                'catatan' => $validatedData['catatan'],
                'tanggal_transaksi' => $validatedData['tanggal_transaksi'],
            ]);

            return response()->json(['message' => 'Transaksi updated successfully']);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error updating Transaksi'], 500);
        }
    }

    public function getPendapatanHari()
    {
        $tanggalHariIni = Carbon::today();

        $pendapatan = DB::table('transaksi')
            ->whereDate('tanggal_transaksi', $tanggalHariIni)
            ->sum('pendapatan');

        return $pendapatan;
    }

    public function getPendapatanMinggu()
    {
        $tujuhHariIni = Carbon::today()->subDays(7);

        $pendapatan = DB::table('transaksi')
            ->where('tanggal_transaksi', '>=', $tujuhHariIni)
            ->where('tanggal_transaksi', '<=', Carbon::today())
            ->sum('pendapatan');

        return $pendapatan;
    }

    public function getPendapatanBulan()
    {
        $bulanIni = Carbon::today()->startOfMonth();
        $bulanIniAkhir = Carbon::today()->endOfMonth();

        $pendapatan = DB::table('transaksi')
            ->where('tanggal_transaksi', '>=', $bulanIni)
            ->where('tanggal_transaksi', '<=', $bulanIniAkhir)
            ->sum('pendapatan');

        return $pendapatan;
    }

    public function getPendapatanTahun()
    {
        $tahunIni = Carbon::today()->startOfYear();
        $tahunIniAkhir = Carbon::today()->endOfYear();

        $pendapatan = DB::table('transaksi')
            ->where('tanggal_transaksi', '>=', $tahunIni)
            ->where('tanggal_transaksi', '<=', $tahunIniAkhir)
            ->sum('pendapatan');

        return $pendapatan;
    }

}