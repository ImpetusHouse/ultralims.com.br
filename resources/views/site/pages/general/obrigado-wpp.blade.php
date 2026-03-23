@extends('site.layout')
@section('content')
    <section class="bg-white py-[10rem]">
        <div class="container px-4 mx-auto">
            <div class="flex flex-wrap items-center">
                <div class="w-full text-center mb-4 lg:mb-0">
                    <h2 class="text-7xl font-black font-heading mb-2">
                        <span style="color: {{ env('PRIMARY_COLOR') }}">Aguarde!</span>
                    </h2>
                    <div class="block-description text-7xl text-gray-600">Você está sendo redirecionado para o WhatsApp!</div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => location.href = '{{ str_replace('/ ', '/', $_GET['redirect']) }}', 2000);
        });
    </script>
@endpush
