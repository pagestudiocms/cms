<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PageStudio
 *
 * A web application for managing website content. For use with PHP 5.4+
 * 
 * This application is based on CMS Canvas, a CodeIgniter based application, 
 * http://cmscanvas.com/. It has been greatly altered to work for the 
 * purposes of our development team. Additional resources and concepts have 
 * been borrowed from PyroCMS http://pyrocms.com, for further improvement
 * and reliability. 
 *
 * @package     PageStudio
 * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @copyright   Copyright (c) 2015, Cosmo Interactive, LLC
 * @license     MIT License
 * @link        http://pagestudiocms.com
 */

// ------------------------------------------------------------------------

/**
 * Secure Plugin Class
 *
 * @author      Mark Price
 * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>
 */
class Secure_plugin extends Plugin
{
    public function is_auth()
    {
        return ($this->secure->is_auth()) ? 1 : 0;
    }
}
