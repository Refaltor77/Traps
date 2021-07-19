<?php

namespace refaltor\traps;

use pocketmine\plugin\PluginBase;
use refaltor\traps\Event\PlayerListener;

class Traps extends PluginBase
{
    public function onEnable()
    {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new PlayerListener($this), $this);
    }
}