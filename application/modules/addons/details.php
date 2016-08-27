<?php 
namespace Modules\Addons;
use \Module as Module;

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Addons Module
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
            'name'          => 'Addons',
            'description'   => '',
            'version'       => '1.0.0',
            'addon_uri'     => 'http://pagestudiocms.com',
            'license'       => 'GPL2',
            'license_uri'   => '',
            'author'        => 'Cosmo Mathieu',
            'author_uri'    => 'http://pagestudiocms.com',
            'plugable'      => 1,
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
            'label' => 'Addons',
            'no_url' => 'addons',
            'url' => '',
            "menu_order" => 188,
            'class' => 'cd-label',
        ],
        [
            'label' => 'Addons',
            'url'   => 'addons/admin-modules',
            "menu_order" => 188.1,
            'class' => 'has-children',
            'sub'   => array(
                array(
                    'label' => 'Modules',
                    'url'   => 'addons/admin-modules',
                ),
                array(
                    'label' => 'Plugins',
                    'url'   => 'addons/admin-plugins',
                ),
            ),
        ]];
    }
    
    public function enable()
    {
        
    }
    
    public function disable()
    {
        
    }
    
    public function install()
	{
		$this->dbforge->drop_table('modules');
		$tables = array(
			'modules' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'module_slug' => array('type' => 'VARCHAR', 'constraint' => 50, 'unique' => true),
				'module_name' => array('type' => 'VARCHAR', 'constraint' => 50),
				'module_version' => array('type' => 'VARCHAR', 'constraint' => 12),
				'module_description' => array('type' => 'TEXT', 'constraint' => 100),
				'module_options' => array('type' => 'TEXT'),
				'has_backend' => array('type' => 'INT', 'constraint' => 1),
				'has_plugin' => array('type' => 'INT', 'constraint' => 1),
				'has_widget' => array('type' => 'INT', 'constraint' => 1),
				'is_core' => array('type' => 'INT', 'constraint' => 1),
				'is_enabled' => array('type' => 'INT', 'constraint' => 1),
				'is_required' => array('type' => 'INT', 'constraint' => 1),
			),
		);
		if ( ! $this->install_tables($tables)) {
			return false;
		}
        
        // Add data to table 
        $data = [
            'module_slug' => 'addons',
            'module_name' => 'Addons',
            'module_description' => 'Select the theme for the control panel.',
            'module_version' => '1.0',
            'module_options' => '',
            'has_backend' => 1,
            'has_plugin' => 0,
            'has_widget' => 0,
            'is_core' => 1,
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
	}
	public function upgrade($old_version)
	{
		return true;
	}
}