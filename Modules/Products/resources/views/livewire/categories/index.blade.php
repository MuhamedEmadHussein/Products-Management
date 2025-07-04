<div>
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- Loading State -->
            <div wire:loading class="text-center text-gray-600 mb-6">
                <svg class="animate-spin h-8 w-8 mx-auto text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p>{{ __('Loading...') }}</p>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">{{ __('Categories') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item">{{ __('Categories') }}</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto d-flex align-items-center">
                    {{-- <select wire:model="locale" wire:change="setLocale($event.target.value)" class="form-select me-3">
                        @foreach (config('translatable.locales', ['en']) as $locale)
                            <option value="{{ $locale }}">{{ strtoupper($locale) }}</option>
                        @endforeach
                    </select> --}}
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">
                        <i class="feather-plus me-2"></i>
                        <span>{{ __('Create Category') }}</span>
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger bg-red-500 text-white p-4 rounded-lg mb-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Content -->
            <div class="main-content">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Notes') }}</th>
                                        <th class="text-end">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->notes ?? __('N/A') }}</td>
                                            <td class="text-end">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="feather-edit"></i>
                                                    </a>
                                                    <button type="button" wire:click="confirmDelete({{ $category->id }})" class="btn btn-sm btn-danger">
                                                        <i class="feather-trash-2"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">{{ __('No categories found.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $categories->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('show-delete-confirmation', (event) => {
                Swal.fire({
                    title: '{{ __('Are you sure?') }}',
                    text: "{{ __('You won\'t be able to revert this!') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ __('Yes, delete it!') }}',
                    cancelButtonText: '{{ __('Cancel') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete-category');
                        Swal.fire(
                            '{{ __('Deleted!') }}',
                            '{{ __('The category has been deleted.') }}',
                            'success'
                        );
                    }
                });
            });
        });
    </script>
</div>