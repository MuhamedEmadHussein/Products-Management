@extends('layouts.app')

@section('content')
    <livewire:products::home />
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Initialize counter animation (if using a counter plugin like jQuery CountUp)
            $('.counter').each(function() {
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function(now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });
        });
    </script>
@endpush
