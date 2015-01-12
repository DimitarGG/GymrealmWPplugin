# GymRealm WordPress Plugin

The official [GymRealm](http://gymrealm.com/) plugin for WordPress.


## Widgets

The plugin provides three widgets that can be used out of the box:
* GymRealm Add Client Widget;
* GymRealm Book Schedule Widget;
* GymRealm Client Services Widget.

If you want to (and you should) modify the looks of the widgets, you have two
options:
* You can style them through the CSS of your theme (the plugin does not include
  CSS files of its own).
* You can overwrite the widgets' templates. Copy the files from the plugin's
  `tpl` directory into your theme's directory and go wild. Example: if the
  plugin finds out that there exists a `gymrealm-add-client.php` file in your
  theme's directory, it will use that.


## Programmatic Usage

If the functionality provided by the widgets is not what you are looking for,
you can use GymRealm's API directly in your code. Simply refer to the global
variable `$gymrealm_plugin` and, more specifically, its property `$api`. To
check which GymRealm API calls are available at the moment, take a look at the
`lib/Api.class.php` file.

Of course, pull requests are welcome.


## License

The code is published under the [GPL2
license](http://www.gnu.org/licenses/gpl-2.0.html).

