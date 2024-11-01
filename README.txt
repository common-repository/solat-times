=== Solat Times ===
Contributors: nahrizuladib
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=nahrizuladib@gmail.com&currency_code=GBP&amount=&return=&item_name=Donations+for+Nahrizul+Adib+Kadri
Tags: solat times, prayer times, islam, muslim, solat, salaat
Requires at least: 2.1
Tested up to: 2.3.2
Stable tag: 0.1

This plugin will extract the daily solat or salaat (Islamic prayer) times for a specified location based on calculations made by IslamicFinder.org

== Description ==

Muslims need to observe their daily prayer times. With this plugin installed, you're not just reminding yourselves to perform the solat (or salaat), but you'll also be reminding your blog visitors as well.

It is a plugin for you to display the daily **Islamic prayer times** (including sunrise) for your location of choice according to the calculations made at [IslamicFinder.org](http://www.islamicfinder.org/ "IslamicFinder.org")

The plugin allows you to apply your own styling (using CSS) to the prayer times table. By default it will follow the calendar style of your theme.

== Installation ==

1. Get the code for your city from [IslamicFinder.org](http://www.islamicfinder.org/prayer_search.php#2 "Getting the code for your city")
1. Copy the URL from the generated code
1. Download plugin, unzip, and open solat-times.php
1. Replace **`PUT_URL_HERE`** with the copied URL
1. Replace **`MY_CITY`** with the name of selected city/town. Save the file1. Upload the `/solat-times/` folder to your `/wp-content/plugins/` folder, and activate the plugin

[Visit plugin's page](http://nahrizuladib.com/wordpress/?p=675) for detailed installation and usage instructions.

== Usage ==To display the prayer times, place this code:`<?php if(function_exists('solat_times')) { solat_times(); } ?>`To display on sidebar, use this:
`<?php``if(function_exists('solat_times')) {``echo "``<li id='calendar'><h2>Prayer times</h2>";``solat_times();``echo "``</li>";``}``?>`


