<?php 
namespace Modules\Content;
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
            'name'          => 'Content',
            'slug'          => 'content',
            'description'   => 'This is by far the largest and most feature rich module of them all. <br />The content module is made up of entries, content types, content fields, categories, and code snippets.',
            'version'       => '1.0',
            'addon_uri'     => 'http://pagestudiocms.com',
            'license'       => 'GPL2',
            'license_uri'   => '',
            'author'        => 'Cosmo Mathieu',
            'author_uri'    => 'http://pagestudiocms.com',
            'plugable'      => 1,
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
            'label' => 'Content',
            'no_url' => 'Content',
            'url' => '',
            "menu_order" => 29,
            'class' => 'cd-label',
        ], [
            'label' => 'Entries',
            'url'   => 'content/entries',
            "menu_order" => 29.1,
        ], [
            'label' => 'Tools',
            'url'   => 'content/types',
            "menu_order" => 149.1,
            'class' => 'has-children',
            'sub'   => [
                [
                    'label' => 'Content Types',
                    'url'   => 'content/types',
                ],
                [
                    'label'  => 'Content Fields',
                    'url'    => 'content/fields',
                    'hidden' => TRUE, // Used for selected parents for this section
                ],
                [
                    'label' => 'Code Snippets',
                    'url'   => 'content/snippets',
                ],
                [
                    'label' => 'Categories',
                    'url'   => 'content/categories/groups',
                ],
                [
                    'label' => 'Theme Editor',
                    'url'   => 'settings/theme-editor',
                ],
            ],
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
            'has_plugin' => 0,
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
	}
    
	public function upgrade($old_version)
	{
		return true;
	}
}