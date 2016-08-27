<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PageStudio
 *
 * A web application for managing website content. For use with PHP 5.4+
 * 
 * This application is based on the on the CMS Canvas, the CodeIgniter 
 * application, http://cmscanvas.com/. It has been greatly altered to 
 * work for the purposes of our development team. Additional resources 
 * and concepts have been borrowed from PyroCMS http://pyrocms.com, 
 * for further improvement and reliability. 
 *
 * @package     PageStudio
 * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @copyright   Copyright (c) 2015, CosmoInteractive, LLC
 * @license     MIT License
 * @link        http://pagestudiocms.com
 */
 
// ------------------------------------------------------------------------

/**
 * Builds and sorts the admin menu 
 * TODO: Move all core module menu items to their respective folders. 
 * 
 * @return array
 */
if ( ! function_exists('get_admin_module_menue_items'))
{
    function get_admin_module_menu_items()
    {
        $admin_menu_items = array(
            array(
                'label' => 'Dashboard',
                'url'   => '/',
                "menu_order" => 1,
                'id'    => 'dashboard',
                'sub'   => array(),
            ),
            array(
                'label' => 'File Manager',
                'url'   => 'filemanager',
                "menu_order" => 69,
            ),
            array(
                'label' => 'Calendar',
                'url'   => 'calendar/entries',
                "menu_order" => 89,
            ),
            array(
                'label' => 'Galleries',
                'url'   => 'galleries',
                "menu_order" => 109,
            ),
            array(
                'label' => 'Navigations',
                'url'   => 'navigations',
                "menu_order" => 129,
            ),
            array(
                'label' => 'Design',
                'no_url' => 'Design',
                "menu_order" => 149,
                'url' => '',
                'class' => 'cd-label',
            ),        
            array(
                'label' => 'System',
                'no_url' => 'System',
                'url' => '',
                "menu_order" => 189,
                'class' => 'cd-label',
            ), 
            array(
                'label' => 'Users',
                'url'   => 'users',
                "menu_order" => 209,
                'class' => 'has-children',
                'sub'   => array(
                    array(
                        'label' => 'Users',
                        'url'   => 'users',
                    ),
                    array(
                        'label' => 'User Groups',
                        'url'   => 'users/groups',
                    ),
                ),
            ),
            array(
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
            ),
        );
        
        // Scan the modules directory
        $folders = scandir(APPPATH . 'modules');        
        
        foreach($folders as $folder)
        {
            if(file_exists(APPPATH . "modules/{$folder}/details.php"))
            {
                require_once APPPATH . "modules/{$folder}/details.php";
                $Details = '\\Modules\\'. ucfirst($folder). '\\Details';
                $addon_admin_menu = $Details::admin_menu();
                if( ! empty($addon_admin_menu) && is_array($addon_admin_menu)){
                    $admin_menu_items = array_merge($admin_menu_items, $addon_admin_menu);
                }
                $addon_admin_menu = [];
            }
        }
        
        // Sort the admin menu         
        $sorted_array = uasort($admin_menu_items, function($a, $b) {
            if ($a['menu_order'] === $b['menu_order']) {
                return 0;
            } else {
                return ($a['menu_order'] > $b['menu_order'] ? 1 : -1);
            }
        });
        
        return $admin_menu_items;
    }
}
