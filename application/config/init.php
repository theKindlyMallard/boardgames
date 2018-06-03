<?php
/**
 * Initializes basic configuration aspects and also runs Composer autoload witch
 * loads all necessary files for application work.
 * 
 * @author theKindlyMallard <the.kindly.mallard@gmail.com>
 */

/**
 * @var string Absolute path to application directory.
 */
define('DIR_APPLICATION', DIR_ROOT . 'application' . DS);
/**
 * @var string Absolute path to controllers main directory.
 */
define('DIR_CONTROLLER', DIR_APPLICATION . 'Controller' . DS);
/**
 * @var string Absolute path to logs directory.
 */
define('DIR_LOGS', DIR_APPLICATION . 'logs' . DS);
/**
 * @var string Absolute path to models main directory.
 */
define('DIR_MODEL', DIR_APPLICATION . 'Model' . DS);
/**
 * @var string Absolute path to public directory.
 */
define('DIR_PUBLIC', DIR_ROOT . 'public' . DS);
/**
 * @var string Absolute path to views main directory.
 */
define('DIR_VIEW', DIR_APPLICATION . 'View' . DS);

try {
    /* Load user configuration. */
    $environmentName = getenv('APPLICATION_ENV');
    if ($environmentName == false) {
        //Not found proper environment variable.
        $possibleFix = 'In Apache virtual host configuration set variable "SetEnv".';
        throw new Exception('Environment not set!');
    }
    
    switch ($environmentName) {
        case 'production':
            require 'master.php';
        break;
        default:
            $possibleFix = 'Contact administrator.';
            throw new Exception('Cannot continue - invalid environment.');
        break;
    }
    
    //Check if composer directory exist.
    if (is_dir(DIR_ROOT . 'vendor')) {
        /**
         * @var string Absolute path to vendor directory.
         */
        define('DIR_VENDOR', DIR_ROOT . 'vendor' . DS);
    } else {
        $possibleFix = 'Is Composer configured?';
        throw new Exception('Vendor directory not found!');
    }
    //Try to run Composer autoload
    if (file_exists(DIR_VENDOR . 'autoload' . FILE_PHP)) {
        require DIR_VENDOR . 'autoload' . FILE_PHP;
    } else {
        $possibleFix = 'Is Composer correct configured?';
        throw new Exception('Composer autoload file not found!');
    }
} catch (Exception $ex) {
?>
    <p style="font-weight: 900">
        Error: <span style="color:red;"><?= $ex->getMessage() ?></span><br />
        Possible fix: <span style="color:forestgreen;"><?= $possibleFix ?></span>
    </p>
<?php
    exit('Application stopped.');
}
