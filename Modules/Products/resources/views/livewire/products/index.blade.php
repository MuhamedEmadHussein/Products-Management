<div>
    <main class="nxl-container">
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
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center justify-content-between">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Product List</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Products</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="feather-plus me-2"></i> Add Product
                    </a>
                </div>
            </div>
    
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Main Content -->
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Product List</h5>
                                <div class="card-header-action">
                                    <div class="card-header-btn">
                                        <div data-bs-toggle="tooltip" title="Refresh">
                                            <a href="{{ route('products.index') }}" class="avatar-text avatar-xs bg-warning">
                                                <i class="feather-refresh-ccw"></i>
                                            </a>
                                        </div>
                                        <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                            <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success" data-bs-toggle="expand">
                                                <i class="feather-maximize"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body custom-card-action p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                                <th>Description</th>
                                                <th>Notes</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($products as $product)
                                                <tr>
                                                    <td>
                                                        <div class="hstack gap-3">
                                                            <div class="avatar-image avatar-lg rounded">
                                                                @if (Str::startsWith($product->image, 'https'))
                                                                    <img class="img-fluid" src="{{ asset('assets/images/product.png') }}" alt="No Image">
                                                                @else
                                                                    <img class="img-fluid" src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <a href="{{ route('products.edit', $product->id) }}">{{ $product->name }}</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ Str::limit($product->name, 50) }}</td>
                                                    <td>{{ $product->category->name }}</td>
                                                    <td>${{ number_format($product->price, 2) }}</td>
                                                    <td>{{ $product->stock }}</td>
                                                    <td>{{ Str::limit($product->description, 50) }}</td>
                                                    <td>{{ Str::limit($product->notes ?? 'N/A', 50) }}</td>
                                                    <td>
                                                        <span class="badge {{ $product->status ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                                            {{ $product->status ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $product->created_at?->format('Y-m-d') ?? 'N/A' }}</td>
                                                    <td class="text-end">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <a href="{{ route('products.edit', $product->id) }}" class="avatar-text avatar-md" data-bs-toggle="tooltip" title="Edit">
                                                                <i class="feather-edit"></i>
                                                            </a>
                                                            <button type="button" wire:click="confirmDelete({{ $product->id }})" class="avatar-text avatar-md border-0 bg-transparent" data-bs-toggle="tooltip" title="Delete">
                                                                <i class="feather-trash-2"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center">No products found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
