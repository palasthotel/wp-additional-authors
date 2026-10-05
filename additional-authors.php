<?php
/**
 * Plugin Name:       Additional Authors - DEV
 * Description:       Loads public/additional-authors.php when this repository is checked out into wp-content/plugins/. Not shipped — the released plugin is the content of public/.
 * Plugin URI:        https://github.com/palasthotel/wp-additional-authors
 * Version:           X.X.X
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Author:            Palasthotel <webmaster@palasthotel.de>
 * Author URI:        https://palasthotel.de
 * License:           GPL-3.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once __DIR__ . '/public/additional-authors.php';
