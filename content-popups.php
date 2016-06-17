<?php
/**
 * Plugin Name: Content Popups
 * Plugin URI: http://artisanseo.com
 * Description: Manage Popup Posts
 * Version: 0.1.1
 * Author: Jeff Kilroy
 * Author URI: http://jeffkilroy.com
 * License: GPL2
 */

require_once __DIR__ . '/plugin-update-checker/plugin-update-checker.php';
$className = PucFactory::getLatestClassVersion('PucGitHubChecker');
$myUpdateChecker = new $className(
    'https://github.com/kilrizzy/wp-content-popups/',
    __FILE__,
    'master'
);

if (!class_exists('ContentPopups')) {
    require_once __DIR__ . '/classes/ContentPopups.php';
}
if (!class_exists('ContentPopup')) {
    require_once __DIR__ . '/classes/ContentPopup.php';
}
if (!class_exists('ContentPopupsPostType')) {
    require_once __DIR__ . '/classes/ContentPopupsPostType.php';
}
if (!class_exists('ContentPopupsTemplate')) {
    require_once __DIR__ . '/classes/ContentPopupsTemplate.php';
}
$contentPopups = new ContentPopups([
    'pluginDir' => __DIR__,
    'pluginPath' => plugin_dir_url(__FILE__),
]);