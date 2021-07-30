<?php

/*
 * Teleport back to the position before the last teleport
 * Copyright (C) 2021 KygekTeam
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace KygekTeam\KygekLastPosition;

use KygekTeam\KtpmplCfs\KtpmplCfs;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\Listener;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;

class LastPosition extends PluginBase implements Listener {

    public const PREFIX = TF::AQUA . "[KygekLastPosition] " . TF::RESET;
    public const INFO = TF::GREEN;
    public const WARNING = TF::YELLOW;

    private const COMMAND = "lastposition";

    private const DEFAULT_MESSAGES = [
        "no-permission.self" => "You don't have permission to use this command for teleporting yourself",
        "no-permission.other" => "You don't have permission to use this command for teleporting other players",
        "player-not-found" => "Cannot find the requested player",
        "no-teleport-history.self" => "Unable to teleport you back because you haven't been teleported before or you don't have any remaining teleport history",
        "no-teleport-history.other" => "Unable to teleport \$target back because \$target haven't been teleported before or doesn't have any remaining teleport history",
        "success.self" => "Successfully teleported you back to the position before the last teleport",
        "success.other.sender" => "Successfully teleported \$target back to the position before the last teleport",
        "success.other.target" => "You have been telepoted back to the position before the last teleport by \$sender"
    ];

    /** @var Position[][] */
    private array $teleports = [];
    // When set to 'true' by this plugin, this plugin prevents teleport location to be stored by this plugin when teleporting back
    private bool $pluginTeleports = false;

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->register($this->getName(), new Command(self::COMMAND, $this));

        KtpmplCfs::checkConfig($this, "1.0");
        KtpmplCfs::checkUpdates($this);
    }

    /**
     * @priority MONITOR
     */
    public function onTeleport(EntityTeleportEvent $event) {
        if ($event->isCancelled()) return;
        if (!(($player = $event->getEntity()) instanceof Player)) return;
        if ($this->pluginTeleports) return;

        /** @var Player $player */
        $this->teleports[$player->getName()][] = $event->getFrom();
    }

    /**
     * Teleports player back to the position before the last teleport
     *
     * @param Player $player Player to teleport
     * @return bool False if player haven't been teleported before or player doesn't have any remaining teleport history, otherwise True
     */
    public function teleport(Player $player) : bool {
        if (!isset($this->teleports[$player->getName()]) || empty($this->teleports[$player->getName()])) return false;

        /** @see LastPosition::$pluginTeleports */
        $this->pluginTeleports = true;
        $player->teleport(end($this->teleports[$player->getName()]));
        $this->pluginTeleports = false;
        array_pop($this->teleports[$player->getName()]);
        return true;
    }

    public function getMessage(string $key, array $vars = []) : string {
        // Add '$' prefix to all keys in $vars
        foreach ($vars as $var => $value) {
            $vars["$" . $var] = $value;
            unset($vars[$var]);
        }

        $config  = $this->getConfig();
        $prefix  = $config->getNested("message.show-prefix", true) ? self::PREFIX : "";
        $color   = $config->getNested("message.use-default-color", true) ?
            /** @phpstan-ignore-next-line */
            (str_starts_with($key, "success") ? self::INFO : self::WARNING) : "";
        $message = $config->getNested("message.$key", self::DEFAULT_MESSAGES[$key]);

        $message = $prefix . $color . TF::Colorize($message);
        return str_ireplace(array_keys($vars), array_values($vars), $message);
    }

}
