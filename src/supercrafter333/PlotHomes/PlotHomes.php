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
    protected static self $instance;

    /**
     * Retuns ture if the version is a dev-build and false when it is a stable version
     * @var bool
     */
    private bool $isDev = false;

    /**
     * On plugin loading. (That's before enabling)
     */
    public function onLoad(): void
    {
        self::$instance = $this;
        ### Dev Warning ###
        ###################
        if ($this->isDev) $this->getLogger()->warning("WARNING! You are running a development version of PlotHomes! Please report bugs on: §bhttps://github.com/supercrafter333/PlotHomes/issues");
        ###################
    }

    /**
     * On plugin enabling.
     */
    public function onEnable(): void
    {
        ### Dev Warning ###
        ###################
        if ($this->isDev) $this->getLogger()->warning("WARNING! You are running a development version of PlotHomes! Please report bugs on: §bhttps://github.com/supercrafter333/PlotHomes/issues");
        ###################
        $myPlotCmds = $this->getServer()->getCommandMap()->getCommand('plot');
        $myPlotCmds->loadSubCommand(new HomeCommand($this));
    }

    /**
     * On plugin disabling
     */
    public function onDisable(): void
    {
        $myPlotCmds = $this->getServer()->getCommandMap()->getCommand('plot');
        $myPlotCmds->unloadSubCommand("home");
    }
}