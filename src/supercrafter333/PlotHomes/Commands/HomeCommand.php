<?php

namespace supercrafter333\PlotHomes\Commands;

use MyPlot\forms\MyPlotForm;
use MyPlot\MyPlot;
use MyPlot\Plot;
use MyPlot\subcommand\SubCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use supercrafter333\PlotHomes\PlotHomes;

/**
 * Class HomeCommand
 * @package supercrafter333\PlotHomes\Commands
 */
class HomeCommand extends SubCommand
{

    /**
     * @var PlotHomes
     */
    private $realPlugin;

    /**
     * HomeCommand constructor.
     * @param PlotHomes $realPlugin
     */
    public function __construct(PlotHomes $realPlugin)
    {
        parent::__construct(MyPlot::getInstance(), $this->getName());
        $this->realPlugin = $realPlugin;
    }

    /**
     * @return PlotHomes
     */
    public function getRealPlugin(): PlotHomes
    {
        return $this->realPlugin;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'home';
    }

    /**
     * @param CommandSender $s
     * @return bool
     */
    public function canUse(CommandSender $s): bool
    {
        return ($s instanceof Player) && $s->hasPermission("myplot.command.home");
    }

    /**
     * @param Player|null $player
     * @return MyPlotForm|null
     */
    public function getForm(?Player $player = null): ?MyPlotForm
    {
        return null;
    }

    /**
     * @param CommandSender $sender
     * @param string[] $args
     * @return bool
     */
    public function execute(CommandSender $sender, array $args): bool
    {
        if (count($args) === 0) {

            $plotNumber = 1;
            $levelName = $sender->getLevelNonNull()->getFolderName();
            $plots = $this->getPlugin()->getPlotsOfPlayer($sender->getName(), $levelName);
            if (count($plots) === 0) {
                $sender->sendMessage(TextFormat::RED . $this->translateString("home.noplots"));
                return true;
            }
            if (!isset($plots[$plotNumber - 1])) {
                $sender->sendMessage(TextFormat::RED . $this->translateString("home.notexist", [$plotNumber]));
                return true;
            }
            usort($plots, function (Plot $plot1, Plot $plot2) {
                if ($plot1->levelName == $plot2->levelName) {
                    return 0;
                }
                return ($plot1->levelName < $plot2->levelName) ? -1 : 1;
            });
            $plot = $plots[$plotNumber - 1];
            if ($this->getPlugin()->teleportPlayerToPlot($sender, $plot)) {
                $sender->sendMessage($this->translateString("home.success", [$plot->__toString(), $plot->levelName]));
            } else {
                $sender->sendMessage(TextFormat::RED . $this->translateString("home.error"));
            }

        } elseif (count($args) > 0 && is_numeric($args[0])) {

            $plotNumber = (int)$args[0];
            $levelName = $sender->getLevelNonNull()->getFolderName();
            $plots = $this->getPlugin()->getPlotsOfPlayer($sender->getName(), $levelName);
            if (count($plots) === 0) {
                $sender->sendMessage(TextFormat::RED . $this->translateString("home.noplots"));
                return true;
            }
            if (!isset($plots[$plotNumber - 1])) {
                $sender->sendMessage(TextFormat::RED . $this->translateString("home.notexist", [$plotNumber]));
                return true;
            }
            usort($plots, function (Plot $plot1, Plot $plot2) {
                if ($plot1->levelName == $plot2->levelName) {
                    return 0;
                }
                return ($plot1->levelName < $plot2->levelName) ? -1 : 1;
            });
            $plot = $plots[$plotNumber - 1];
            if ($this->getPlugin()->teleportPlayerToPlot($sender, $plot)) {
                $sender->sendMessage($this->translateString("home.success", [$plot->__toString(), $plot->levelName]));
            } else {
                $sender->sendMessage(TextFormat::RED . $this->translateString("home.error"));
            }

        } elseif (count($args) > 0 && is_string($args[0])) {

            if (count($args) >= 2 && is_numeric($args[1])) {
                $plotNumber = (int)$args[1];
            } else {
                $plotNumber = 1;
            }
            $name = $args[0];
            if (($player = Server::getInstance()->getPlayer($name)) instanceof Player) {
                $name = $player->getName();
            }
            $levelName = $sender->getLevelNonNull()->getFolderName();
            $plots = $this->getPlugin()->getPlotsOfPlayer($name, $levelName);
            if (count($plots) === 0) {
                $sender->sendMessage(TextFormat::RED . $this->translateString("home.noplots"));
                return true;
            }
            if (!isset($plots[$plotNumber - 1])) {
                $sender->sendMessage(TextFormat::RED . $this->translateString("home.notexist", [$plotNumber]));
                return true;
            }
            usort($plots, function (Plot $plot1, Plot $plot2) {
                if ($plot1->levelName == $plot2->levelName) {
                    return 0;
                }
                return ($plot1->levelName < $plot2->levelName) ? -1 : 1;
            });
            $plot = $plots[$plotNumber - 1];
            if ($this->getPlugin()->teleportPlayerToPlot($sender, $plot)) {
                $sender->sendMessage($this->translateString("home.success", [$plot->__toString(), $plot->levelName]));
            } else {
                $sender->sendMessage(TextFormat::RED . $this->translateString("home.error"));
            }
        }
        return true;
    }
}