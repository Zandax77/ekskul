<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekskul;
use App\Models\Kegiatan;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Prestasi;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Storage;

class PelatihController extends Controller
{
    public function index(): View
    {
        $pelatih = Auth::guard('pelatih')->user();
        $ekskuls = $pelatih->ekskuls;
        
        return view('staff.pelatih.dashboard', compact('ekskuls'));
    }

    public function show(Ekskul $ekskul): View
    {
        // Ensure this pelatih manages this ekskul
        if ($ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            abort(403);
        }

        $ekskul->load(['kegiatans', 'siswas', 'prestasis.siswa']);
        return view('staff.pelatih.ekskul-detail', compact('ekskul'));
    }

    public function storeKegiatan(Request $request, Ekskul $ekskul): RedirectResponse
    {
        if ($ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            abort(403);
        }

        $request->validate([
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $ekskul->kegiatans()->create($request->all());

        return back()->with('success', 'Jadwal latihan baru berhasil ditambahkan.');
    }

    public function presensi(Kegiatan $kegiatan): View
    {
        if ($kegiatan->ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            abort(403);
        }

        $kegiatan->load(['ekskul.siswas', 'presensis']);
        return view('staff.pelatih.presensi', compact('kegiatan'));
    }

    public function storePresensi(Request $request, Kegiatan $kegiatan): RedirectResponse
    {
        if ($kegiatan->ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            abort(403);
        }

        $request->validate([
            'presensi' => ['required', 'array'],
            'presensi.*' => ['required', 'in:hadir,izin,sakit,alfa'],
        ]);

        foreach ($request->presensi as $siswaId => $status) {
            Presensi::updateOrCreate(
                ['kegiatan_id' => $kegiatan->id, 'siswa_id' => $siswaId],
                ['status' => $status]
            );
        }

        return redirect()->route('pelatih.ekskul.show', $kegiatan->ekskul_id)
            ->with('success', 'Kehadiran berhasil dicatat.');
    }

    public function storePrestasi(Request $request, Ekskul $ekskul): RedirectResponse
    {
        if ($ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            abort(403);
        }

        $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'sertifikat' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
        ]);

        $data = $request->only(['siswa_id', 'judul', 'deskripsi', 'tanggal']);
        $data['ekskul_id'] = $ekskul->id;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('prestasi/foto', 'public');
        }

        if ($request->hasFile('sertifikat')) {
            $data['sertifikat'] = $request->file('sertifikat')->store('prestasi/sertifikat', 'public');
        }

        Prestasi::create($data);

        return back()->with('success', 'Catatan prestasi berhasil ditambahkan.');
    }

    public function penilaian(Ekskul $ekskul): View
    {
        if ($ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            abort(403);
        }

        // Load siswas and their corresponding penilaian for this ekskul
        $ekskul->load(['siswas.penilaians' => function ($query) use ($ekskul) {
            $query->where('ekskul_id', $ekskul->id);
        }]);

        return view('staff.pelatih.penilaian', compact('ekskul'));
    }

    public function storePenilaian(Request $request, Ekskul $ekskul): RedirectResponse
    {
        if ($ekskul->pelatih_id !== Auth::guard('pelatih')->id()) {
            abort(403);
        }

        $request->validate([
            'penilaian' => ['required', 'array'],
            'penilaian.*.nilai' => ['required', 'string', 'max:5'],
            'penilaian.*.keterangan' => ['nullable', 'string'],
        ]);

        $pelatihId = Auth::guard('pelatih')->id();

        foreach ($request->penilaian as $siswaId => $data) {
            Penilaian::updateOrCreate(
                [
                    'ekskul_id' => $ekskul->id,
                    'siswa_id' => $siswaId,
                ],
                [
                    'pelatih_id' => $pelatihId,
                    'nilai' => $data['nilai'],
                    'keterangan' => $data['keterangan'] ?? null,
                ]
            );
        }

        return redirect()->route('pelatih.ekskul.show', $ekskul->id)
            ->with('success', 'Nilai peserta ekskul berhasil disimpan.');
    }
}
