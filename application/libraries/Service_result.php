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
 * A PHP json object template for dealing with php and ajax form submissions
 * 
 * Provides a framework (for lack of better words) for dealing with ajax 
 * form submissions. Provides an example of how the php and JavaScript code 
 * should be formatted. 
 * 
 * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>
 */
class Service_result 
{
    /**
     * Will always be true or false. If you want to send back a response 
     * message, set the $message variable.
     * @var Boolean
     */
    public $status = 'error';
    
    /**
     * 
     * @var Array
     */
    public $message = 'The query returned an empty set.';
    
    /**
     * Holds data returned by a service or passthrough data.
     * @var mixed
     */
    public $result = 0;
    
    /**
     * Holds the errors generated in the Service object
     * @var Array
     */
    public $errors = [];
    
    /**
     *
     * @var String - Event name triggered in JavaScript when service call successful.
     */
    public $onSuccessEvent;
    
    /**
     *
     * @var String - Event name triggered in JavaScript when service call fails.
     */
    public $onErrorEvent;
    
    /**
     * @var string
     */
    public $start = 0;
    
    /**
     * @var string
     */
    public $end = 0;
    
    /**
     * @var string
     */
    public $duration = 0;
    
    /**
     * @var array 
     */
    private $timers = [];
    
    
    public function __construct()
    {
        $this->start = microtime(true);
    }
    
    /**
     * Starts the timer for given title
     * 
     * @param object $title
     * @return  void
     */
    public function start_timer($title = '')
    {
        $this->timers[$title] = microtime(true);
    }
    
    /**
     * Brings back the result of time spending in seconds with floating point of milli seconds
     * Title must be exact same of the start functon
     * 
     * @param object $title
     * @return  string 
     */
    public function stop_timer($title = '')
    {
        $end = microtime(true);
        return  sprintf("%01.3f", ($end - $this->timers[$title]));
    }
    
    /**
     * Metod to display errors 
     * 
     * @return  void
     */
    public function show_errors()
    {
        echo json_encode($this->errors);
    }
    
    /**
     * Display the service result to the page in json format
     * 
     * @return  void
     */
    public function show_results($obj = null)
    {
        header("Content-Type: application/json");
        
        $this->end = microtime(true);
        $this->duration = $this->end - $this->start;
        exit( json_encode($this));
    }
}
