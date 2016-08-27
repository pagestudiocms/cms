<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PageStudio CMS
 *
 * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @copyright   Copyright (c) 2015
 * @license     MIT License
 * @link        http://pagestudiocms.com
 */
 
// -------------------------------------------------------------------

class Addons_model extends MY_Model
{
    /**
     * Construct function
     * 
     * @param string $table 
     * @return void
     */
    public function __construct($table = null)
    {
        parent::__construct();
        
        if( ! is_null($table)) {
            $this->_table = $table;
        }
    }
    
    /**
     * Returns an array of modules
     * 
     * @param int $status 
     * @return array
     */
    public function get_modules($status = null)
    {
        $this->primary_key = 'is_enabled';
        if( ! is_null($status))
        {
            return $this->get_many($status);
        }
        else
        {
            return $this->get_all();
        }
    }
    
    /**
     * Returns the state of a given module 
     * 
     * @param [type] $module 
     * @return bool Returns true/false 
     */
    public function is_enabled($module)
    {
        $result = $this->db->where(['module_slug' => $module, 'is_enabled' => 1])
                        ->get($this->_table)
                        ->row();
                        
        return ( ! empty($result)) ? true : false;
    }
}