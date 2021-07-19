<?php

namespace refaltor\traps\Event;

use pocketmine\block\Block;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\ActorEventPacket;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\plugin\Plugin;

class PlayerListener implements Listener
{
    public Plugin $plugin;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onMove(PlayerMoveEvent $event): void
    {
        $player = $event->getPlayer();
        $config = $this->plugin->getConfig();
        foreach ($config->get('traps') as $blockID => $keys) {
            $damage = 0;
            if (isset($keys['damage'])) $damage = $keys['damage'];
            $block = $player->getLevel()->getBlockAt($player->getX(), $player->getY() - 1, $player->getZ());
            if (($blockID) === ($block->getId() . ':' . $block->getDamage())) {
                if ($damage > 0) {
                    if ((intval($player->getHealth()) - $damage) <= 0) {
                        $player->kill();
                    } else {
                        $player->setHealth($player->getHealth() - $damage);
                        $player->broadcastEntityEvent(ActorEventPacket::DEATH_ANIMATION);
                    }
                }
                if (isset($keys['message'])) {
                    if (isset($keys['message']['enable']) && $keys['message']['enable']) {
                        $msg = str_replace('{player}', $player->getName(), $keys['content']);
                        if (isset($keys['message']['type'])) {
                            switch ($keys['message']['type']) {
                                case 'popup':
                                    $player->sendPopup($msg);
                                    break;
                                case 'tip':
                                    $player->sendTip($msg);
                                    break;
                                case 'title':
                                    $player->addTitle($msg);
                                    break;
                                case 'message':
                                    $player->sendMessage($msg);
                                    break;
                                case 'subtitle':
                                    $player->addSubTitle($msg);
                                    break;
                            }
                        }
                    }
                }
                $block->getLevel()->setBlock(new Vector3($block->getX(), $block->getY() + 1, $block->getZ()), Block::get(Block::WEB));
                $block->getLevel()->broadcastLevelEvent($block, LevelEventPacket::EVENT_SOUND_TOTEM);
                $player->broadcastEntityEvent(ActorEventPacket::CONSUME_TOTEM);
                if (isset($keys['effects'])) {
                    foreach ($keys['effects'] as $id => $key) {
                        $duration = 20 * 10;
                        $niveau = 0;
                        $particles = false;
                        if (isset($key['duration'])) $duration = intval($key['duration']) * 20;
                        if (isset($key['niveau'])) $niveau = intval($key['niveau']) + 1;
                        if (isset($key['particles'])) $particles = (bool)$key['particles'];
                        $effect = new EffectInstance(Effect::getEffect($id));
                        $effect->setDuration($duration);
                        $effect->setAmplifier($niveau);
                        $effect->setVisible($particles);
                        $player->addEffect($effect);
                    }
                }
            }
        }
    }
}