<div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
    <div class="sm:flex sm:items-start">
        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
            <h3 class="text-lg leading-6 font-medium text-gray-200">
                Edit Satuan
            </h3>
            <div class="mt-6 space-y-6">
                <!-- Nama Satuan -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300">
                        Nama Satuan <span class="text-rose-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input type="text" 
                               wire:model.defer="name" 
                               id="name" 
                               class="w-full px-4 py-2 rounded-lg bg-gray-700 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30" 
                               placeholder="Contoh: Lusin, Kilogram, dll">
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Simbol -->
                <div>
                    <label for="symbol" class="block text-sm font-medium text-gray-300">
                        Simbol <span class="text-rose-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input type="text" 
                               wire:model.defer="symbol" 
                               id="symbol" 
                               class="w-full px-4 py-2 rounded-lg bg-gray-700 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30" 
                               placeholder="Contoh: lsn, kg, dll">
                    </div>
                    @error('symbol')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300">
                        Deskripsi
                    </label>
                    <div class="mt-1">
                        <textarea wire:model.defer="description" 
                                  id="description" 
                                  rows="3" 
                                  class="w-full px-4 py-2 rounded-lg bg-gray-700 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30"
                                  placeholder="Deskripsi opsional untuk satuan ini"></textarea>
                    </div>
                    @error('description')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
    <button type="button"
            wire:click="save"
            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
        Simpan Perubahan
    </button>
    <button type="button"
            wire:click="$emit('closeModal')"
            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
        Batal
    </button>
</div> 