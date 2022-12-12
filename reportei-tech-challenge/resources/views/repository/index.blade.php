@extends('layouts.app')

@section('header')
    <div class="grid grid-cols-12">
        <h2 class="text-xl col-start-3 col-span-7">
            {{ __('Repositories') }}
        </h2>
        <a class="col-span-2 text-cyan-600" href="{{ route('home') }}">
            Voltar
        </a>
    </div>
@endsection

@section('slot')
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-6 divide-y divide-slate-500">
                    <div class="divider"></div>
                    @foreach( $repositories as $repo )
                        <div class="py-6 grid grid-cols-12 px-4">
                            <a class="repo-link text-cyan-600 col-span-8" href="{{ route('repos.show', [
                                'owner' => $repo->owner,
                                'repo_name' => $repo->name
                            ]) }}">
                                <h3 class="font-bold">
                                    {{ $repo->full_name }}
                                    @if ($repo->owner == auth()->user()->github_nickname)
                                        <sup class="border border-sky-500 rounded-2xl px-1.5"><small>yours</small></sup>
                                    @endif
                                </h3>
                                
                            </a>
                            <a class="col-span-4" href="{{ $repo->link }}" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square" style="filter: invert(100%);"></i></a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection