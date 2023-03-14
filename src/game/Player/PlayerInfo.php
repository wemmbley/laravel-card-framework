<?php

declare(strict_types=1);

namespace Game\Player;

class PlayerInfo
{
    protected string $name;
    protected string $avatar;
    protected int $rank;
    protected int $cardsSkin;
    protected int $deckSkin;

    public function withName(string $name): PlayerInfo
    {
        $this->name = $name;

        return $this;
    }

    public function withAvatar(string $avatarUrl): PlayerInfo
    {
        $this->avatar = $avatarUrl;

        return $this;
    }

    public function withCardsSkin(int $skinId): PlayerInfo
    {
        $this->cardsSkin = $skinId;

        return $this;
    }

    public function withDeckSkin(int $skinId): PlayerInfo
    {
        $this->deckSkin = $skinId;

        return $this;
    }

    public function withRank(int $rankNumber): PlayerInfo
    {
        $this->rank = $rankNumber;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function getRank(): int
    {
        return $this->rank;
    }

    public function getCardsSkin(): int
    {
        return $this->cardsSkin;
    }

    public function getDeckSkin(): int
    {
        return $this->deckSkin;
    }
}
