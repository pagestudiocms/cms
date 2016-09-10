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
        // Default menu items
        $admin_menu_items = array(
            array(
                'label' => 'Design',
                'no_url' => 'Design',
                "menu_order" => 149,
                'url' => '',
                'class' => 'cd-label',
            ),
        );
        
        // TODO: Get a list of all activated modules from the database 
        // $active_modules = ci()->load->model('addons_model')->table('modules')->get_modules();
        $active_modules = ci()->load->model('addons_model')->table('modules')
            ->get_modules_by([
                'is_enabled' => 1,
                'has_backend' => 1
            ]);
        
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
                    // Only include modules with backend in the admin menu
                    if(module_has_cp($active_modules, $folder)) {
                        $admin_menu_items = array_merge($admin_menu_items, $addon_admin_menu);
                    }
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

/**
 * Helps determine wherther or not a module has backend interface. 
 * 
 * Checks to see if a module's slug was found in an array of modules. This is 
 * a helper method to [get_admin_module_menu_items] 
 * 
 * @return  bool
 */
if ( ! function_exists('module_has_cp'))
{
    function module_has_cp($modules, $module_slug)
    {
        $count = 0;
        foreach($modules as $key => $module){
            if ($module->module_slug === $module_slug) {
                return true;
            }
            if(count($modules) === $count) {
                return;
            }
            $count++;
        }
    }
}
