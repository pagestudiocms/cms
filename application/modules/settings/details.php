<?php 
namespace Modules\Settings;
use \Module as Module;

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Content Module
 * 
 * @link        http://pagestudiocms.com
 * @author      PageStudioCMS Dev Team
 * @package     Modules
 */
class Details extends Module
{
    public static function info()
    {
        return [
            'name'          => 'Settings',
            'slug'          => 'settings',
            'description'   => '',
            'version'       => '1.0',
            'addon_uri'     => 'http://pagestudiocms.com',
            'license'       => 'GPL2',
            'license_uri'   => '',
            'author'        => 'Cosmo Mathieu',
            'author_uri'    => 'http://pagestudiocms.com',
            'plugable'      => 0,
            'is_core'       => 1,
        ];
    }
    
    /**
     * Returns an array containing the module level menu items to be 
     * hooked into the admin menu
     * 
     * @return array
     */
    public static function admin_menu()
    {
        return [[
            'label' => 'System',
            'no_url' => 'System',
            'url' => '',
            "menu_order" => 189,
            'class' => 'cd-label',
        ], [
            'label' => 'System',
            'url'   => 'settings/general-settings',
            "menu_order" => 239,
            'class' => 'has-children',
            'sub'   => array(
                array(
                    'label' => 'Clear Cache',
                    'url'   => 'settings/clear-cache',
                ),
                array(
                    'label' => 'General Settings',
                    'url'   => 'settings/general-settings',
                ),
                array(
                    'label' => 'Server Info',
                    'url'   => 'settings/server-info',
                ),
            ),
        ]];
    }
    
    /**
     * Static method that either returns or instantiates the object
     * 
     * @return object
     */
    public static function run()
    {
        if( ! isset(self::$_instance)) {
            self::$_instance = new Details();
        }
        
        return self::$_instance;
    }
    
    public function enable()
    {
        
    }
    
    public function disable()
    {
        
    }
    
    public function install()
	{
        extract($this->info());
		// Add data to table 
        $data = [
            'module_slug' => $slug,
            'module_name' => $name,
            'module_description' => $description,
            'module_version' => $version,
            'module_options' => '',
            'has_backend' => 1,
            'has_plugin' => $plugable,
            'has_widget' => 0,
            'is_core' => $is_core,
            'is_enabled' => 1,
            'is_required' => 1,
            // 'menu_order' => 0,
		];
        
        if ( ! $this->db->insert('modules', $data)) {
            return false;
        }
		return true;
	}
    
    public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;
        // $info = $this->info();
        
        // if ( ! $this->db->delete('modules', ['module_slug' => $info['slug']])) {
            // return false;
        // }
		// return true;
	}
    
	public function upgrade($old_version)
	{
		return true;
	}
}