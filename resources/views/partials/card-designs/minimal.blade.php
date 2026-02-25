{{-- Design 2 : Minimal, épuré, pas de bandeau --}}
<article class="overflow-hidden rounded-3xl bg-white dark:bg-[#161615] border border-[#e8e8e6] dark:border-[#2a2a28]">
    <div class="p-10 sm:p-12">
        <div class="flex flex-col items-center text-center">
            @if($card->avatar_path)
                <img src="{{ Storage::url($card->avatar_path) }}" alt="{{ $card->name }}" class="w-24 h-24 rounded-full object-cover border-2 border-[#e8e8e6] dark:border-[#2a2a28] shrink-0" />
            @else
                <div class="w-24 h-24 rounded-full bg-[#e8e8e6] dark:bg-[#2a2a28] flex items-center justify-center text-3xl font-semibold text-[#706f6c] dark:text-[#A1A09A] border-2 border-[#e8e8e6] dark:border-[#2a2a28] shrink-0">
                    {{ strtoupper(mb_substr($card->name, 0, 1)) }}
                </div>
            @endif
            <h1 class="mt-6 text-2xl font-semibold text-[#1b1b18] dark:text-white tracking-tight">{{ $card->name }}</h1>
            @if($card->title)<p class="mt-1 text-[#706f6c] dark:text-[#A1A09A]">{{ $card->title }}</p>@endif
            @if($card->company)<p class="mt-0.5 text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ $card->company }}</p>@endif
        </div>
        <ul class="mt-8 space-y-2 text-center">
            @if($card->email)<li><a href="mailto:{{ $card->email }}" class="text-[#1b1b18] dark:text-[#EDEDEC] hover:text-[#f53003] dark:hover:text-[#FF4433] text-sm">{{ $card->email }}</a></li>@endif
            @if($card->phone)<li><a href="tel:{{ $card->phone }}" class="text-[#1b1b18] dark:text-[#EDEDEC] hover:text-[#f53003] dark:hover:text-[#FF4433] text-sm">{{ $card->phone }}</a></li>@endif
            @if($card->linkedin_url)<li><a href="{{ $card->linkedin_url }}" target="_blank" rel="noopener" class="text-[#0a66c2] hover:underline text-sm">LinkedIn</a></li>@endif
            @if($card->website_url)<li><a href="{{ $card->website_url }}" target="_blank" rel="noopener" class="text-[#1b1b18] dark:text-[#EDEDEC] hover:text-[#f53003] dark:hover:text-[#FF4433] text-sm">{{ parse_url($card->website_url, PHP_URL_HOST) ?? 'Site web' }}</a></li>@endif
        </ul>
        @if($showActions)
            <div class="mt-8 pt-8 border-t border-[#e8e8e6] dark:border-[#2a2a28] flex flex-wrap justify-center gap-3">
                <a href="{{ route('card.qr', $card->short_code) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1C1C1A] text-sm font-medium hover:opacity-90">QR code</a>
                <a href="{{ route('card.vcard', $card->short_code) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl border-2 border-[#1b1b18] dark:border-[#EDEDEC] text-[#1b1b18] dark:text-[#EDEDEC] text-sm font-medium hover:bg-[#1b1b18] hover:text-white dark:hover:bg-[#EDEDEC] dark:hover:text-[#1C1C1A] transition-colors">Télécharger vCard</a>
                <button type="button" data-copy="{{ $card->card_url }}" class="copy-link inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl border-2 border-[#e3e3e0] dark:border-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC] text-sm font-medium hover:border-[#1b1b18] dark:hover:border-[#EDEDEC] transition-colors">Copier le lien</button>
            </div>
        @endif
    </div>
</article>
