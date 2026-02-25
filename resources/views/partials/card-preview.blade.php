{{-- Aperçu / rendu public de la carte (design selon template) --}}
@php
    $showActions = $showActions ?? true;
    $template = $card->template ?? 'default';
    if (!in_array($template, ['default', 'minimal', 'classic'], true)) {
        $template = 'default';
    }
@endphp
@include('partials.card-designs.' . $template, ['card' => $card, 'showActions' => $showActions])
