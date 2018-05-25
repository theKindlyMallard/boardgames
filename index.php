<?php
/**
 * The board games information web page.
 *
 * @license http://opensource.org/licenses/MIT MIT License
 * 
 * @author theKindlyMallard <the.kindly.mallard@gmail.com>
 */

/**
 * @var string Represents directory separator.<br>
 *              Shorter name version of DIRECTORY_SEPARATOR constant.
 */
define('DS', DIRECTORY_SEPARATOR);
/**
 * @var string PHP file extension with dot.
 */
define('FILE_PHP', '.php');
/**
 * @var string Absolute path to root directory.
 */
define('DIR_ROOT', __DIR__ . DS);
/**
 * @var string Absolute path to configuration directory.
 */
define('DIR_CONFIG', __DIR__ . DS . 'application' . DS . 'config' . DS);

//Initialize configuration.
require DIR_CONFIG . 'init.php';

//Launch the application!
$app = new Application();
