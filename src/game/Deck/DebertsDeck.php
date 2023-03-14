<?php

declare(strict_types=1);

namespace Game\Deck;

use Game\Card\Card;
use Game\Card\Denomination;

class DebertsDeck extends Deck
{
    protected array $excludedDenominations = [
        Denomination::TWO, Denomination::THREE, Denomination::FOUR,
        Denomination::FIVE, Denomination::SIX, Denomination::JESTER,
    ];

    protected Card $trump;

    public function setTrump(Card $card): void
    {
        $this->trump = $card;
    }
}
