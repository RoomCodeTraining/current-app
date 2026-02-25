<?php

namespace App\Http\Controllers;

use App\Models\DigitalCard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModifierController extends Controller
{
    /**
     * Affiche soit le formulaire identifiant + code, soit le formulaire d'édition si déjà connecté.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $card = $this->getEditingCard($request);

        if ($card) {
            $myCards = $this->getMyCards($request);

            return view('modifier.edit', [
                'card' => $card,
                'myCards' => $myCards,
                'newCardCode' => $request->session()->get('new_card_code'),
                'newCardIdentifier' => $request->session()->get('new_card_identifier'),
            ]);
        }

        return view('modifier.login');
    }

    /**
     * Bascule vers une autre carte déjà ouverte dans cette session.
     */
    public function switchCard(Request $request, string $shortCode): RedirectResponse
    {
        $shortCode = strtoupper(trim($shortCode));
        $ids = $request->session()->get('editing_card_ids', []);

        $card = DigitalCard::where('short_code', $shortCode)->whereIn('id', $ids)->first();

        if (!$card) {
            return redirect()->route('modifier.index')->withErrors(['session' => 'Carte non accessible. Connectez-vous avec son identifiant et code.']);
        }

        $request->session()->put('editing_card_id', $card->id);

        return redirect()->route('modifier.index');
    }

    /**
     * Vérifie identifiant (short_code) + code et met la carte en session.
     */
    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'identifier' => 'required|string|max:20',
            'code' => 'required|string|max:20',
        ]);

        $identifier = strtoupper(trim(preg_replace('/\s+/', '', $validated['identifier'])));

        $card = DigitalCard::where('short_code', $identifier)
            ->where('edit_code', $validated['code'])
            ->first();

        if (!$card) {
            return back()->withErrors(['code' => 'Identifiant ou code incorrect.'])->withInput(['identifier' => $validated['identifier']]);
        }

        $ids = $request->session()->get('editing_card_ids', []);
        if (!in_array($card->id, $ids)) {
            $ids[] = $card->id;
            $request->session()->put('editing_card_ids', $ids);
        }
        $request->session()->put('editing_card_id', $card->id);

        return redirect()->route('modifier.index');
    }

    /**
     * Déconnexion (quitter l'édition de toutes les cartes).
     */
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(['editing_card_id', 'editing_card_ids']);
        return redirect()->route('modifier.index');
    }

    /**
     * Met à jour la carte.
     */
    public function update(Request $request): RedirectResponse
    {
        $card = $this->getEditingCard($request);

        if (!$card) {
            return redirect()->route('modifier.index')->withErrors(['session' => 'Session expirée. Identifiez-vous à nouveau.']);
        }

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

        if ($request->hasFile('avatar')) {
            $card->avatar_path = $request->file('avatar')->store('avatars', 'public');
        }

        $card->fill([
            'name' => $validated['name'],
            'title' => $validated['title'] ?? null,
            'company' => $validated['company'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'linkedin_url' => $validated['linkedin_url'] ?? null,
            'website_url' => $validated['website_url'] ?? null,
            'template' => $validated['template'] ?? $card->template,
        ])->save();

        return redirect()->route('modifier.index')->with('success', 'Carte mise à jour.');
    }

    private function getEditingCard(Request $request): ?DigitalCard
    {
        $id = $request->session()->get('editing_card_id');
        if (!$id) {
            return null;
        }
        return DigitalCard::find($id);
    }

    /** @return \Illuminate\Database\Eloquent\Collection<int, DigitalCard> */
    private function getMyCards(Request $request)
    {
        $ids = $request->session()->get('editing_card_ids', []);
        if (empty($ids)) {
            $current = $request->session()->get('editing_card_id');
            if ($current) {
                $ids = [$current];
            }
        }
        return DigitalCard::whereIn('id', $ids)->orderBy('name')->get();
    }
}
