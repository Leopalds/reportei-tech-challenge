@extends('layouts.app')

@section('header')
    <div class="grid grid-cols-12">
        @if (isset($repo))  
            <h2 class="text-xl col-start-3 col-span-7">
                {{ $repo->name ?? ''}}
            </h2>
        @else
            <h2 class="text-xl col-start-3 col-span-7 text-red-600">
                Repository Not Found
            </h2>
        @endif
        <a class="col-span-2 text-cyan-600" href="{{ route('repos.index') }}">
            Voltar
        </a>
    </div>
@endsection
@isset($chart)
    @section('slot')
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-3 xl:w-96">
                    <form method="get">
                        <label for="exampleNumber0" class="form-label inline-block mb-2 text-white"
                          >Number of Days</label
                        >
                        <input
                          type="number"
                          class=" form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                          id="exampleNumber0"
                          placeholder="90"
                          onchange="this.form.submit()"
                          value={{ request("how_many_days") ?? '90' }}
                          name="how_many_days"
                        />
                    </form>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h1 class="text-bold text-2xl ml-3 mt-4 mr-3">
                        Number of Commits in {{ $repo->full_name }} main branch by the last {{ request("how_many_days") ?? '90' }} days
                    </h1>
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
@endisset