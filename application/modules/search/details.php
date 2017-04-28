<?php 
namespace Modules\Search;
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
            'name'          => 'Site Search',
            'slug'          => 'search',
            'description'   => 'Use this add-on to search site entry titles, entry custom fields, category names, category descriptions, category custom fields and Tagger tags.',
            'version'       => '0.1',
            'addon_uri'     => 'http://pagestudiocms.com',
            'license'       => 'GPL2',
            'license_uri'   => '',
            'author'        => 'Cosmo Mathieu',
            'author_uri'    => 'http://pagestudiocms.com',
            'plugable'      => 1,
            'is_core'       => 0,
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
        return [];
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
        $short_name = 'site-search';
        $result     = NULL;
        
        $result = $this->db->insert('content_types', [
            'title' => 'Site Search', 
            'short_name' => $short_name, 
            'layout' => NULL, 
            'page_head' => NULL, 
            'theme_layout' => 'search_page', 
            'dynamic_route' => NULL, 
            'static_route' => NULL, 
            'required' => 0, 
            'access' => 0, 
            'restrict_to' => NULL, 
            'restrict_admin_access' => 0, 
            'enable_versioning' => 0, 
            'max_revisions' => 5, 
            'entries_allowed' => NULL,
            'category_group_id' => NULL
        ]);
        if ( ! $result) {
            show_error('Unable to create search page content type. File: '. __FILE__ . ' on line: '. (__LINE__ - 18));
            return false;
        }
        
        $result = $this->db->get_where('content_types', ['short_name' => $short_name], 1)->result();
        if ( ! is_array($result)) {
            show_error('Unable to retrieve content_type_id. File: '. __FILE__ . ' on line: '. (__LINE__ - 2));
            return false;
        }

        $content_type_id = $result[0]->id;
        $this->db->insert('entries', [
            'title' => 'Site Search',
            'slug' => $short_name,
            'content_type_id' => $content_type_id,
        ]);
        
        return true;
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
            show_error('Unable to insert module data into the [modules] table. File: '. __FILE__ . ' on line: '. (__LINE__ - 14));
            return false;
        }
        
        if ( ! $this->enable()) {
            return false;
        }
        
		return true;
	}
    
    public function uninstall()
	{
		// This is a core module, lets keep it around.
		// return false;
        $info = $this->info();
        
        if ( ! $this->db->delete('modules', ['module_slug' => $info['slug']])) {
            return false;
        }
		return true;
	}
    
	public function upgrade($old_version)
	{
		return true;
	}
}