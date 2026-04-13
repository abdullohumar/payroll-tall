<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Sistem Payroll</h2>
            <p class="text-sm text-gray-500 mt-2">Silakan login untuk melanjutkan</p>
        </div>

        <form wire:submit="authenticate">
            @error('email')
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
                    {{ $message }}
                </div>
            @enderror

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" wire:model="email" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="admin@sekolah.com" required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" wire:model="password" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="••••••••" required>
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out flex justify-center items-center">
                <span wire:loading.remove wire:target="authenticate">Login</span>
                <span wire:loading wire:target="authenticate">Memproses...</span>
            </button>
        </form>

    </div>
</div>