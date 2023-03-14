<?php

namespace Tests\Feature;

use Game\Player\PlayerInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    /**
     * Test PlayerInfo
     */
    public function test_player(): void
    {
        $playerInfo = new PlayerInfo();
        $playerInfo->withName('Rustam')
            ->withRank(100)
            ->withAvatar('avatar_url')
            ->withCardsSkin(1)
            ->withDeckSkin(2);

        $player = new \Game\Player\Player();
        $player->withInfo($playerInfo);

        $playerInfo = $player->getInfo();

        $this->assertEquals('Rustam', $playerInfo->getName());
        $this->assertEquals(100, $playerInfo->getRank());
        $this->assertEquals('avatar_url', $playerInfo->getAvatar());
        $this->assertEquals(1, $playerInfo->getCardsSkin());
        $this->assertEquals(2, $playerInfo->getDeckSkin());

        $playerInfo->withName('Artur');

        $this->assertNotEquals('Rustam', $playerInfo->getName());
    }
}
