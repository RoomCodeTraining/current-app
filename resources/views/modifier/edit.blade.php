@extends('layouts.app')

@section('title', 'Mon espace')

@section('content')
    <header class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-white tracking-tight">Mon espace</h1>
                <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    Carte <span class="font-mono text-[#1b1b18] dark:text-[#EDEDEC]">{{ $card->short_code }}</span> · {{ $card->name }}
                </p>
                @if(isset($myCards) && $myCards->count() > 1)
                    <p class="mt-2 text-xs text-[#706f6c] dark:text-[#A1A09A]">
                        Changer de carte :
                        @foreach($myCards as $c)
                            @if($c->id === $card->id)
                                <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $c->name }} ({{ $c->short_code }})</span>
                            @else
                                <a href="{{ route('modifier.switch', $c->short_code) }}" class="text-[#f53003] dark:text-[#FF4433] hover:underline">{{ $c->name }} ({{ $c->short_code }})</a>
                            @endif
                            @if(!$loop->last)<span class="text-[#a8a8a6] dark:text-[#6b6b69]"> · </span>@endif
                        @endforeach
                    </p>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1C1C1A] text-sm font-medium hover:opacity-90 transition-opacity">
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

    @if (session('success'))
        <div class="mb-4 p-3 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (!empty($newCardCode) && !empty($newCardIdentifier))
        <div class="mb-4 p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800">
            <p class="text-sm font-medium text-amber-800 dark:text-amber-200">Vos infos pour accéder à cette carte</p>
            <div class="mt-3 space-y-2">
                <div>
                    <p class="text-xs text-amber-700 dark:text-amber-300">Identifiant</p>
                    <div class="mt-0.5 flex items-center gap-2">
                        <p class="text-lg font-mono tracking-wider text-amber-900 dark:text-amber-100">{{ $newCardIdentifier }}</p>
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
                        <p class="text-lg font-mono tracking-wider text-amber-900 dark:text-amber-100">{{ $newCardCode }}</p>
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
        </div>
    @endif

    {{-- Aperçu de la carte (tel qu’elle sera vue par les autres) --}}
    <section class="mb-8" aria-label="Aperçu de ma carte">
        <h2 class="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] mb-3">Aperçu de ma carte</h2>
        @include('partials.card-preview', ['card' => $card, 'showActions' => true])
        <p class="mt-4 text-center">
            <a href="{{ route('card.show', $card->short_code) }}" target="_blank" rel="noopener" class="text-sm font-medium text-[#f53003] dark:text-[#FF4433] hover:underline">
                Voir la carte en grand →
            </a>
        </p>
    </section>

    <form action="{{ route('modifier.update') }}" method="post" enctype="multipart/form-data" class="space-y-4" id="edit-card-form">
        @method('PUT')
        @csrf
        <input type="hidden" name="template" id="edit-template-input" value="{{ old('template', $card->template ?? 'default') }}">
        <div>
            <p class="text-sm font-medium text-[#1b1b18] dark:text-white mb-3">Design de la carte</p>
            <div class="grid grid-cols-3 gap-3 mb-4" role="group" aria-label="Choix du design">
                @php $t = old('template', $card->template ?? 'default'); @endphp
                <button type="button" data-template="default" class="edit-design-option rounded-2xl border-2 border-[#e3e3e0] dark:border-[#3E3E3A] p-3 text-left transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-[#f53003] dark:focus-visible:ring-[#FF4433] {{ $t === 'default' ? 'ring-2 ring-[#1b1b18] dark:ring-[#EDEDEC] ring-offset-2 dark:ring-offset-[#161615] opacity-100' : 'opacity-75 hover:opacity-100' }}" aria-pressed="{{ $t === 'default' ? 'true' : 'false' }}">
                    <span class="block h-1.5 rounded-full bg-gradient-to-r from-[#1b1b18] to-[#3d3d3a] dark:from-[#2a2a28] dark:to-[#1a1a18] mb-3"></span>
                    <span class="block w-10 h-10 rounded-full bg-[#e8e8e6] dark:bg-[#2a2a28] mx-auto mb-2"></span>
                    <span class="block text-xs font-medium text-center text-[#1b1b18] dark:text-[#EDEDEC]">Classique</span>
                </button>
                <button type="button" data-template="minimal" class="edit-design-option rounded-2xl border-2 border-[#e3e3e0] dark:border-[#3E3E3A] p-3 text-left transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-[#f53003] dark:focus-visible:ring-[#FF4433] {{ $t === 'minimal' ? 'ring-2 ring-[#1b1b18] dark:ring-[#EDEDEC] ring-offset-2 dark:ring-offset-[#161615] opacity-100' : 'opacity-75 hover:opacity-100' }}" aria-pressed="{{ $t === 'minimal' ? 'true' : 'false' }}">
                    <span class="block w-8 h-8 rounded-full bg-[#e8e8e6] dark:bg-[#2a2a28] mx-auto mb-3"></span>
                    <span class="block h-1 w-full max-w-12 mx-auto rounded bg-[#e3e3e0] dark:bg-[#3E3E3A] mb-1"></span>
                    <span class="block h-1 w-full max-w-8 mx-auto rounded bg-[#e3e3e0] dark:bg-[#3E3E3A] mb-3"></span>
                    <span class="block text-xs font-medium text-center text-[#1b1b18] dark:text-[#EDEDEC]">Minimal</span>
                </button>
                <button type="button" data-template="classic" class="edit-design-option rounded-2xl border-2 border-[#e3e3e0] dark:border-[#3E3E3A] p-3 text-left transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-[#f53003] dark:focus-visible:ring-[#FF4433] {{ $t === 'classic' ? 'ring-2 ring-[#1b1b18] dark:ring-[#EDEDEC] ring-offset-2 dark:ring-offset-[#161615] opacity-100' : 'opacity-75 hover:opacity-100' }}" aria-pressed="{{ $t === 'classic' ? 'true' : 'false' }}">
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
        <div>
            <label for="name" class="block text-sm font-medium mb-1">Nom *</label>
            <input type="text" name="name" id="name" value="{{ old('name', $card->name) }}" required maxlength="255" class="w-full px-4 py-3 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615]">
            @error('name')<p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="title" class="block text-sm font-medium mb-1">Titre / Poste</label>
            <input type="text" name="title" id="title" value="{{ old('title', $card->title) }}" maxlength="255" class="w-full px-4 py-3 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615]">
            @error('title')<p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="company" class="block text-sm font-medium mb-1">Entreprise</label>
            <input type="text" name="company" id="company" value="{{ old('company', $card->company) }}" maxlength="255" class="w-full px-4 py-3 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615]">
            @error('company')<p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="email" class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $card->email) }}" maxlength="255" class="w-full px-4 py-3 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615]">
            @error('email')<p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="phone" class="block text-sm font-medium mb-1">Téléphone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $card->phone) }}" maxlength="50" class="w-full px-4 py-3 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615]">
            @error('phone')<p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="linkedin_url" class="block text-sm font-medium mb-1">LinkedIn</label>
            <input type="url" name="linkedin_url" id="linkedin_url" value="{{ old('linkedin_url', $card->linkedin_url) }}" placeholder="https://..." maxlength="500" class="w-full px-4 py-3 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615]">
            @error('linkedin_url')<p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="website_url" class="block text-sm font-medium mb-1">Site web</label>
            <input type="url" name="website_url" id="website_url" value="{{ old('website_url', $card->website_url) }}" placeholder="https://..." maxlength="500" class="w-full px-4 py-3 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615]">
            @error('website_url')<p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <span class="block text-sm font-medium mb-1.5 text-[#1b1b18] dark:text-white">Photo / Avatar</span>
            @if($card->avatar_path)
                <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mb-2">Photo actuelle : <img src="{{ Storage::url($card->avatar_path) }}" alt="" class="inline w-8 h-8 rounded-full object-cover align-middle"></p>
            @endif
            <label for="avatar" class="flex flex-col items-center justify-center w-full min-h-[100px] rounded-xl border-2 border-dashed border-[#e3e3e0] dark:border-[#3E3E3A] bg-[#fafaf9] dark:bg-[#1c1c1a] hover:border-[#1b1b18] dark:hover:border-[#A1A09A] cursor-pointer transition-colors">
                <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden">
                <span class="text-sm text-[#706f6c] dark:text-[#A1A09A] mt-2">Cliquez ou déposez une photo</span>
                <span class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-0.5">PNG, JPG (max. 2 Mo)</span>
            </label>
            @error('avatar')<p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="w-full py-3 rounded-xl bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] font-medium hover:opacity-90 active:opacity-80 transition-opacity">
            Enregistrer
        </button>
    </form>

    <script>
        (function() {
            var input = document.getElementById('edit-template-input');
            if (input) {
                document.querySelectorAll('.edit-design-option').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var t = this.getAttribute('data-template');
                        input.value = t;
                        document.querySelectorAll('.edit-design-option').forEach(function(b) {
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
                            btn.textContent = 'Lien copié ✓';
                            setTimeout(function() { btn.textContent = original; }, 2000);
                        });
                    } else {
                        var input = document.createElement('input');
                        input.value = value;
                        document.body.appendChild(input);
                        input.select();
                        document.execCommand('copy');
                        document.body.removeChild(input);
                        btn.textContent = 'Lien copié ✓';
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
