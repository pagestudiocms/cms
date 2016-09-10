<?php 
namespace Modules\Calendar;
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
            'name'          => 'Calendar',
            'slug'          => 'calendar',
            'description'   => 'The Events Calendar allows you to create and manage your calendar of events with ease. It also comes with an extensible plugin that lets you easily share your events accross your site.',
            'version'       => '1.0',
            'addon_uri'     => 'http://pagestudiocms.com',
            'license'       => 'GPL2',
            'license_uri'   => '',
            'author'        => 'Cosmo Mathieu',
            'author_uri'    => 'http://pagestudiocms.com',
            'plugable'      => 0,
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
        return [[
            'label' => 'Calendar',
            'url'   => 'calendar/entries',
            "menu_order" => 89,
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
        $this->dbforge->drop_table('calendar');
        $this->db->delete('modules', ['module_slug' => $slug]);
        
        // Create table to store the events
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'start' => [
                'type' => 'DATETIME',
                'default' => '1900-01-01 00:00:00',
                'null' => FALSE,
            ],
            'end' => [
                'type' => 'DATETIME',
                'default' => '1900-01-01 00:00:00',
                'null' => FALSE,
            ],
        ];

        log_message('error', '-- -- Will go ahead and create the [calendar] table.');
        $this->dbforge->add_field($fields);        
        $this->dbforge->add_field("created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field('modified DATETIME DEFAULT NULL');
        $this->dbforge->add_field('url VARCHAR(255) NOT NULL');
        $this->dbforge->add_field('location VARCHAR(250) NOT NULL');
        $this->dbforge->add_field('featured_image VARCHAR(255) NOT NULL');
        $this->dbforge->add_field('event_author int(11) NOT NULL');
        $this->dbforge->add_field('allDay VARCHAR(35) NOT NULL');
        $this->dbforge->add_field('recurrence VARCHAR(35) DEFAULT NULL');
        $this->dbforge->add_field('series_id int(64) DEFAULT NULL');
  
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('series_id', FALSE);
        
        // TODO: Document this... 
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
        
        $atts = array('ENGINE' => 'InnoDB'); // TODO: This doesn't work as this feature only exists in CI 3. 
        
        // Let's try running our DB Forge Table and inserting some settings
        if ( ! $this->dbforge->create_table('calendar', FALSE, $atts) OR ! $this->db->insert('modules', $data)) {
            log_message('error', '-- -- Could not create the [calendar] table. Or unable to insert [calendar] settings into [modules] table.');
            return false;
        }
		return true;
	}
    
    public function uninstall()
	{
        $info = $this->info();
        
        if( ! $this->dbforge->drop_table('calendar')) {
            log_message('error', '-- -- Unable to drop the [calendar] table.');
            return false;
        }
        
        if ( ! $this->db->delete('modules', ['module_slug' => $info['slug']])) {
            log_message('error', '-- -- Unable to remove the [calendar] entry from the [modules] table.');
            return false;
        }
		return true;
	}
    
	public function upgrade($old_version)
	{
		return true;
	}
}