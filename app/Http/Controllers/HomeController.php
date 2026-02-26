<?php

namespace App\Http\Controllers;

use App\Models\DigitalCard;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * Accueil : formulaire de création + affichage carte si ?card=short_code. Le focus sur une carte reste sur Modifier (Mon espace).
     */
    public function index(Request $request): View
    {
        $card = null;
        if ($code = $request->query('card')) {
            $code = strtoupper(trim($code));
            $card = DigitalCard::where('short_code', $code)->orWhere('slug', $code)->first();
        }

        $myCards = collect();
        $ids = $request->session()->get('editing_card_ids', []);
        if (empty($ids) && $request->session()->has('editing_card_id')) {
            $ids = [$request->session()->get('editing_card_id')];
        }
        if (!empty($ids)) {
            $myCards = DigitalCard::whereIn('id', $ids)->orderBy('name')->get();
        }

        return view('home', [
            'card' => $card,
            'myCards' => $myCards,
            'newCardCode' => $request->session()->get('new_card_code'),
            'newCardIdentifier' => $request->session()->get('new_card_identifier'),
        ]);
    }

    /**
     * Tableau de bord : vue centrée sur les cartes de l'utilisateur connecté (session).
     */
    public function dashboard(Request $request): View
    {
        $card = null;
        if ($code = $request->query('card')) {
            $code = strtoupper(trim($code));
            $card = DigitalCard::where('short_code', $code)->orWhere('slug', $code)->first();
        }

        $myCards = collect();
        $ids = $request->session()->get('editing_card_ids', []);
        if (empty($ids) && $request->session()->has('editing_card_id')) {
            $ids = [$request->session()->get('editing_card_id')];
        }
        if (!empty($ids)) {
            $myCards = DigitalCard::whereIn('id', $ids)->orderBy('name')->get();
        }

        return view('dashboard', [
            'card' => $card,
            'myCards' => $myCards,
        ]);
    }

    /**
     * Création d'une carte (POST depuis l'accueil)
     */
    public function store(Request $request): Response
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'linkedin_url' => 'nullable|url|max:500',
            'website_url' => 'nullable|url|max:500',
            'avatar' => 'nullable|image|max:2048',
            'template' => 'nullable|string|in:default,minimal,classic',
        ]);

        $slug = Str::slug($validated['name']) . '-' . Str::lower(Str::random(6));
        while (DigitalCard::where('slug', $slug)->exists()) {
            $slug = Str::slug($validated['name']) . '-' . Str::lower(Str::random(6));
        }

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $editCode = (string) random_int(100000, 999999);

        $card = DigitalCard::create([
            'slug' => $slug,
            'name' => $validated['name'],
            'title' => $validated['title'] ?? null,
            'company' => $validated['company'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'linkedin_url' => $validated['linkedin_url'] ?? null,
            'website_url' => $validated['website_url'] ?? null,
            'avatar_path' => $avatarPath,
            'edit_code' => $editCode,
            'template' => $validated['template'] ?? 'default',
        ]);

        // Mettre directement l'utilisateur dans son « espace » (édition de la carte)
        $ids = $request->session()->get('editing_card_ids', []);
        if (!in_array($card->id, $ids)) {
            $ids[] = $card->id;
            $request->session()->put('editing_card_ids', $ids);
        }
        $request->session()->put('editing_card_id', $card->id);

        return redirect()->route('modifier.index')
            ->with('new_card_code', $editCode)
            ->with('new_card_identifier', $card->short_code);
    }

    /**
     * QR code vCard (image) pour partage
     */
    public function qr(string $shortCode): Response
    {
        $card = DigitalCard::where('short_code', strtoupper($shortCode))->firstOrFail();
        $vCardUrl = url('/card/' . $card->short_code . '/vcard');

        $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . rawurlencode($vCardUrl);
        return redirect()->away($qrApiUrl);
    }

    /**
     * Téléchargement vCard (.vcf)
     */
    public function vcard(string $shortCode): Response
    {
        $card = DigitalCard::where('short_code', strtoupper($shortCode))->firstOrFail();

        $vcard = "BEGIN:VCARD\n";
        $vcard .= "VERSION:3.0\n";
        $vcard .= "FN:" . $this->vcardEscape($card->name) . "\n";
        $vcard .= "N:" . $this->vcardEscape($card->name) . ";;;\n";
        if ($card->title) {
            $vcard .= "TITLE:" . $this->vcardEscape($card->title) . "\n";
        }
        if ($card->company) {
            $vcard .= "ORG:" . $this->vcardEscape($card->company) . "\n";
        }
        if ($card->email) {
            $vcard .= "EMAIL:" . $this->vcardEscape($card->email) . "\n";
        }
        if ($card->phone) {
            $vcard .= "TEL:" . $this->vcardEscape($card->phone) . "\n";
        }
        if ($card->website_url) {
            $vcard .= "URL:" . $this->vcardEscape($card->website_url) . "\n";
        }
        $vcard .= "END:VCARD";

        return response($vcard, 200, [
            'Content-Type' => 'text/vcard; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $card->short_code . '.vcf"',
        ]);
    }

    private function vcardEscape(string $value): string
    {
        return str_replace(["\r", "\n", ',', ';', '\\'], ['', ' ', '\\,', '\\;', '\\\\'], $value);
    }
}
