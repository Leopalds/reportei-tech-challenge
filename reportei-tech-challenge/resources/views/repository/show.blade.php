@extends('layouts.app')

@section('header')
    <div class="grid grid-cols-12">
        <h2 class="text-xl col-start-3 col-span-7">
            {{ $repo->name }}
        </h2>
        <a class="col-span-2 text-cyan-600" href="{{ route('repos.index') }}">
            Voltar
        </a>
    </div>
@endsection

@section('slot')
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 columns-sm">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $chart->script() !!}
@endpush