<div>
    <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Proses Penggajian</h2>
            <p class="text-sm text-gray-600">Generate slip gaji karyawan secara massal.</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
        
        <div class="flex items-center gap-3 w-full md:w-auto">
            <div class="flex flex-col">
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Bulan</label>
                <select wire:model.live="bulan" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 focus:ring-blue-500 focus:border-blue-500 bg-white">
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tahun</label>
                <select wire:model.live="tahun" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 focus:ring-blue-500 focus:border-blue-500 bg-white">
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                </select>
            </div>
        </div>

        <div class="w-full md:w-auto">
            <button wire:click="generatePayroll" 
                    wire:confirm="PERINGATAN: Sistem akan menghitung dan mencetak gaji untuk seluruh karyawan aktif di periode {{ $bulan }}/{{ $tahun }}. Lanjutkan?" 
                    class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" /></svg>
                Proses Gaji Massal
            </button>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-700">Daftar Gaji Periode: <span class="text-indigo-600">{{ $bulan }}/{{ $tahun }}</span></h3>
            <div class="w-64 relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama karyawan..." class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                        <th class="px-6 py-3 border-b border-gray-200">Karyawan</th>
                        <th class="px-6 py-3 border-b border-gray-200">Pendapatan</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-red-600">Potongan</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-green-600">Gaji Bersih (Netto)</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($penggajians as $gaji)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800 text-sm">{{ $gaji->karyawan->nama }}</div>
                                <div class="text-xs text-gray-500">{{ $gaji->karyawan->jabatan->nama ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div>Gapok: Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</div>
                                <div>Tunj: Rp {{ number_format($gaji->tunjangan, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-red-600">
                                Rp {{ number_format($gaji->potongan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-green-700 text-lg">
                                Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-center font-medium">
                                <button class="text-blue-600 hover:text-blue-900 mr-3 opacity-50 cursor-not-allowed" title="Cetak Slip (Tahap 12)">Cetak</button>
                                <button wire:click="delete({{ $gaji->id }})" wire:confirm="Yakin hapus data slip gaji ini?" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-500 text-lg font-medium">Belum ada data gaji untuk periode ini.</p>
                                <p class="text-gray-400 text-sm mt-1">Silakan klik "Proses Gaji Massal" di atas untuk menghitung gaji karyawan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">{{ $penggajians->links() }}</div>
    </div>
</div>