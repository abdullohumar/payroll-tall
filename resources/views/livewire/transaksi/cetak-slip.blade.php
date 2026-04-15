<div class="min-h-screen py-8 flex justify-center">
    
    <div class="bg-white w-full max-w-3xl p-10 shadow-lg border border-gray-200 print:shadow-none print:border-none print:p-0">
        
        <div class="flex justify-between items-center border-b-2 border-gray-800 pb-6 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-blue-800 tracking-wider">PAYROLL<span class="text-gray-800">PRO</span></h1>
                <p class="text-sm text-gray-600 mt-1">Gedung Tech Center, Lt. 9, Jakarta Selatan</p>
                <p class="text-sm text-gray-600">Telp: (021) 555-0192 | Email: hrd@payrollpro.com</p>
            </div>
            <div class="text-right">
                <h2 class="text-2xl font-bold text-gray-800 uppercase tracking-widest">Slip Gaji</h2>
                <p class="text-md font-semibold text-gray-600 mt-1">
                    Periode: {{ date('F', mktime(0, 0, 0, $penggajian->bulan, 10)) }} {{ $penggajian->tahun }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-8 bg-gray-50 p-4 rounded-lg border border-gray-200 print:bg-white">
            <div>
                <table class="w-full text-sm">
                    <tr><td class="py-1 text-gray-500 w-32">NIK</td><td class="font-bold">: {{ $penggajian->karyawan->nik }}</td></tr>
                    <tr><td class="py-1 text-gray-500">Nama Lengkap</td><td class="font-bold">: {{ $penggajian->karyawan->nama }}</td></tr>
                    <tr><td class="py-1 text-gray-500">Status</td><td class="font-bold">: Karyawan Tetap</td></tr>
                </table>
            </div>
            <div>
                <table class="w-full text-sm">
                    <tr><td class="py-1 text-gray-500 w-32">Departemen</td><td class="font-bold">: {{ $penggajian->karyawan->departemen->nama ?? '-' }}</td></tr>
                    <tr><td class="py-1 text-gray-500">Jabatan</td><td class="font-bold">: {{ $penggajian->karyawan->jabatan->nama ?? '-' }}</td></tr>
                    <tr><td class="py-1 text-gray-500">No. Rekening</td><td class="font-bold">: {{ $penggajian->karyawan->bank }} - {{ $penggajian->karyawan->no_rekening }}</td></tr>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8 mb-8">
            
            <div>
                <h3 class="font-bold text-gray-800 border-b border-gray-300 pb-2 mb-3 uppercase text-sm">Penerimaan</h3>
                <table class="w-full text-sm">
                    <tr>
                        <td class="py-2">Gaji Pokok</td>
                        <td class="py-2 text-right">Rp {{ number_format($penggajian->gaji_pokok, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="py-2">Tunjangan Tetap</td>
                        <td class="py-2 text-right">Rp {{ number_format($penggajian->tunjangan, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <div>
                <h3 class="font-bold text-red-700 border-b border-gray-300 pb-2 mb-3 uppercase text-sm">Potongan</h3>
                <table class="w-full text-sm">
                    <tr>
                        <td class="py-2">Potongan BPJS (3%)</td>
                        <td class="py-2 text-right text-red-600">( Rp {{ number_format($penggajian->potongan, 0, ',', '.') }} )</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="border-t-2 border-gray-800 pt-4 flex justify-between items-center mb-16">
            <h3 class="text-lg font-bold text-gray-800 uppercase">Total Take Home Pay</h3>
            <h2 class="text-2xl font-extrabold text-green-700">Rp {{ number_format($penggajian->total_gaji, 0, ',', '.') }}</h2>
        </div>

        <div class="grid grid-cols-2 gap-8 text-center text-sm mt-12 pt-8">
            <div>
                <p class="mb-20">Penerima,</p>
                <p class="font-bold underline">{{ $penggajian->karyawan->nama }}</p>
            </div>
            <div>
                <p class="mb-20">Mengetahui, HRD Manager</p>
                <p class="font-bold underline">Umar, S.Kom.</p>
            </div>
        </div>

        <div class="mt-16 text-center no-print border-t border-gray-200 pt-8">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow mr-2">
                🖨️ Cetak Dokumen
            </button>
            <a href="{{ route('penggajian.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded shadow">
                Kembali
            </a>
        </div>
    </div>

    <script>
        window.onload = function() {
            // Tunggu setengah detik agar font/CSS termuat sempurna, lalu buka dialog Print
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</div>