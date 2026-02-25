{{-- Design 3 : Classique, avatar à gauche --}}
<article class="overflow-hidden rounded-3xl bg-white dark:bg-[#161615] border border-[#e8e8e6] dark:border-[#2a2a28]">
    <div class="p-6 sm:p-8 flex flex-col sm:flex-row gap-6 sm:gap-8 items-center sm:items-start">
        @if($card->avatar_path)
            <img src="{{ Storage::url($card->avatar_path) }}" alt="{{ $card->name }}" class="w-24 h-24 rounded-full object-cover border-2 border-[#e8e8e6] dark:border-[#2a2a28] shrink-0" />
        @else
            <div class="w-24 h-24 rounded-full bg-[#e8e8e6] dark:bg-[#2a2a28] flex items-center justify-center text-3xl font-semibold text-[#706f6c] dark:text-[#A1A09A] border-2 border-[#e8e8e6] dark:border-[#2a2a28] shrink-0">
                {{ strtoupper(mb_substr($card->name, 0, 1)) }}
            </div>
        @endif
        <div class="flex-1 min-w-0 text-center sm:text-left">
            <h1 class="text-xl font-semibold text-[#1b1b18] dark:text-white">{{ $card->name }}</h1>
            @if($card->title)<p class="mt-0.5 text-[#706f6c] dark:text-[#A1A09A] text-sm">{{ $card->title }}</p>@endif
            @if($card->company)<p class="text-[#706f6c] dark:text-[#A1A09A] text-sm">{{ $card->company }}</p>@endif
            <ul class="mt-4 space-y-1.5 text-sm">
                @if($card->email)<li><a href="mailto:{{ $card->email }}" class="text-[#f53003] dark:text-[#FF4433] hover:underline">{{ $card->email }}</a></li>@endif
                @if($card->phone)<li><a href="tel:{{ $card->phone }}" class="text-[#1b1b18] dark:text-[#EDEDEC] hover:underline">{{ $card->phone }}</a></li>@endif
                @if($card->linkedin_url)<li><a href="{{ $card->linkedin_url }}" target="_blank" rel="noopener" class="text-[#0a66c2] hover:underline">LinkedIn</a></li>@endif
                @if($card->website_url)<li><a href="{{ $card->website_url }}" target="_blank" rel="noopener" class="text-[#f53003] dark:text-[#FF4433] hover:underline">Site web</a></li>@endif
            </ul>
            @if($showActions)
                <div class="mt-4 flex flex-wrap gap-2">
                    <a href="{{ route('card.qr', $card->short_code) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1C1C1A] text-xs font-medium">QR</a>
                    <a href="{{ route('card.vcard', $card->short_code) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] text-xs font-medium hover:bg-[#1b1b18] hover:text-white dark:hover:bg-[#EDEDEC] dark:hover:text-[#1C1C1A]">vCard</a>
                    <button type="button" data-copy="{{ $card->card_url }}" class="copy-link inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] text-xs font-medium">Copier</button>
                </div>
            @endif
        </div>
    </div>
</article>
