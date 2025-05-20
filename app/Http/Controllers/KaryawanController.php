<?php

namespace App\Http\Controllers;

use App\Models\tr_absen;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    public function index()
    {
        $breadcrumbTitle = 'Karyawan';
        $breadcrumbs = [
            ['title' => 'Data Karyawan', 'url' => '/category'],
            ['title' => 'absensi', 'url' => '/absensi'],
        ];
        $karyawan = User::all();
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);
        return view('dashboard.karyawan.index', [
            'title' => 'Karyawan',
            'active' => 'karyawan',
            'data' => $karyawan
        ]);
    }

    public function data_absen()
    {
        $breadcrumbTitle = 'Data Absensi Karyawan';
        $breadcrumbs = [
            ['title' => 'Data Karyawan', 'url' => '/category'],
            ['title' => 'absensi', 'url' => '/data-absensi'],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);

        return view('dashboard.karyawan.data_absensi', [
            'title' => 'Data Absensi',
            'active' => 'data-absensi',
            'data' => tr_absen::with('user')->get()
        ]);
    }
    // public function data_kehadiran()
    // {
    //     $breadcrumbTitle = 'Data Absensi Karyawan';
    //     $breadcrumbs = [
    //         ['title' => 'Data Karyawan', 'url' => '/category'],
    //         ['title' => 'absensi', 'url' => '/data-absensi'],
    //     ];
    //     $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);

    //     Carbon::setLocale('id');
    //     setlocale(LC_TIME, 'id_ID.utf8');

    //     $tanggalHariIni = Carbon::now();
    //     $jumlahHari = $tanggalHariIni->daysInMonth;
    //     $hariDalamSebulan = [];

    //     for ($i = 1; $i <= $jumlahHari; $i++) {
    //         $tanggal = Carbon::create($tanggalHariIni->year, $tanggalHariIni->month, $i);
    //         $hariDalamSebulan[] = [
    //             'tanggal' => $tanggal->format('Y-m-d'),
    //             'hari' => $tanggal->translatedFormat('l') // Harusnya sudah Bahasa Indonesia
    //         ];
    //     }

    //     return view('dashboard.karyawan.data_kehadiran', [
    //         'title' => 'Data Absensi',
    //         'active' => 'data-absensi',
    //         'hariDalamSebulan' => $hariDalamSebulan
    //     ]);
    // }

    public function data_kehadiran(Request $request)
    {
        $breadcrumbTitle = 'Data Absensi Karyawan';
        $breadcrumbs = [
            ['title' => 'Data Karyawan', 'url' => '/category'],
            ['title' => 'absensi', 'url' => '/data-absensi'],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);

        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.utf8');

        $tanggalHariIni = Carbon::now();
        $bulan = $request->bulan ?? $tanggalHariIni->month;  // Default bulan ini
        $tahun = $request->tahun ?? $tanggalHariIni->year;  // Default tahun ini
        $jumlahHari = Carbon::create($tahun, $bulan, 1)->daysInMonth;
        $hariDalamSebulan = [];

        $userId = Auth::id();
        $dataAbsensi = tr_absen::where('id_user', $userId)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->keyBy('tanggal');

        for ($i = 1; $i <= $jumlahHari; $i++) {
            $tanggal = Carbon::create($tahun, $bulan, $i)->format('Y-m-d');
            $absen = $dataAbsensi->get($tanggal);

            $hariDalamSebulan[] = [
                'tanggal' => $tanggal,
                'hari' => Carbon::parse($tanggal)->translatedFormat('l'),
                'status' => $absen ? 'Hadir' : 'Tidak Hadir',
                'jam_masuk' => $absen->jam_masuk ?? '-',
                'jam_pulang' => $absen->jam_pulang ?? '-',
            ];
        }

        return view('dashboard.karyawan.data_kehadiran', [
            'title' => 'Data Absensi',
            'active' => 'data-absensi',
            'hariDalamSebulan' => $hariDalamSebulan
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe_absen' => 'required|in:in,out',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $userId = Auth::id();
        $tanggal = date('Y-m-d');
        $jamSekarang = date('H:i:s');

        $absensi = tr_absen::firstOrNew([
            'id_user' => $userId,
            'tanggal' => $tanggal
        ]);

        if ($validated['tipe_absen'] === 'in') {
            $absensi->jam_masuk = $jamSekarang;
        } else {
            $absensi->jam_pulang = $jamSekarang;
        }

        $absensi->latitude = $validated['latitude'];
        $absensi->longitude = $validated['longitude'];
        $absensi->id_user = $userId;
        $absensi->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Absensi berhasil dicatat!',
            'data' => $absensi
        ]);
    }
}
