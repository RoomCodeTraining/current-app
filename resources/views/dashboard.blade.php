@extends('layouts.app')

@section('title', 'Mon tableau de bord')

@section('content')
    <header class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-white tracking-tight">Mon tableau de bord</h1>
                <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    Retrouvez ici toutes vos cartes digitales.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}#formulaire" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1C1C1A] text-sm font-medium hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Nouvelle carte
                </a>
                <form action="{{ route('modifier.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-white hover:border-[#1b1b18] dark:hover:border-[#EDEDEC] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </header>

    @if($myCards && $myCards->isNotEmpty())
        <section class="mb-8" aria-label="Vos cartes">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <h2 class="text-lg font-semibold text-[#1b1b18] dark:text-white">Vos cartes</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($myCards as $c)
                    <article class="rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] overflow-hidden">
                        <div class="p-4">
                            <div class="flex gap-3 items-center">
                                @if($c->avatar_path)
                                    <img src="{{ Storage::url($c->avatar_path) }}" alt="" class="w-12 h-12 rounded-full object-cover shrink-0" />
                                @else
                                    <div class="w-12 h-12 rounded-full bg-[#e8e8e6] dark:bg-[#2a2a28] flex items-center justify-center text-lg font-semibold text-[#706f6c] dark:text-[#A1A09A] shrink-0">
                                        {{ strtoupper(mb_substr($c->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-medium text-[#1b1b18] dark:text-white truncate">{{ $c->name }}</h3>
                                    <p class="text-xs font-mono text-[#706f6c] dark:text-[#A1A09A]">{{ $c->short_code }}</p>
                                </div>
                            </div>
                            <div class="mt-3 flex flex-wrap gap-2">
                                <a href="{{ route('card.show', $c->short_code) }}" target="_blank" rel="noopener" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1C1C1A] text-xs font-medium hover:opacity-90">Voir</a>
                                <a href="{{ route('modifier.index', ['card' => $c->short_code]) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] text-xs font-medium hover:bg-[#f5f5f4] dark:hover:bg-[#252523]">Modifier</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @else
        <section class="mb-8">
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                Vous n’avez pas encore de carte enregistrée dans cette session.
            </p>
            <p class="mt-2">
                <a href="{{ route('home') }}#formulaire" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1C1C1A] text-sm font-medium hover:opacity-90">
                    Créer ma première carte
                </a>
            </p>
        </section>
    @endif

    @if($card)
        <section class="mt-4 rounded-2xl bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] overflow-hidden" aria-label="Carte sélectionnée">
            <div class="p-5 sm:p-6">
                <h2 class="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] mb-3">Carte sélectionnée</h2>
                @include('partials.card-preview', ['card' => $card, 'showActions' => true])
            </div>
        </section>
    @endif
@endsection

