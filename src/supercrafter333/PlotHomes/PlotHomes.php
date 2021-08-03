<?php

namespace supercrafter333\PlotHomes;

use pocketmine\plugin\PluginBase;
use supercrafter333\PlotHomes\Commands\HomeCommand;

/**
 * Class PlotHomes
 * @package supercrafter333\PlotHomes
 */
class PlotHomes extends PluginBase
{

    /**
     * @var self
     */
    protected static $instance;

    /**
     * On plugin loading. (That's before enabling)
     */
    public function onLoad()
    {
        self::$instance = $this;
    }

    /**
     * On plugin enabling.
     */
    public function onEnable()
    {
        $myPlotCmds = $this->getServer()->getCommandMap()->getCommand('plot');
        $myPlotCmds->loadSubCommand(new HomeCommand($this));
    }

    /**
     * On plugin disabling
     */
    public function onDisable()
    {
        $myPlotCmds = $this->getServer()->getCommandMap()->getCommand('plot');
        $myPlotCmds->unloadSubCommand("home");
    }
}