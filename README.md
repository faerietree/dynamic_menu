# Dynamic Menu
## What
A menu controlled via file system following UNIX principle 'everything is a file'.

## Why
* No need to hard code, maintain a menu.
* Add a file to a folder on the webserver (e.g. via `scp`) and it shows immediately e.g. as a new PDF file download.
* Quickly hide a menu entry by just hiding the corresponding file on the webserver.

## Documentation

* Link `DynamicMenu.class.php` into the website folder.
  `ln -si ../dynamic_menu/DynamicMenu.class.php .`
* Copy the `dynamicmenu.cfg.php` template
  `cp ../dynamic_menu/dynamicmenu.cfg.php .`
* Customize the configuration e.g. provide more exceptions.
* Include within the site's PHP, e.g.
      <nav id="main-nav" class="navbar-collapse ">
      <?php
      include("dynamicmenu.config.php");
      include("DynamicMenu.class.php");
      ?>
      </nav>
* Now if a file is created, e.g. a folder that contains an index.{php,htm}, the file name shows in the menu and links to it if it is not in the exceptions and the file is not hidden by prepending a "." or a "#" to the file name.

