<?php

namespace Tests\Feature;

use Game\Card\Card;
use Game\Card\Denomination;
use Game\Card\Suit;
use Game\Deck\DebertsDeck;
use Game\Deck\DeckException;
use Game\Player\Player;
use Game\Player\PlayerHand;
use Game\Player\PlayerInfo;
use Game\Player\PlayersCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeckTest extends TestCase
{
    private DebertsDeck $deberts;

    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->deberts = new DebertsDeck();
        $this->deberts
            ->fill() // test fill
            ->setPlayers($this->getPlayersCollection()) // test players
            ->deal(); // test deal
    }

    public function test_player_types()
    {
        $player = $this->deberts->getPlayers()->first();

        $this->assertInstanceOf(Player::class, $player);
        $this->assertInstanceOf(PlayerHand::class, $player->getHand());
        $this->assertTrue($player->getHand()->count() > 0);
        $this->assertInstanceOf(Card::class, $player->getHand()->first());
        $this->assertInstanceOf(Suit::class, $player->getHand()->first()->getSuit());
        $this->assertInstanceOf(Denomination::class, $player->getHand()->first()->getDenomination());
    }

    public function test_deck_types(): void
    {
        $this->assertTrue(gettype($this->deberts->getCards()) === 'object');

        foreach ($this->deberts->getCards() as $card) {
            $this->assertTrue(gettype($card->getSuit()->name) === 'string');
            $this->assertTrue(gettype($card->getDenomination()->name) === 'string');
            $this->assertTrue(gettype($card->getDenomination()->value) === 'string');
        }
    }

    public function test_player_take_bad_card_exception()
    {
        $player = $this->deberts->getPlayers()->first();

        $this->expectException(DeckException::class);
        $this->expectExceptionMessage('takeFrom(): Card not found in player hand.');

        $this->deberts->takeFrom($player, $this->getCardOutOfHand($player));
    }

    public function test_player_null_exception()
    {
        $playerInfo = new PlayerInfo();
        $playerInfo->withName('Anatoliy');
        $player = new Player();
        $player->withInfo($playerInfo);

        $card = $this->deberts->getPlayers()->first()->getHand()->first();

        $this->expectException(DeckException::class);
        $this->expectExceptionMessage('takeFrom(): Player not found, null returned.');

        $this->deberts->takeFrom($player, $card);
    }

    public function test_deck_players_take(): void
    {
//        foreach ($this->deberts->getPlayers() as $player) {
//            $this->assertTrue($player->getHand()->count() === 6);
//
//            $card = $player->getHand()->first();
//            $this->deberts->takeFrom($player, $card); // test exception
//
//            $this->assertTrue($player->getHand()->count() === 5);
//        }
    }

    /**
     * Create players collection.
     *
     * @return PlayersCollection
     */
    private function getPlayersCollection(): PlayersCollection
    {
        $players = new PlayersCollection();

        $this->createPlayer($players, 'Andrey');
        $this->createPlayer($players, 'Rustam');
        $this->createPlayer($players, 'Yaroslav');
        $this->createPlayer($players, 'Evgen');

        return $players;
    }

    private function createPlayer(PlayersCollection $playersCollection, string $playerName)
    {
        $playerInfo = new PlayerInfo();
        $playerInfo->withName($playerName);
        $player = new Player();
        $player->withInfo($playerInfo);
        $playersCollection->add($player);
    }

    /**
     * Create new card with another denomination which is out of bound players hand.
     *
     * @param Player $player
     * @return Card
     */
    private function getCardOutOfHand(Player $player)
    {
        $handCards = $player->getHand();
        $denominations = [];
        $notFoundDenomination = Denomination::JESTER;

        foreach ($handCards as $card) {
            $denominations[] = $card->getDenomination()->value;
        }

        foreach (Denomination::cases() as $denomination) {
            if (in_array($denomination->value, $denominations)) {
                $notFoundDenomination = $denomination;
                break;
            }
        }

        $card = new Card();

        return $card
            ->withSuit(Suit::Heart)
            ->withDenomination($notFoundDenomination);
    }
}
