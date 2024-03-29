<?php

/*
 * Teleport back to the position before the last teleport
 * Copyright (C) 2021-2023 KygekTeam
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace KygekTeam\KygekLastPosition;

use pocketmine\command\Command as PMCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;

class Command extends PMCommand implements PluginOwned {

	private const PERMISSION_ROOT = "kygeklastposition.cmd";

	private const PERMISSION_SELF = "kygeklastposition.cmd.self";
	private const PERMISSION_OTHER = "kygeklastposition.cmd.other";

	private LastPosition $plugin;

	public function __construct(string $name, LastPosition $owner) {
		$desc = $owner->getConfig()->getNested("command.description", "");
		$desc = empty($desc) ? "Teleport back to the position before the last teleport" : $desc;
		parent::__construct($name, $desc, "/lastposition [player]", $owner->getConfig()->getNested("command.aliases", []));
		$this->setPermission(self::PERMISSION_ROOT);
		$this->plugin = $owner;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		$plugin = $this->getOwningPlugin();
		$plugin->getConfig()->reload();

		if (!isset($args[0])) {
			if (!$sender instanceof Player) {
				$sender->sendMessage(LastPosition::PREFIX . LastPosition::INFO . "Usage: /lastposition <player>");
				return;
			}

			if (!$sender->hasPermission(self::PERMISSION_SELF) && !$sender->hasPermission(self::PERMISSION_ROOT)) {
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

		if (!$sender->hasPermission(self::PERMISSION_OTHER) && !$sender->hasPermission(self::PERMISSION_ROOT)) {
			$sender->sendMessage($plugin->getMessage("no-permission.other"));
			return;
		}

		$target = $plugin->getServer()->getPlayerByPrefix($args[0]);
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

	public function getOwningPlugin() : LastPosition {
		return $this->plugin;
	}

}
