<?php

namespace App\Console\Commands;

use Game\Deck\DebertsDeck;
use Game\Player\Player;
use Game\Player\PlayerInfo;
use Game\Player\PlayersCollection;
use Illuminate\Console\Command;

class Play extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'play';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $players = new PlayersCollection();

        // add first player
        $playerInfo = new PlayerInfo();
        $playerInfo->withName('Rustam');
        $player = new Player();
        $player->withInfo($playerInfo);
        $players->add($player);

        // add second player
        $playerInfo = new PlayerInfo();
        $playerInfo->withName('Andrey');
        $player = new Player();
        $player->withInfo($playerInfo);
        $players->add($player);

        // init game deck
        $deberts = new DebertsDeck();
        $deberts->fill();
        $deberts->setPlayers($players);
        $deberts->deal();

        // get all cards
//        foreach ($deberts->getCards() as $card) {
//            dump($card);
//        }

        foreach ($deberts->getPlayers() as $player) {
            dump($player->getHand());

            $card = $player->getHand()->first();
            $deberts->takeFrom($player, $card);

            dd($player->getHand());
        }
    }
}
