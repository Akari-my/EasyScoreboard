<?php

namespace Akari;

use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;

class Main extends PluginBase {

    public function onEnable()
    {
        $this->getLogger()->info(TF::RED . "==========( EasyScoreboard API )=========");
        $this->getLogger()->info(TF::GRAY . "» Version: " . $this->getDescription()->getVersion());
        $this->getLogger()->info(TF::GRAY . "» Author: Akari_my");
        $this->getLogger()->info(TF::GRAY . "» Support: https://discord.gg/hcQCmsvE");
        $this->getLogger()->info(TF::RED . "==========( EasyScoreboard API )=========");
    }

    public static function setScoreboardEntry(Player $player, int $score, string $msg, string $objName)
    {
        $entry = new ScorePacketEntry();
        $entry->objectiveName = $objName;
        $entry->type = 3;
        $entry->customName = " $msg   ";
        $entry->score = $score;
        $entry->scoreboardId = $score;
        $pk = new SetScorePacket();
        $pk->type = 0;
        $pk->entries[$score] = $entry;
        $player->sendDataPacket($pk);
    }

    public static function rmScoreboardEntry(Player $player, int $score)
    {
        $pk = new SetScorePacket();
        if (isset($pk->entries[$score])) {
            unset($pk->entries[$score]);
            $player->sendDataPacket($pk);
        }
    }

    public static function createScoreboard(Player $player, string $title, string $objName, string $slot = "sidebar", $order = 0)
    {
        $pk = new SetDisplayObjectivePacket();
        $pk->displaySlot = $slot;
        $pk->objectiveName = $objName;
        $pk->displayName = $title;
        $pk->criteriaName = "dummy";
        $pk->sortOrder = $order;
        $player->sendDataPacket($pk);
    }

    public static function rmScoreboard(Player $player, string $objName)
    {
        $pk = new RemoveObjectivePacket();
        $pk->objectiveName = $objName;
        $player->sendDataPacket($pk);
    }
}
