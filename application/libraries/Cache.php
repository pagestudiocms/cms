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
 * Cache library
 *
 * Provides the ability to cache database results as well as anything passed 
 * to it for later retrieval. Items are stored in a file locally on the server. 
 *
 * @package		PageStudio
 * @subpackage	codeigniter
 * @category	Library
 * @author      Mark Price
 * @author		Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @link		http://pagestudiocms.com/docs/
 * @license     MIT License
 * @since       Version 1.0.0
 */
class Cache 
{
    /**
     * Cache Directories
     * @var     string
     */
    private $cache_path          = 'assets/cms/cache/';
    
    /**
     * The base path the the cache directory 
     * @var     string
     */
    private $cache_basepath     = CMS_ROOT;
    
    /**
     * The cache file extension
     * @var     string
     */
    private $cache_ext          = 'cache';
    
    /**
     * Variables names in this array cannot have their values overridden
     * @var     array 
     */
    private $no_override        = [];
    

    function __construct()
    {
        $this->CI = get_instance();
        $this->CI->load->helper('file');
    }

    // ------------------------------------------------------------------------

    /**
     * Model
     *
     * Executes and caches returned data from a model method
     *
     * @param string
     * @param string
     * @param array
     * @return mixed
     */
    public function model($model, $method, $arguments = array(), $dir='')
    {
        $this->CI->load->add_package_path(APPPATH.'modules/content/');
        $this->CI->load->model($model);      

        if ( ! is_array($arguments))
        {
            $arguments = (array) $arguments;
        }

        $cache_id = sha1($method.serialize($arguments));

        // Remove _model from model name to create the cache directory
        if (empty($dir))
        {
            $dir = str_replace('_model', '', strtolower($model)) . '/';
        }

        // Read cached file if it exists
        $data = $this->get($cache_id, $dir);

        if ($data !== FALSE)
        {
            // Data was returned from cache file
            return $data;
        }
        else
        {
            // Instantiate a new instance of the model
            $Class = new $model();
            $Object = $Class->$method($arguments);

            if (is_callable(array($Object, 'exists')) && $Object->exists() || (is_array($Object) && count($Object) > 0))
            {
                $this->save($cache_id, $dir, $Object);
            }

            return $Object;
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Get
     *
     * Unserializes data from cache file
     *
     * @param string
     * @return bool
     */
    public function get($id, $dir)
    {
        $cache_dir = $this->cache_path . trim($dir, '/') . '/';
        
        $this->cache_basepath .  $cache_dir . $id . '.'. $this->cache_ext;

        // Read cached file if it exists
        if (file_exists($this->cache_basepath . $cache_dir . $id . '.'. $this->cache_ext))
        {
            $content = read_file($this->cache_basepath . $cache_dir . $id . '.'. $this->cache_ext);

            return @unserialize($content);
        }

        return FALSE;
    }

    // ------------------------------------------------------------------------

    /**
     * Save
     *
     * Serializes and writes data to cache file
     *
     * @param string
     * @param string
     * @param string
     * @return bool
     */
    public function save($id, $dir, $data)
    {
        $cache_dir = $this->cache_path . trim($dir, '/') . '/';

        // Check if the cache directory exists
        // If not create it
        if ( ! file_exists($this->cache_basepath . $cache_dir))
        {
            @mkdir($this->cache_basepath . $cache_dir);
        }
        // Write data to cache file
        if ( ! write_file($this->cache_basepath . $cache_dir . $id . '.'. $this->cache_ext, @serialize($data)))
        {
            $message = 'Error compiling: ' . $cache_dir . ' is not writable.';
            log_message('error', $message);
            $this->CI->session->set_flashdata('message', '<p class="error">'. $message .'</p>');
            return FALSE;
        }

        return TRUE;
    }

    // ------------------------------------------------------------------------

    /**
     * Delete All
     *
     * This function will  delete caches files in a specified directory
     *
     * @param   string
     * @return  void
     */
    public function delete_all($dir = '')
    {
        $this->CI->load->helper('file');

        if ( file_exists($this->cache_basepath . $this->cache_path . $dir) ) 
        {
            foreach (glob($this->cache_basepath . $this->cache_path . $dir . '/*') as $file)
            {
                @unlink($file);
            }
        }
    }
    
    // ------------------------------------------------------------------------

    /**
     * Method to define or override object default variables
     * 
     * @param   array $config  
     * @return  void
     */
    public function config($config = [])
    {
        if(is_array($config))
        {
            foreach($config as $key => $item)
            {
                if( ! in_array($item, $this->no_override))
                {
                    if($key == 'cache_ext') {
                        $this->$key =  str_replace('.', '', $item);
                    } else {
                        $this->$key = $item;
                    }
                }
            }
        }
    }

}
