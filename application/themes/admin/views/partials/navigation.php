<?php 
    $nav_array = array(
        array(
            'label' => 'Dashboard',
            'url'   => '/',
            'id'    => 'dashboard',
            'sub'   => array(),
        ),
        array(
            'label' => 'Content',
            'url'   => 'content/entries',
            'sub'   => array(
                    array(
                        'label' => 'Entries',
                        'url'   => 'content/entries',
                    ),
					array(
                        'label' => 'File Manager',
                        'url'   => 'filemanager',
                    ),
                ),
        ),
        array(
            'label' => 'Plugins',
            'url'   => '#',
            'sub'   => array(
                array(
                    'label' => 'Calendar',
                    'url'   => 'calendar/entries',
                ),
                array(
                    'label' => 'Galleries',
                    'url'   => 'galleries',
                ),
                array(
                    'label' => 'Navigations',
                    'url'   => 'navigations',
                ),
            ),
        ),
        array(
            'label' => 'Users',
            'url'   => 'users',
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
            'label' => 'Tools',
            'url'   => 'content/types',
            'sub'   => array(
                    array(
                        'label' => 'Content Types',
                        'url'   => 'content/types',
                    ),
                    array(
                        'label'  => 'Content Fields',
                        'url'    => 'content/fields',
                        'hidden' => TRUE, // Used for selected parents for this section
                    ),
                    array(
                        'label' => 'Code Snippets',
                        'url'   => 'content/snippets',
                    ),
                    array(
                        'label' => 'Categories',
                        'url'   => 'content/categories/groups',
                    ),
                    array(
                        'label' => 'Theme Editor',
                        'url'   => 'settings/theme-editor',
                    ),
                ),
        ),
        array(
            'label' => 'System',
            'url'   => 'settings/general-settings',
            'sub'   => array(
                    array(
                        'label' => 'General Settings',
                        'url'   => 'settings/general-settings',
                    ),
                    array(
                        'label' => 'Clear Cache',
                        'url'   => 'settings/clear-cache',
                    ),
                    array(
                        'label' => 'Server Info',
                        'url'   => 'settings/server-info',
                    ),
                ),
        ),
    );

    echo admin_nav($nav_array);
?>
