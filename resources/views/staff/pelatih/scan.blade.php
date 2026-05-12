@extends('layouts.app')

@section('title', 'Scan QR Presensi - ' . $kegiatan->ekskul->nama)

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-200">
    <nav class="border-b border-white/10 bg-slate-900/50 backdrop-blur-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-16 gap-4">
                <a href="{{ route('pelatih.ekskul.show', $kegiatan->ekskul_id) }}" class="text-slate-400 hover:text-white transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-white">Scan QR: {{ $kegiatan->ekskul->nama }}</h1>
            </div>
        </div>
    </nav>

    <main class="max-w-xl mx-auto px-4 py-8">
        <div class="bg-slate-900/50 border border-white/10 rounded-3xl overflow-hidden shadow-2xl p-6 text-center">
            <div class="mb-8">
                <h2 class="text-lg font-bold text-white">Scanner Kehadiran</h2>
                <p class="text-sm text-slate-500 mt-1">Arahkan kamera ke kode QR siswa</p>
            </div>

            <div id="reader" class="overflow-hidden rounded-2xl border border-white/10 bg-black/40 mb-6 min-h-[300px] flex items-center justify-center relative">
                <div id="start-button-container" class="text-center p-8">
                    <button id="start-btn" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-bold text-sm transition-all shadow-lg shadow-blue-600/20 mb-4">
                        Mulai Scanner Kamera
                    </button>
                    <div class="mt-4 pt-4 border-t border-white/10">
                        <p class="text-xs text-slate-400 mb-3">Kamera tidak bisa aktif? Gunakan foto:</p>
                        <input type="file" id="qr-input-file" accept="image/*" class="hidden">
                        <label for="qr-input-file" class="cursor-pointer px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-xs font-medium text-slate-300 transition-all">
                            Pilih Foto / Ambil Gambar QR
                        </label>
                    </div>
                    <p class="text-[10px] text-slate-500 mt-6 italic">Catatan: Kamera langsung memerlukan HTTPS jika diakses via IP.</p>
                </div>
            </div>

            <div id="result-success" class="hidden mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20">
                <p class="text-emerald-400 font-bold text-sm" id="success-message"></p>
            </div>

            <div id="result-error" class="hidden mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20">
                <p class="text-red-400 font-bold text-sm" id="error-message"></p>
            </div>

            <div class="p-4 bg-white/5 rounded-2xl text-left border border-white/5">
                <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3">Siswa Terakhir Discan</h3>
                <div id="last-scanned" class="space-y-2">
                    <p class="text-xs text-slate-600 italic">Belum ada siswa yang discan.</p>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    const html5QrCode = new Html5Qrcode("reader");
    const qrConfig = { fps: 15, qrbox: { width: 250, height: 250 } };
    let isProcessing = false;

    document.getElementById('start-btn').addEventListener('click', function() {
        this.disabled = true;
        this.textContent = 'Menghubungkan Kamera...';
        
        // Check if secure context
        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
            showResult('error', 'Scanner QR memerlukan koneksi aman (HTTPS) untuk mengakses kamera pada IP publik.');
            this.disabled = false;
            this.textContent = 'Mulai Scanner Kamera';
            return;
        }

        html5QrCode.start({ facingMode: "environment" }, qrConfig, onScanSuccess)
        .then(() => {
            document.getElementById('start-button-container').classList.add('hidden');
        })
        .catch(err => {
            console.error("Error starting QR scanner", err);
            showResult('error', 'Gagal mengakses kamera. Pastikan izin diberikan.');
            this.disabled = false;
            this.textContent = 'Mulai Scanner Kamera';
        });
    });

    // File fallback logic
    const fileInput = document.getElementById('qr-input-file');
    fileInput.addEventListener('change', e => {
        if (e.target.files.length == 0) return;
        
        const imageFile = e.target.files[0];
        html5QrCode.scanFile(imageFile, true)
        .then(decodedText => {
            onScanSuccess(decodedText);
        })
        .catch(err => {
            console.error(err);
            showResult('error', 'Gagal membaca QR dari gambar. Pastikan gambar jelas.');
        });
    });

    const onScanSuccess = (decodedText, decodedResult) => {
        if (isProcessing) return;
        
        isProcessing = true;
        
        // Visual feedback
        document.getElementById('reader').classList.add('border-blue-500');
        
        fetch("{{ route('pelatih.presensi.processScan', $kegiatan) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ nis: decodedText })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showResult('success', data.message);
                updateLastScanned(data.siswa);
                
                // Beep or sound feedback if needed
                if (window.navigator.vibrate) window.navigator.vibrate(200);
            } else {
                showResult('error', data.message);
            }
        })
        .catch(error => {
            showResult('error', 'Terjadi kesalahan sistem.');
        })
        .finally(() => {
            setTimeout(() => {
                isProcessing = false;
                document.getElementById('reader').classList.remove('border-blue-500');
            }, 2000); // Wait 2 seconds before next scan
        });
    };

    function showResult(type, message) {
        const successDiv = document.getElementById('result-success');
        const errorDiv = document.getElementById('result-error');
        
        successDiv.classList.add('hidden');
        errorDiv.classList.add('hidden');
        
        if (type === 'success') {
            successDiv.classList.remove('hidden');
            document.getElementById('success-message').textContent = message;
        } else {
            errorDiv.classList.remove('hidden');
            document.getElementById('error-message').textContent = message;
        }
    }

    function updateLastScanned(name) {
        const container = document.getElementById('last-scanned');
        const time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        
        if (container.querySelector('p.italic')) {
            container.innerHTML = '';
        }
        
        const div = document.createElement('div');
        div.className = 'flex items-center justify-between p-2 bg-white/5 rounded-xl animate-pulse';
        div.innerHTML = `
            <span class="text-xs text-white font-medium">${name}</span>
            <span class="text-[10px] text-slate-500">${time}</span>
        `;
        
        container.prepend(div);
        
        // Keep only last 5
        if (container.children.length > 5) {
            container.lastElementChild.remove();
        }
        
        setTimeout(() => div.classList.remove('animate-pulse'), 1000);
    }

    html5QrCode.start({ facingMode: "environment" }, qrConfig, onScanSuccess);
</script>

<style>
    #reader video {
        border-radius: 1rem;
        object-fit: cover;
    }
    #reader {
        border: 2px solid rgba(255, 255, 255, 0.1);
        transition: border-color 0.3s;
    }
</style>
@endsection
