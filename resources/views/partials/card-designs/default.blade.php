{{-- Design 1 : Centré, bandeau --}}
<article class="overflow-hidden rounded-3xl bg-white dark:bg-[#161615] border border-[#e8e8e6] dark:border-[#2a2a28]">
    <div class="h-1.5 bg-gradient-to-r from-[#1b1b18] to-[#3d3d3a] dark:from-[#2a2a28] dark:to-[#1a1a18]"></div>
    <div class="p-8 sm:p-10">
        <div class="flex flex-col items-center text-center">
            @if($card->avatar_path)
                <img src="{{ Storage::url($card->avatar_path) }}" alt="{{ $card->name }}" class="w-28 h-28 rounded-full object-cover ring-4 ring-[#f0f0ee] dark:ring-[#2a2a28] shrink-0" />
            @else
                <div class="w-28 h-28 rounded-full bg-gradient-to-br from-[#e8e8e6] to-[#d0d0ce] dark:from-[#3E3E3A] dark:to-[#2a2a28] flex items-center justify-center text-4xl font-semibold text-[#706f6c] dark:text-[#A1A09A] ring-4 ring-[#f0f0ee] dark:ring-[#2a2a28] shrink-0">
                    {{ strtoupper(mb_substr($card->name, 0, 1)) }}
                </div>
            @endif
            <h1 class="mt-6 text-2xl font-semibold text-[#1b1b18] dark:text-white tracking-tight">{{ $card->name }}</h1>
            @if($card->title)<p class="mt-1 text-[#706f6c] dark:text-[#A1A09A] font-medium">{{ $card->title }}</p>@endif
            @if($card->company)<p class="mt-0.5 text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ $card->company }}</p>@endif
        </div>
        <div class="mt-8 space-y-3">
            @if($card->email)<a href="mailto:{{ $card->email }}" class="flex items-center justify-center gap-3 w-full py-3.5 px-4 rounded-2xl bg-[#f5f5f4] dark:bg-[#252523] hover:bg-[#ebebea] dark:hover:bg-[#2e2e2c] transition-colors text-[#1b1b18] dark:text-[#EDEDEC]"><svg class="w-5 h-5 text-[#706f6c] dark:text-[#A1A09A] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg><span class="text-sm font-medium truncate">{{ $card->email }}</span></a>@endif
            @if($card->phone)<a href="tel:{{ $card->phone }}" class="flex items-center justify-center gap-3 w-full py-3.5 px-4 rounded-2xl bg-[#f5f5f4] dark:bg-[#252523] hover:bg-[#ebebea] dark:hover:bg-[#2e2e2c] transition-colors text-[#1b1b18] dark:text-[#EDEDEC]"><svg class="w-5 h-5 text-[#706f6c] dark:text-[#A1A09A] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg><span class="text-sm font-medium">{{ $card->phone }}</span></a>@endif
            @if($card->linkedin_url)<a href="{{ $card->linkedin_url }}" target="_blank" rel="noopener" class="flex items-center justify-center gap-3 w-full py-3.5 px-4 rounded-2xl bg-[#f5f5f4] dark:bg-[#252523] hover:bg-[#ebebea] dark:hover:bg-[#2e2e2c] transition-colors text-[#1b1b18] dark:text-[#EDEDEC]"><svg class="w-5 h-5 text-[#0a66c2] shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg><span class="text-sm font-medium">LinkedIn</span></a>@endif
            @if($card->website_url)<a href="{{ $card->website_url }}" target="_blank" rel="noopener" class="flex items-center justify-center gap-3 w-full py-3.5 px-4 rounded-2xl bg-[#f5f5f4] dark:bg-[#252523] hover:bg-[#ebebea] dark:hover:bg-[#2e2e2c] transition-colors text-[#1b1b18] dark:text-[#EDEDEC]"><svg class="w-5 h-5 text-[#706f6c] dark:text-[#A1A09A] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg><span class="text-sm font-medium truncate">{{ parse_url($card->website_url, PHP_URL_HOST) ?? 'Site web' }}</span></a>@endif
        </div>
        @if($showActions)
            <div class="mt-8 pt-6 border-t border-[#e8e8e6] dark:border-[#2a2a28] flex flex-wrap justify-center gap-3">
                <a href="{{ route('card.qr', $card->short_code) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1C1C1A] text-sm font-medium hover:opacity-90">QR code</a>
                <a href="{{ route('card.vcard', $card->short_code) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl border-2 border-[#1b1b18] dark:border-[#EDEDEC] text-[#1b1b18] dark:text-[#EDEDEC] text-sm font-medium hover:bg-[#1b1b18] hover:text-white dark:hover:bg-[#EDEDEC] dark:hover:text-[#1C1C1A] transition-colors">Télécharger vCard</a>
                <button type="button" data-copy="{{ $card->card_url }}" class="copy-link inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl border-2 border-[#e3e3e0] dark:border-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC] text-sm font-medium hover:border-[#1b1b18] dark:hover:border-[#EDEDEC] transition-colors">Copier le lien</button>
            </div>
        @endif
    </div>
</article>
