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

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class Command extends PluginCommand {

    private const PERMISSION_ROOT = "kygeklastposition.cmd";

    private const PERMISSION_SELF = "kygeklastposition.cmd.self";
    private const PERMISSION_OTHER = "kygeklastposition.cmd.other";

    public function __construct(string $name, Plugin $owner) {
        parent::__construct($name, $owner);
        $desc = $owner->getConfig()->getNested("command.description", "");
        $this->setDescription(empty($desc) ? "Teleport back to the position before the last teleport" : $desc);
        $this->setUsage("/lastposition [player]");
        $this->setPermission(self::PERMISSION_ROOT);
        $this->setAliases($owner->getConfig()->getNested("command.aliases", []));
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        /** @var LastPosition $plugin */
        $plugin = $this->getPlugin();
        $plugin->getConfig()->reload();

        if (!isset($args[0])) {
            if (!$sender instanceof Player) {
                $sender->sendMessage(LastPosition::PREFIX . LastPosition::INFO . "Usage: /lastposition <player>");
                return;
            }

            if (!$sender->hasPermission(self::PERMISSION_SELF)) {
                $sender->sendMessage($plugin->getMessage("no-permission.self"));
                return;
            }

            if (!$plugin->teleport($sender)) {
                $sender->sendMessage($plugin->getMessage("no-teleport-history.self"));
                return;
            }

            $sender->sendMessage($plugin->getMessage("success.self"));
            return;
        }

        if (!$sender->hasPermission(self::PERMISSION_OTHER)) {
            $sender->sendMessage($plugin->getMessage("no-permission.other"));
            return;
        }

        $target = $plugin->getServer()->getPlayer($args[0]);
        if ($target === null) {
            $sender->sendMessage($plugin->getMessage("player-not-found"));
            return;
        }

        if (!$plugin->teleport($target)) {
            $sender->sendMessage($plugin->getMessage("no-teleport-history.other", ["target" => $target->getName()]));
            return;
        }

        $sender->sendMessage($plugin->getMessage("success.other.sender", ["target" => $target->getName()]));
        $target->sendMessage($plugin->getMessage("success.other.target", ["sender" => $sender->getName()]));
    }

}