<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Repositories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 columns-sm">
                    @foreach( $commits as $commit )
                        <div class="commit-box sm-6 border mb-4">
                            <p>Hash: {{ $commit->hash }}</p>
                            <p>Data: {{ date('d/m/Y', strtotime($commit->date)) }}</p>
                            <p>Repositorio: {{$commit->repository->full_name}}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>