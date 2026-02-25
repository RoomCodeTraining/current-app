@extends('layouts.app')

@section('title', $card->name . ' – Carte de visite')

@section('content')
    @if($newCardCode && $newCardIdentifier)
        <div class="mb-6 p-4 rounded-2xl bg-amber-50 dark:bg-amber-900/25 border border-amber-200/80 dark:border-amber-700/50">
            <p class="text-sm font-medium text-amber-800 dark:text-amber-200">Gardez ces infos pour modifier votre carte plus tard</p>
            <div class="mt-3 flex flex-wrap gap-4">
                <div>
                    <p class="text-xs text-amber-600 dark:text-amber-400">Identifiant</p>
                    <div class="mt-0.5 flex items-center gap-2">
                        <p class="text-lg font-mono font-semibold tracking-wider text-amber-900 dark:text-amber-100">{{ $newCardIdentifier }}</p>
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
                    <p class="text-xs text-amber-600 dark:text-amber-400">Code</p>
                    <div class="mt-0.5 flex items-center gap-2">
                        <p class="text-lg font-mono font-semibold tracking-wider text-amber-900 dark:text-amber-100">{{ $newCardCode }}</p>
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

    @include('partials.card-preview', ['card' => $card])

    <p class="mt-6 text-center">
        <a href="{{ route('home') }}" class="text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-white">Créer ma propre carte</a>
    </p>

    <script>
        (function() {
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
