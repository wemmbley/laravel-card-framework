<?php

declare(strict_types=1);

namespace Game\Deck;

use Game\Card\Card;
use Game\Card\CardsCollection;
use Game\Card\Denomination;
use Game\Card\Suit;
use Game\Player\Player;
use Game\Player\PlayerHand;
use Game\Player\PlayersCollection;

abstract class Deck
{
    protected CardsCollection $cards;
    protected PlayersCollection $players;

    /**
     * An array for specifying unnecessary cards in a particular deck.
     *
     * @var array
     */
    protected array $excludedDenominations;

    /**
     * Default constant that is used when dealing cards.
     */
    protected const PLAYER_HAND_CARDS = 6;

    /**
     * Set players into collection.
     *
     * @param PlayersCollection $players
     * @return $this
     */
    public function setPlayers(PlayersCollection $players): Deck
    {
        $this->players = $players;

        return $this;
    }

    public function getCards(): CardsCollection
    {
        return $this->cards;
    }

    public function getPlayers(): PlayersCollection
    {
        return $this->players;
    }

    /**
     * Fills a collection with cards using the prescribed suits and denominations,
     * excluding unnecessary cards using a predefined array $excludedDenominations.
     *
     * @return $this
     */
    public function fill(): Deck
    {
        $cardsCollection = new CardsCollection();

        foreach (Denomination::cases() as $denomination) {
            foreach ($this->excludedDenominations as $excludedDenomination) {
                if ($denomination === $excludedDenomination)
                    continue 2;
            }

            foreach (Suit::cases() as $suit) {
                $card = new Card();
                $card->withSuit($suit);
                $card->withDenomination($denomination);
                $cardsCollection->add($card);
            }
        }

        $this->cards = $cardsCollection;

        return $this;
    }

    /**
     * Deal cards to all players in the collection $players
     * and remove these cards from main deck.
     *
     * @return $this
     */
    public function deal(): Deck
    {
        foreach ($this->players as $player) {
            $playerHand = new PlayerHand();

            for ($i = 0; $i < self::PLAYER_HAND_CARDS; $i++) {
                $card = $this->take();
                $playerHand->add($card);
            }

            $player->withHand($playerHand);
        }

        return $this;
    }

    /**
     * Takes cards from a deck to give to a specific player.
     *
     * @param Player $player
     * @param int $cardsCount
     * @return Deck
     */
    public function dealTo(Player $player, int $cardsCount): Deck
    {
        $player = $this->getPlayer($player);

        for ($i = 0; $i < $cardsCount; $i++) {
            $card = $this->take();
            $player->addCard($card);
        }

        return $this;
    }

    /**
     * Take card from a specific player.
     *
     * @param Player $player
     * @param Card $card
     * @return $this
     * @throws \Exception
     */
    public function takeFrom(Player $player, Card $card): Deck
    {
        $player = $this->getPlayer($player);

        $playerCardsCount = $player->getHand()->count();

        if (is_null($player))
            throw new DeckException('takeFrom(): Player not found, null returned.');

        $player->removeCard($card);

        if ($player->getHand()->count() === $playerCardsCount)
            throw new DeckException('takeFrom(): Card not found in player hand.');

        return $this;
    }

    /**
     * Remove card from a deck and return it.
     *
     * @param int $cardsCount
     * @return Card
     */
    protected function take(int $cardsCount = 1): Card
    {
        $card = $this->cards->random($cardsCount);
        $this->cards->reject(fn ($item) => $item === $card);

        return $card->get(0);
    }

    /**
     * Get Game\Player\Player from collection $players.
     *
     * @param Player $player
     * @return Player|null
     */
    protected function getPlayer(Player $player): ?Player
    {
        return $this->players->map(function($collectionPlayer) use ($player) {
            if ($collectionPlayer->getInfo()->getName() === $player->getInfo()->getName())
                return $collectionPlayer;

            return null;
        })->first();
    }
}
