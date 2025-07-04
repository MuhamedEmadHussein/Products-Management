<div>
    <main class="nxl-container p-6">
        <div class="nxl-content">
            <!-- Loading State -->
            <div wire:loading class="text-center text-gray-600 mb-6">
                <svg class="animate-spin h-8 w-8 mx-auto text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p>Loading...</p>
            </div>

    
            <!-- Page Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ __('Create Category') }}</h1>
                    <nav class="text-sm text-gray-600">
                        <a href="{{ route('dashboard') }}" class="hover:text-blue-600">{{ __('Home') }}</a> / <a href="{{ route('categories.index') }}" class="hover:text-blue-600">{{ __('Categories') }}</a> / {{ __('Create') }}
                    </nav>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" form="category-form" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        {{ __('Save Category') }}
                    </button>
                    <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
            @endif
            
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    
            <!-- Main Content -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form id="category-form" wire:submit.prevent="createCategory">
                    <div class="grid grid-cols-1 gap-6">
                        <div class="mb-3">
                            <div class="alert alert-info">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ __('Currently editing in') }}: <strong>{{ strtoupper($locale) }}</strong></span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Category Name') }}</label>
                            <input type="text" class="form-control w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="name" wire:model="name" placeholder="{{ __('Enter category name') }}">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Notes') }}</label>
                            <textarea rows="4" class="form-control w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="notes" wire:model="notes" placeholder="{{ __('Enter notes') }}"></textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
