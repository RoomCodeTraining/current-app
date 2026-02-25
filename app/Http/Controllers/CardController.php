<?php

namespace App\Http\Controllers;

use App\Models\DigitalCard;
use Illuminate\View\View;

class CardController extends Controller
{
    /**
     * Page détail carte : affichage soigné de la carte (lien public).
     */
    public function show(string $shortCode): View
    {
        $card = DigitalCard::where('short_code', strtoupper($shortCode))->firstOrFail();

        return view('card.show', [
            'card' => $card,
            'newCardCode' => session('new_card_code'),
            'newCardIdentifier' => session('new_card_identifier'),
        ]);
    }
}
