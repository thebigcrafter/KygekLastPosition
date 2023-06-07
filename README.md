<h1 align="center">KygekLastPosition</h1>

<p align="center">
<a href="https://poggit.pmmp.io/p/KygekLastPosition"><img src="https://poggit.pmmp.io/shield.dl.total/KygekLastPosition?style=for-the-badge" alt="poggit" /></a>
<a href="https://github.com/thebigcrafter/KygekLastPosition/blob/main/LICENSE"><img src="https://img.shields.io/github/license/thebigcrafter/KygekLastPosition?style=for-the-badge" alt="license" /></a>
<a href="https://discord.gg/cEXW8uK6QA"><img src="https://img.shields.io/discord/970294579372912700?color=7289DA&label=discord&logo=discord&style=for-the-badge" alt="discord" /></a>
</p>

# 📖 About

A PocketMine-MP plugin to teleport back to the position before the last teleport.

# 🧩 Features

- Teleport yourself or other players back to the position before the last teleport
- Customizeable messages in the configuration file
  - Enable or disable the KygekLastPosition prefix and default coloring
  - The `&` symbol can be used as text formatting codes
  - No need to restart server, changes are applied immediately as soon the `/lastposition` command gets executed
- Configurable ommand description and aliases
- Automatic plugin updates checker to notify you if a new version has been released on Poggit
- Configuration file gets updated automatically when a newer configuration file is available
- **For Developers:** API to teleport player back to the position before the last teleport (`KygekTeam\KygekLastPosition\LastPosition->teleport(Player $player)`)

# ⬇️ Installation

1. Download the latest version on Poggit by clicking the "Direct Download" button.
2. Drop the downloaded `KygekLastPosition.phar` plugin file into your PocketMine-MP server's `plugins` directory.
3. Restart your server and you're ready to use the plugin!

# 📜 Commands & Permissions

| Command | Default Description | Permission | Default |
| --- | --- | --- | --- |
| `/lastposition` | Teleport back to the position before the last teleport | `kygeklastposition.cmd` (Root permission), `kygeklastposition.cmd.self` (For self), `kygeklastposition.cmd.other` (For other) | `op` |

💡 Tips: Command description can be changed in `config.yml`. You can also add command aliases in `config.yml`.

# 🏆 Credits
<a href="https://www.freepnglogos.com/pics/pin">Pin icon from freepnglogos.com</a>

# ⚖️ License

Licensed under the [GNU General Public License v3.0 license](https://github.com/thebigcrafter/KygekLastPosition/blob/main/LICENSE).
