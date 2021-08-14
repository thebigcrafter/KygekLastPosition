# KygekLastPosition

[![Poggit](https://poggit.pmmp.io/shield.dl.total/KygekLastPosition)](https://poggit.pmmp.io/p/KygekLastPosition)
[![Discord](https://img.shields.io/discord/735439472992321587.svg?label=&logo=discord&logoColor=ffffff&color=7389D8&labelColor=6A7EC2)](https://discord.gg/CXtqUZv)

> **WARNING:** This plugin will only work on PocketMine-MP servers using PHP 8.0 or newer.

A PocketMine-MP plugin to teleport back to the position before the last teleport.

## ❓ Why This Plugin Exists

Sometimes you teleported to a location and you want to go back to the location before you got teleported. It takes time to go back to the location before you got teleported, so you might thinking of a plugin that could teleport you to the location before you got teleported. That's why we made KygekLastPosition plugin.

## ✅ Features

- Teleport yourself or other players back to the position before the last teleport
- Customizeable messages in the configuration file
  - Enable or disable the KygekLastPosition prefix and default coloring
  - The `&` symbol can be used as text formatting codes
  - No need to restart server, changes are applied immediately as soon the `/lastposition` command gets executed
- Configurable ommand description and aliases
- Automatic plugin updates checker to notify you if a new version has been released on Poggit
- Configuration file gets updated automatically when a newer configuration file is available
- **For Developers:** API to teleport player back to the position before the last teleport (`KygekTeam\KygekLastPosition\LastPosition->teleport(Player $player)`)

## 🔧 Installation

1. 🔽 Download the latest version on Poggit by clicking the "Direct Download" button.
2. 📁 Drop the downloaded `KygekLastPosition.phar` plugin file into your PocketMine-MP server's `plugins` directory.
3. 🔄 Restart your server and you're ready to use the plugin!

## 🔐 Commands & Permissions

| Command | Default Description | Permission | Default |
| --- | --- | --- | --- |
| `/lastposition` | Teleport back to the position before the last teleport | `kygeklastposition.cmd` (Root permission), `kygeklastposition.cmd.self` (For self), `kygeklastposition.cmd.other` (For other) | `op` |

Command description can be changed in `config.yml`. You can also add command aliases in `config.yml`.

## 🧾 Planned Features

- Save teleport history in disk, to allow players teleport back even if the server has been restarted
- Configurable teleport history limit
- Teleport back to a very old position (e.g. `/lastposition [player] 20`)
- And much more...

You can request for a feature to be added in a future update [here](https://github.com/KygekTeam/KygekLastPosition/issues)!

## ➕ Additional Info

KygekLastPosition is a plugin by KygekTeam and licensed under **GPL-3.0**.

- Join our Discord server [here](https://discord.gg/CXtqUZv) for latest news and support from KygekTeam.
- If you found bugs or want to give suggestions, please visit [here](https://github.com/KygekTeam/KygekLastPosition/issues) or join our Discord server.
- We accept all contributions! If you want to contribute please make a pull request in [here](https://github.com/KygekTeam/KygekLastPosition/pulls).

<a href="https://www.freepnglogos.com/pics/pin">Pin icon from freepnglogos.com</a>
