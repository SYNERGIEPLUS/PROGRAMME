@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <div class="mt-6">
        @livewire('programe-travail') {{-- Exemple de composant Livewire --}}
    </div>
@endsection
