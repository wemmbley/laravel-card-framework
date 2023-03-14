<?php

declare(strict_types=1);

namespace Game\Player;

use Game\Card\Card;

class Player
{
    protected PlayerHand $hand;
    protected PlayerInfo $info;

    public function __construct()
    {
        $this->hand = new PlayerHand();
        $this->info = new PlayerInfo();
    }

    public function withInfo(PlayerInfo $playerInfo): Player
    {
        $this->info = $playerInfo;

        return $this;
    }

    public function withHand(PlayerHand $hand): Player
    {
        $this->hand = $hand;

        return $this;
    }

    public function addCard(Card $card): Player
    {
        $this->hand->add($card);

        return $this;
    }

    public function removeCard(Card $card): Player
    {
        $this->hand = $this->hand->filter(function ($collectionCard) use ($card) {
            if ($collectionCard->getSuit() === $card->getSuit() &&
                $collectionCard->getDenomination() === $card->getDenomination() ) {
                return false;
            }

            return true;
        });

        return $this;
    }

    public function getHand(): PlayerHand
    {
        return $this->hand;
    }

    public function getInfo(): PlayerInfo
    {
        return $this->info;
    }
}
