<?php

declare(strict_types=1);

namespace Game\Card;

class Card
{
    protected Suit $suit;
    protected Denomination $denomination;

    public function withSuit(Suit $suit): Card
    {
        $this->suit = $suit;

        return $this;
    }

    public function withDenomination(Denomination $denomination): Card
    {
        $this->denomination = $denomination;

        return $this;
    }

    public function getSuit(): Suit
    {
        return $this->suit;
    }

    public function getDenomination(): Denomination
    {
        return $this->denomination;
    }
}
