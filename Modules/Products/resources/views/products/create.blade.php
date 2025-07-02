@extends('layouts.app')

@section('content')

    <livewire:products::products.create />

@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:initialized', function() {
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: `<ul class="text-left">${@foreach ($errors->all() as $error) '<li>{{ $error }}</li>' @endforeach}</ul>`,
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
@endpush