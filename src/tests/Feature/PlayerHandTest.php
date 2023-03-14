<?php

namespace Tests\Feature;

use Game\Card\Card;
use Game\Card\Denomination;
use Game\Card\Suit;
use Game\Player\PlayerHand;
use Game\Player\PlayerInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayerHandTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_player_hand(): void
    {
        $cardAce = new Card();
        $cardAce->withDenomination(Denomination::ACE)
            ->withSuit(Suit::Club);

        $playerHand = new PlayerHand();
        $playerHand->add($cardAce);

        $cardAce->withSuit(Suit::Heart);
        $playerHand->add($cardAce);

        $this->assertTrue($playerHand->count() === 2);
    }
}
