<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PageStudio
 *
 * A web application for managing website content. For use with PHP 5.4+
 * 
 * This application is based on the PHP framework, 
 * PIP http://gilbitron.github.io/PIP/. PIP has been greatly altered to 
 * work for the purposes of our development team. Additional resources 
 * and concepts have been borrowed from CodeIgniter,
 * http://codeigniter.com for further improvement and reliability. 
 *
 * @package     PageStudio
 * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>
 */
 
// ------------------------------------------------------------------------

/**
 * Composer autoloading for CodeIgniter 2.x
 *
 * @author  Rana
 * @author  Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @link    http://codesamplez.com/development/composer-with-codeigniter
 */
class MY_Composer 
{
    function __construct() 
    {
		$composer_autoload = APPPATH . "vendor/autoload.php";
        if(file_exists($composer_autoload)) {
			include_once $composer_autoload;
		}
    }
}