<div>
    <main class="nxl-container p-6">
        <div class="nxl-content">
            <!-- Loading State -->
            <div wire:loading class="text-center text-gray-600 mb-6">
                <svg class="animate-spin h-8 w-8 mx-auto text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p>{{ __('Loading...') }}</p>
            </div>
    
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    
            <!-- Page Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ __('Create Product') }}</h1>
                    <nav class="text-sm text-gray-600">
                        <a href="{{ route('dashboard') }}" class="hover:text-blue-600">{{ __('Home') }}</a> / <a href="{{ route('products.index') }}" class="hover:text-blue-600">{{ __('Products') }}</a> / {{ __('Create') }}
                    </nav>
                </div> 
            </div>
    
            <!-- Main Content -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form id="product-form" wire:submit.prevent="createProduct" enctype="multipart/form-data">
                    <!-- Current Language Indicator -->
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
                    
                    <!-- Image Upload -->
                    <div class="px-4 pt-4">
                        <div class="d-md-flex align-items-center justify-content-between">
                            <div class="mb-4 mb-md-0 your-brand">
                                <div class="wd-100 ht-100 position-relative overflow-hidden border border-gray-200 rounded">
                                    <img src="{{ asset('assets/images/product.png') }}" class="upload-pic img-fluid rounded h-100 w-100" alt="Product Image" wire:ignore>
                                    <div class="position-absolute start-50 top-50 end-0 bottom-0 translate-middle h-100 w-100 hstack align-items-center justify-content-center c-pointer upload-button">
                                        <i class="feather feather-camera" aria-hidden="true"></i>
                                    </div>
                                    <input class="file-upload" type="file" wire:model="image" accept="image/jpeg,image/png,image/jpg">
                                </div>
                                <div class="fs-12 text-muted mt-2">* {{ __('Upload Product Image (JPG, PNG, JPEG, max 2MB, choose twice to ensure uploading)') }}</div>
                                @error('image')
                                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr class="my-6 border-gray-200">
                    <!-- Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Product Name') }}</label>
                            <input type="text" class="form-control w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="name" wire:model="name" placeholder="{{ __('Enter product name') }}">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Category') }}</label>
                            <select class="form-control w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="category_id" wire:model="category_id">
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Price') }}</label>
                            <input type="number" step="0.01" class="form-control w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="price" wire:model="price" placeholder="{{ __('Enter price') }}">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Stock') }}</label>
                            <input type="number" class="form-control w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="stock" wire:model="stock" placeholder="{{ __('Enter stock quantity') }}">
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Status') }}</label>
                            <select class="form-control w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="status" wire:model="status">
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Inactive') }}</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <hr class="my-6 border-gray-200">
                    <!-- Descriptions -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Description') }}</label>
                        <textarea rows="4" class="form-control w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="description" wire:model="description" placeholder="{{ __('Enter description') }}"></textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Notes') }}</label>
                        <textarea rows="4" class="form-control w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="notes" wire:model="notes" placeholder="{{ __('Enter notes') }}"></textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex space-x-2">
                    <button type="submit" form="product-form" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        {{ __('Save Product') }}
                    </button>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                        {{ __('Cancel') }}
                    </a>
                </div>
                </form>
            </div>
        </div>
    </main>
</div>
