<x-layouts.app>
    <x-slot:title>Dashboard - Sistem Payroll</x-slot>

    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Selamat Datang di Dashboard</h1>
        <p class="text-gray-600">
            Anda berhasil masuk sebagai administrator. Gunakan menu di sebelah kiri untuk mengelola master data dan melakukan proses penggajian karyawan.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
            <div class="bg-blue-50 border border-blue-100 p-4 rounded-lg">
                <h3 class="text-blue-800 font-semibold">Total Karyawan</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ \App\Models\Karyawan::count() }}</p>
            </div>
            <div class="bg-green-50 border border-green-100 p-4 rounded-lg">
                <h3 class="text-green-800 font-semibold">Departemen</h3>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ \App\Models\Departemen::count() }}</p>
            </div>
            <div class="bg-purple-50 border border-purple-100 p-4 rounded-lg">
                <h3 class="text-purple-800 font-semibold">Total Jabatan</h3>
                <p class="text-3xl font-bold text-purple-600 mt-2">{{ \App\Models\Jabatan::count() }}</p>
            </div>
        </div>
    </div>
</x-layouts.app>