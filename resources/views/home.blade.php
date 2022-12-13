@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home/styles.css') }}">
@endsection

@section('header')
    <h2 class="font-semibold text-xl text-center">
        {{ __('Reportei Tech Challenge') }}
    </h2>
@endsection

@section('slot')
<div class="content-container">
    <a href="{{ route('repos.index')}} " class="border border-slate-500 rounded-md p-2 hover:bg-gray-800">
        <i class="fa-solid fa-book-bookmark"></i>
        <span>
            Repositories
        </span>
    </a> 
</div>
@endsection
