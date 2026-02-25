@extends('layouts.app')

@section('title', $card ? $card->name . ' – Carte de visite' : 'Carte de visite digitale')

@section('content')
    <div class="w-full md:flex md:items-center md:justify-center">
        @if($myCards && $myCards->isNotEmpty())
            <section class="mb-8 w-full" aria-label="Vos cartes">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                    <h2 class="text-lg font-semibold text-[#1b1b18] dark:text-white">Votre espace</h2>
                    <a href="{{ route('modifier.index') }}" class="text-sm font-medium text-[#f53003] dark:text-[#FF4433] hover:underline">Mon espace →</a>
                </div>
                @php
                    $lastUpdated = $myCards->max('updated_at');
                    $lastLabel = $lastUpdated ? \Carbon\Carbon::parse($lastUpdated)->locale('fr')->diffForHumans() : '—';
                @endphp
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 mb-4">
                    <div class="rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-[#fafaf9] dark:bg-[#1c1c1a] p-4 text-center">
                        <p class="text-2xl font-semibold text-[#1b1b18] dark:text-white tabular-nums">{{ $myCards->count() }}</p>
                        <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-0.5">carte(s)</p>
                    </div>
                    <div class="rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-[#fafaf9] dark:bg-[#1c1c1a] p-4 text-center">
                        <p class="text-sm font-medium text-[#1b1b18] dark:text-white truncate">{{ $lastLabel }}</p>
                        <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-0.5">dernière modif.</p>
                    </div>
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
                                    <a href="{{ route('modifier.switch', $c->short_code) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] text-xs font-medium hover:bg-[#f5f5f4] dark:hover:bg-[#252523]">Modifier</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        @if($newCardCode && $newCardIdentifier)
            <div class="mb-6 p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800">
                <p class="text-sm font-medium text-amber-800 dark:text-amber-200">Gardez ces infos pour modifier votre carte plus tard</p>
                <div class="mt-3 space-y-2">
                    <div>
                        <p class="text-xs text-amber-700 dark:text-amber-300">Identifiant</p>
                        <div class="mt-0.5 flex items-center gap-2">
                            <p class="text-xl font-mono tracking-widest text-amber-900 dark:text-amber-100">{{ $newCardIdentifier }}</p>
                            <button
                                type="button"
                                class="copy-inline text-xs px-2 py-1 rounded-full border border-amber-300/80 text-amber-800 dark:text-amber-100 dark:border-amber-600/60 bg-amber-50/80 dark:bg-amber-900/30"
                                data-copy="{{ $newCardIdentifier }}"
                            >
                                Copier
                            </button>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-amber-700 dark:text-amber-300">Code à 6 chiffres</p>
                        <div class="mt-0.5 flex items-center gap-2">
                            <p class="text-xl font-mono tracking-widest text-amber-900 dark:text-amber-100">{{ $newCardCode }}</p>
                            <button
                                type="button"
                                class="copy-inline text-xs px-2 py-1 rounded-full border border-amber-300/80 text-amber-800 dark:text-amber-100 dark:border-amber-600/60 bg-amber-50/80 dark:bg-amber-900/30"
                                data-copy="{{ $newCardCode }}"
                            >
                                Copier
                            </button>
                        </div>
                    </div>
                </div>
                <p class="mt-3"><a href="{{ route('card.show', $newCardIdentifier) }}" class="text-sm font-medium text-amber-800 dark:text-amber-200 underline">Voir ma carte →</a></p>
            </div>
        @endif

        @if($card)
            <section class="mb-8 rounded-2xl bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] overflow-hidden">
                <div class="p-5 sm:p-6">
                    <div class="flex gap-4 items-center">
                        @if($card->avatar_path)
                            <img src="{{ Storage::url($card->avatar_path) }}" alt="{{ $card->name }}" class="w-16 h-16 rounded-full object-cover shrink-0" />
                        @else
                            <div class="w-16 h-16 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A] flex items-center justify-center text-2xl font-medium text-[#706f6c] dark:text-[#A1A09A] shrink-0">
                                {{ strtoupper(mb_substr($card->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <h2 class="text-lg font-semibold truncate">{{ $card->name }}</h2>
                            @if($card->title)<p class="text-sm text-[#706f6c] dark:text-[#A1A09A] truncate">{{ $card->title }}</p>@endif
                            @if($card->company)<p class="text-xs text-[#706f6c] dark:text-[#A1A09A] truncate">{{ $card->company }}</p>@endif
                        </div>
                    </div>
                    <ul class="mt-4 space-y-1.5 text-sm">
                        @if($card->email)<li><a href="mailto:{{ $card->email }}" class="text-[#f53003] dark:text-[#FF4433] hover:underline truncate block">{{ $card->email }}</a></li>@endif
                        @if($card->phone)<li><a href="tel:{{ $card->phone }}" class="hover:underline">{{ $card->phone }}</a></li>@endif
                        @if($card->linkedin_url)<li><a href="{{ $card->linkedin_url }}" target="_blank" rel="noopener" class="text-[#f53003] dark:text-[#FF4433] hover:underline">LinkedIn</a></li>@endif
                        @if($card->website_url)<li><a href="{{ $card->website_url }}" target="_blank" rel="noopener" class="text-[#f53003] dark:text-[#FF4433] hover:underline">Site web</a></li>@endif
                    </ul>
                    <div class="mt-4 pt-4 border-t border-[#e3e3e0] dark:border-[#3E3E3A] flex flex-wrap gap-2">
                        <a href="{{ route('card.show', $card->short_code) }}" class="inline-flex items-center px-3 py-2 rounded-xl bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] text-sm font-medium">Voir ma carte</a>
                        <a href="{{ route('card.qr', $card->short_code) }}" target="_blank" rel="noopener" class="inline-flex items-center px-3 py-2 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] text-sm font-medium">QR vCard</a>
                        <a href="{{ route('card.vcard', $card->short_code) }}" class="inline-flex items-center px-3 py-2 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] text-sm font-medium">vCard</a>
                        <button type="button" data-copy="{{ $card->card_url }}" class="copy-link inline-flex items-center px-3 py-2 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] text-sm font-medium">Copier le lien</button>
                    </div>
                </div>
            </section>
            <p class="text-center mb-8">
                <a href="{{ url('/') }}" class="text-sm text-[#f53003] dark:text-[#FF4433] hover:underline">Créer une autre carte</a>
            </p>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-10 lg:gap-12 md:items-center md:max-h-[calc(100dvh-4rem)] md:overflow-hidden">
            {{-- Gauche : texte d’accroche (desktop) --}}
            <div class="mb-6 md:mb-0 md:py-4">
                <p class="text-xs md:text-sm font-medium text-[#f53003] dark:text-[#FF4433] tracking-wide uppercase">Sans carte papier</p>
                <h1 class="mt-1.5 md:mt-2 text-2xl md:text-3xl font-semibold text-[#1b1b18] dark:text-white tracking-tight leading-tight">
                    Votre carte de visite.<br>Un lien. Partout.
                </h1>
                <p class="mt-3 md:mt-2 text-[#706f6c] dark:text-[#A1A09A] text-base md:text-sm leading-snug max-w-md">
                    Créez en deux minutes une carte digitale à partager par lien ou QR code. Idéale pour le réseau, les salons ou simplement remplacer la carte en papier.
                </p>
                <ul class="mt-4 md:mt-3 space-y-2.5" role="list">
                    <li class="flex gap-2.5 items-center">
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1C1C1A] text-[10px] font-bold">1</span>
                        <span class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">Renseignez vos infos une fois</span>
                    </li>
                    <li class="flex gap-2.5 items-center">
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1C1C1A] text-[10px] font-bold">2</span>
                        <span class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">Partagez votre lien ou QR code vCard</span>
                    </li>
                    <li class="flex gap-2.5 items-center">
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1C1C1A] text-[10px] font-bold">3</span>
                        <span class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">Modifiez quand vous voulez avec votre code</span>
                    </li>
                </ul>
            </div>

            {{-- Droite : formulaire --}}
            <section id="formulaire" class="rounded-2xl bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] p-5 sm:p-6 md:max-h-[calc(100dvh-4rem)] md:overflow-y-auto md:overscroll-contain [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-[#e3e3e0] dark:[&::-webkit-scrollbar-thumb]:bg-[#3E3E3A]">
                <h2 class="text-lg font-semibold text-[#1b1b18] dark:text-white mb-0.5">{{ $card ? 'Créer une nouvelle carte' : 'Créer ma carte' }}</h2>
                <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mb-4">Choisissez un design puis remplissez les champs.</p>
                <form action="{{ url('/') }}" method="post" enctype="multipart/form-data" class="space-y-3" id="create-card-form">
                    @csrf
                    <input type="hidden" name="template" id="template-input" value="{{ old('template', 'default') }}">
                    {{-- Choix du design (3 propositions) --}}
                    <div class="mb-1">
                        <p class="text-xs font-medium text-[#1b1b18] dark:text-white mb-2">Choisissez un design</p>
                        <div class="grid grid-cols-3 gap-2" role="group" aria-label="Choix du design">
                            @php $t = old('template', 'default'); @endphp
                            <button type="button" data-template="default" class="design-option rounded-2xl border-2 border-[#e3e3e0] dark:border-[#3E3E3A] p-3 text-left transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-[#f53003] dark:focus-visible:ring-[#FF4433] {{ $t === 'default' ? 'ring-2 ring-[#1b1b18] dark:ring-[#EDEDEC] ring-offset-2 dark:ring-offset-[#161615] opacity-100' : 'opacity-75 hover:opacity-100' }}" aria-pressed="{{ $t === 'default' ? 'true' : 'false' }}">
                                <span class="block h-1.5 rounded-full bg-gradient-to-r from-[#1b1b18] to-[#3d3d3a] dark:from-[#2a2a28] dark:to-[#1a1a18] mb-3"></span>
                                <span class="block w-10 h-10 rounded-full bg-[#e8e8e6] dark:bg-[#2a2a28] mx-auto mb-2"></span>
                                <span class="block text-xs font-medium text-center text-[#1b1b18] dark:text-[#EDEDEC]">Classique</span>
                            </button>
                            <button type="button" data-template="minimal" class="design-option rounded-2xl border-2 border-[#e3e3e0] dark:border-[#3E3E3A] p-3 text-left transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-[#f53003] dark:focus-visible:ring-[#FF4433] {{ $t === 'minimal' ? 'ring-2 ring-[#1b1b18] dark:ring-[#EDEDEC] ring-offset-2 dark:ring-offset-[#161615] opacity-100' : 'opacity-75 hover:opacity-100' }}" aria-pressed="{{ $t === 'minimal' ? 'true' : 'false' }}">
                                <span class="block w-8 h-8 rounded-full bg-[#e8e8e6] dark:bg-[#2a2a28] mx-auto mb-3"></span>
                                <span class="block h-1 w-full max-w-12 mx-auto rounded bg-[#e3e3e0] dark:bg-[#3E3E3A] mb-1"></span>
                                <span class="block h-1 w-full max-w-8 mx-auto rounded bg-[#e3e3e0] dark:bg-[#3E3E3A] mb-3"></span>
                                <span class="block text-xs font-medium text-center text-[#1b1b18] dark:text-[#EDEDEC]">Minimal</span>
                            </button>
                            <button type="button" data-template="classic" class="design-option rounded-2xl border-2 border-[#e3e3e0] dark:border-[#3E3E3A] p-3 text-left transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-[#f53003] dark:focus-visible:ring-[#FF4433] {{ $t === 'classic' ? 'ring-2 ring-[#1b1b18] dark:ring-[#EDEDEC] ring-offset-2 dark:ring-offset-[#161615] opacity-100' : 'opacity-75 hover:opacity-100' }}" aria-pressed="{{ $t === 'classic' ? 'true' : 'false' }}">
                                <div class="flex gap-2 items-center mb-3">
                                    <span class="block w-8 h-8 rounded-full bg-[#e8e8e6] dark:bg-[#2a2a28] shrink-0"></span>
                                    <span class="block h-1.5 flex-1 rounded bg-[#e3e3e0] dark:bg-[#3E3E3A]"></span>
                                </div>
                                <span class="block h-1 w-full rounded bg-[#e3e3e0] dark:bg-[#3E3E3A] mb-1"></span>
                                <span class="block h-1 w-full max-w-3/4 rounded bg-[#e3e3e0] dark:bg-[#3E3E3A]"></span>
                                <span class="block text-xs font-medium text-center text-[#1b1b18] dark:text-[#EDEDEC] mt-2">Compact</span>
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-x-4 gap-y-3">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-xs font-medium mb-0.5">Nom *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required maxlength="255" class="w-full px-3 py-2 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-white text-sm">
                        @error('name')<p class="text-xs text-red-600 dark:text-red-400 mt-0.5">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="title" class="block text-xs font-medium mb-0.5">Titre / Poste</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" maxlength="255" class="w-full px-3 py-2 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-sm">
                        @error('title')<p class="text-xs text-red-600 dark:text-red-400 mt-0.5">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="company" class="block text-xs font-medium mb-0.5">Entreprise</label>
                        <input type="text" name="company" id="company" value="{{ old('company') }}" maxlength="255" class="w-full px-3 py-2 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-sm">
                        @error('company')<p class="text-xs text-red-600 dark:text-red-400 mt-0.5">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-medium mb-0.5">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" maxlength="255" class="w-full px-3 py-2 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-sm">
                        @error('email')<p class="text-xs text-red-600 dark:text-red-400 mt-0.5">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-xs font-medium mb-0.5">Téléphone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" maxlength="50" class="w-full px-3 py-2 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-sm">
                        @error('phone')<p class="text-xs text-red-600 dark:text-red-400 mt-0.5">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="linkedin_url" class="block text-xs font-medium mb-0.5">LinkedIn</label>
                        <input type="url" name="linkedin_url" id="linkedin_url" value="{{ old('linkedin_url') }}" placeholder="https://..." maxlength="500" class="w-full px-3 py-2 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-sm">
                        @error('linkedin_url')<p class="text-xs text-red-600 dark:text-red-400 mt-0.5">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="website_url" class="block text-xs font-medium mb-0.5">Site web</label>
                        <input type="url" name="website_url" id="website_url" value="{{ old('website_url') }}" placeholder="https://..." maxlength="500" class="w-full px-3 py-2 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-sm">
                        @error('website_url')<p class="text-xs text-red-600 dark:text-red-400 mt-0.5">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <span class="block text-sm font-medium mb-1.5 text-[#1b1b18] dark:text-white">Photo / Avatar</span>
                        <label for="avatar" class="flex flex-col items-center justify-center w-full min-h-[100px] rounded-xl border-2 border-dashed border-[#e3e3e0] dark:border-[#3E3E3A] bg-[#fafaf9] dark:bg-[#1c1c1a] hover:border-[#1b1b18] dark:hover:border-[#A1A09A] cursor-pointer transition-colors">
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden">
                            <span class="text-sm text-[#706f6c] dark:text-[#A1A09A] mt-2">Cliquez ou déposez une photo</span>
                            <span class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-0.5">PNG, JPG (max. 2 Mo)</span>
                        </label>
                        @error('avatar')<p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] text-sm font-medium hover:opacity-90 active:opacity-80 transition-opacity">
                            Créer ma carte
                        </button>
                    </div>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <script>
        (function() {
            var input = document.getElementById('template-input');
            if (input) {
                document.querySelectorAll('.design-option').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var t = this.getAttribute('data-template');
                        input.value = t;
                        document.querySelectorAll('.design-option').forEach(function(b) {
                            var sel = b.getAttribute('data-template') === t;
                            b.setAttribute('aria-pressed', sel ? 'true' : 'false');
                            b.classList.toggle('ring-2', sel);
                            b.classList.toggle('ring-[#1b1b18]', sel);
                            b.classList.toggle('dark:ring-[#EDEDEC]', sel);
                            b.classList.toggle('ring-offset-2', sel);
                            b.classList.toggle('dark:ring-offset-[#161615]', sel);
                            b.classList.toggle('opacity-100', sel);
                            b.classList.toggle('opacity-75', !sel);
                        });
                    });
                });
            }

            document.querySelectorAll('.copy-link').forEach(function(btn) {
                var original = btn.textContent;
                btn.addEventListener('click', function() {
                    var value = this.getAttribute('data-copy');
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(value).then(function() {
                            btn.textContent = 'Copié !';
                            setTimeout(function() { btn.textContent = original; }, 2000);
                        });
                    } else {
                        var input = document.createElement('input');
                        input.value = value;
                        document.body.appendChild(input);
                        input.select();
                        document.execCommand('copy');
                        document.body.removeChild(input);
                        btn.textContent = 'Copié !';
                        setTimeout(function() { btn.textContent = original; }, 2000);
                    }
                });
            });

            document.querySelectorAll('.copy-inline').forEach(function(btn) {
                var original = btn.textContent;
                btn.addEventListener('click', function() {
                    var value = this.getAttribute('data-copy');
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(value).then(function() {
                            btn.textContent = 'Copié';
                            setTimeout(function() { btn.textContent = original; }, 2000);
                        });
                    } else {
                        var input = document.createElement('input');
                        input.value = value;
                        document.body.appendChild(input);
                        input.select();
                        document.execCommand('copy');
                        document.body.removeChild(input);
                        btn.textContent = 'Copié';
                        setTimeout(function() { btn.textContent = original; }, 2000);
                    }
                });
            });
        })();
    </script>
@endsection
