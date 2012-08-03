<?php
/*
Plugin Name: Settings API Tutorial
Plugin URI: 
Description: An example of how to use the settings API
Version: 1.0
Text Domain: pmg
Author: Christopher Davis
Author URI: http://christopherdavis.me
License: GPL2

    Copyright 2012 Christopher Davis

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('PMG_SAT_PATH', plugin_dir_path(__FILE__));

if(is_admin())
{
    require_once(PMG_SAT_PATH . 'inc/simplest.php');
    require_once(PMG_SAT_PATH . 'inc/function-based.php');
    require_once(PMG_SAT_PATH . 'inc/class-based.php');
}
