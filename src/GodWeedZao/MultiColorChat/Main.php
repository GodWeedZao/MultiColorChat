<?php

declare(strict_types=1);

namespace GodWeedZao\MultiColorChat;
#============================================================#
#                    Plugin By GodWeedZao                    #
#============================================================#
# ╔═╗╔═╗    ╔╗ ╔╗    ╔═══╗    ╔╗         ╔═══╗╔╗       ╔╗   #
# ║║╚╝║║    ║║╔╝╚╗   ║╔═╗║    ║║         ║╔═╗║║║      ╔╝╚╗  #
# ║╔╗╔╗║╔╗╔╗║║╚╗╔╝╔╗ ║║ ╚╝╔══╗║║ ╔══╗╔═╗ ║║ ╚╝║╚═╗╔══╗╚╗╔╝  #
# ║║║║║║║║║║║║ ║║ ╠╣ ║║ ╔╗║╔╗║║║ ║╔╗║║╔╝ ║║ ╔╗║╔╗║╚ ╗║ ║║   #
# ║║║║║║║╚╝║║╚╗║╚╗║║ ║╚═╝║║╚╝║║╚╗║╚╝║║║  ║╚═╝║║║║║║╚╝╚╗║╚╗  #
# ╚╝╚╝╚╝╚══╝╚═╝╚═╝╚╝ ╚═══╝╚══╝╚═╝╚══╝╚╝  ╚═══╝╚╝╚╝╚═══╝╚═╝  #
#============================================================#
#    Report: https://Github.com/GodWeedZao/MultiColorChat    #
#============================================================#
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener
{

    public static $config;
    public static $multiColor;

    public function onEnable()
    {
        @mkdir($this->getDataFolder());
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
        self::$config = $this->getConfig();
        if (empty(self::$config->get('MultiColor'))) {
            $this->getLogger()->error('We didn\'t find any color format for MultiColor Permission, its set to default!');
            self::$multiColor = ['§l', '§a', '§2', '§c', '§4', '§e', '§6', '§d', '§5', '§b', '§3'];
        } else {
            self::$multiColor = self::$config->get('MultiColor');
        }
    }

    /**
     * @param $message
     * @return string
     */
    public static function setMultiColor($message)
    {
        $color = "";
        for ($numberPos = 0; $numberPos < strlen($message) - 1; $numberPos++) {
            $color .= $message[$numberPos] . self::$multiColor[$numberPos % count(self::$multiColor)];
        }
        return $color .= $message[$numberPos];
    }

    /**
     * @param PlayerChatEvent $event
     */
    public function onChat(PlayerChatEvent $event)
    {
        $player = $event->getPlayer();
         if (($player->hasPermission('multicolorchat.rainbow'))) {
            $event->setMessage(self::setMultiColor($event->getMessage()));
        }
    }
}
