<h1 align="center">KygekLastPosition</h1>

<p align="center">
<a href="https://github.com/thebigcrafter/KygekLastPosition/releases"><img src="https://img.shields.io/github/v/release/thebigcrafter/KygekLastPosition?style=for-the-badge" alt="GitHub release" /></a>
<a href="https://github.com/thebigcrafter/KygekLastPosition/blob/main/LICENSE"><img src="https://img.shields.io/github/license/thebigcrafter/KygekLastPosition?style=for-the-badge" alt="License" /></a>
<a href="https://discord.gg/PykBfE2TZ9"><img src="https://img.shields.io/discord/1087729577004122112?color=7289DA&label=Discord&logo=discord&style=for-the-badge" alt="Discord" /></a>
</p>

KygekLastPosition is an Axolotl-PM plugin that records player teleport locations and lets a player return to the position before the most recent teleport.

## Features

- Return yourself or another player to the previous teleport position.
- Keep a separate in-memory history for each player while the plugin is enabled.
- Customize command descriptions, aliases, prefixes, colors, and messages.
- Reload message configuration when `/lastposition` is executed.
- Check for plugin updates and refresh an outdated configuration through Hydrogen.

Teleport history is not persisted to disk. Reloading or restarting the server clears the history collected by this plugin.

## Requirements

- Axolotl-PM API 5.0.0
- The [Hydrogen](https://github.com/thebigcrafter/Hydrogen) library, included by the consumer's Virion-compatible build configuration

## Installation

1. Download the plugin PHAR from [GitHub Releases](https://github.com/thebigcrafter/KygekLastPosition/releases) or another trusted release source.
2. Copy `KygekLastPosition.phar` into the server's `plugins` directory.
3. Start or restart Axolotl-PM.

The plugin registers `/lastposition` when it is enabled.

## Commands and permissions

| Command | Description | Permission | Default |
| --- | --- | --- | --- |
| `/lastposition` | Return yourself to the previous teleport position | `kygeklastposition.cmd.self` | `op` |
| `/lastposition <player>` | Return another player to their previous teleport position | `kygeklastposition.cmd.other` | `op` |

`kygeklastposition.cmd` grants both command operations. A sender using the player form must be able to resolve the target by name prefix. The command description and aliases can be changed in `plugin_data/KygekLastPosition/config.yml`; restart the server after changing those command settings.

## Configuration

`plugin_data/KygekLastPosition/config.yml` controls:

- The command description and aliases.
- Whether messages include the `[KygekLastPosition]` prefix.
- Whether default information/warning colors are applied.
- Permission, lookup, empty-history, and success messages.
- Whether Hydrogen checks for updates.
- Whether development-version warnings are enabled.

Message values support `&` color formatting codes. Message changes are reloaded when the command runs, while command registration settings are read during plugin enable.

## Developer API

Other plugins can call `LastPosition::teleport()` after obtaining the plugin instance:

```php
use KygekTeam\KygekLastPosition\LastPosition;
use pocketmine\player\Player;

/** @var LastPosition $lastPosition */
if($lastPosition->teleport($player)){ // $player is a Player instance.
	// The player had teleport history and was moved to the previous position.
}
```

The method returns `true` when a position was available and `false` when the player has no remaining history. A plugin integrating this API should check that the dependency is enabled before using it.

## Development

Install the development dependencies and run the repository's maximum-level PHPStan configuration:

```sh
composer install
composer run analyse
```

The PHAR and runtime behavior must be verified by the consuming Axolotl-PM server and its build pipeline.

## Credits

The plugin is maintained under the KygekTeam project identity. The pin icon is from [freepnglogos.com](https://www.freepnglogos.com/pics/pin).

## License

KygekLastPosition is licensed under the [GNU General Public License v3.0](LICENSE).
