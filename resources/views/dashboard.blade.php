@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')

@php
    use App\Models\User;

    $totalUtilisateurs = User::count();
    $totalClients = User::where('type', 'CLIENT')->count(); // adapte "CLIENT" selon ta logique
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-lg font-semibold mb-2">Utilisateurs</h2>
        <p class="text-2xl font-bold text-blue-600">2</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-lg font-semibold mb-2">Programmes enregistrés</h2>
        <p class="text-2xl font-bold text-black-600">125</p>
    </div>
</div>

    <div class="relative w-full ">
        
    </div>

@endsection
