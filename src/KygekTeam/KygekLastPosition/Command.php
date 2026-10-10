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
use function array_values;
use function array_filter;
use function is_array;
use function is_string;

class Command extends PMCommand implements PluginOwned {

	private const PERMISSION_ROOT = "kygeklastposition.cmd";

	private const PERMISSION_SELF = "kygeklastposition.cmd.self";
	private const PERMISSION_OTHER = "kygeklastposition.cmd.other";

	private LastPosition $plugin;

	public function __construct(string $name, LastPosition $owner) {
		$desc = $owner->getConfig()->getNested("command.description", "");
		if (!is_string($desc)) {
			$desc = "";
		}
		$desc = empty($desc) ? "Teleport back to the position before the last teleport" : $desc;
		$aliases = $owner->getConfig()->getNested("command.aliases", []);
		$aliases = is_array($aliases) ? array_values(array_filter($aliases, is_string(...))) : [];
		parent::__construct($name, $desc, "/lastposition [player]", $aliases);
		$this->setPermission(self::PERMISSION_ROOT);
		$this->plugin = $owner;
	}

	/** @param array<string> $args */
	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool {
		$plugin = $this->getOwningPlugin();
		$plugin->getConfig()->reload();

		if (!isset($args[0])) {
			if (!$sender instanceof Player) {
				$sender->sendMessage(LastPosition::PREFIX . LastPosition::INFO . "Usage: /lastposition <player>");
				return true;
			}

			if (!$sender->hasPermission(self::PERMISSION_SELF) && !$sender->hasPermission(self::PERMISSION_ROOT)) {
				$sender->sendMessage($plugin->getMessage("no-permission.self"));
				return true;
			}

			if (!$plugin->teleport($sender)) {
				$sender->sendMessage($plugin->getMessage("no-teleport-history.self"));
				return true;
			}

			$sender->sendMessage($plugin->getMessage("success.self"));
				return true;
		}

		if (!$sender->hasPermission(self::PERMISSION_OTHER) && !$sender->hasPermission(self::PERMISSION_ROOT)) {
			$sender->sendMessage($plugin->getMessage("no-permission.other"));
			return true;
		}

		$target = $plugin->getServer()->getPlayerByPrefix($args[0]);
		if ($target === null) {
			$sender->sendMessage($plugin->getMessage("player-not-found"));
			return true;
		}

		if (!$plugin->teleport($target)) {
			$sender->sendMessage($plugin->getMessage("no-teleport-history.other", ["target" => $target->getName()]));
			return true;
		}

		$sender->sendMessage($plugin->getMessage("success.other.sender", ["target" => $target->getName()]));
		$target->sendMessage($plugin->getMessage("success.other.target", ["sender" => $sender->getName()]));
		return true;
	}

	public function getOwningPlugin() : LastPosition {
		return $this->plugin;
	}

}
