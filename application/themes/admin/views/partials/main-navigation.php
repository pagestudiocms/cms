<?php 
    $nav_array = array(
        array(
            'label' => 'Dashboard',
            'url'   => '/',
            // 'id'    => 'dashboard',
            'sub'   => array(),
        ),
        array(
            'label' => 'Content',
            'no_url' => 'Content',
            'url' => '',
            'class' => 'cd-label',
        ),  
        array(
            'label' => 'Entries',
            'url'   => 'content/entries',
        ),
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
        array(
            'label' => 'Design',
            'no_url' => 'Design',
            'url' => '',
            'class' => 'cd-label',
        ),
        array(
            'label' => 'Tools',
            'url'   => 'content/types',
            'class' => 'has-children',
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
            'no_url' => 'System',
            'url' => '',
            'class' => 'cd-label',
        ), 
        array(
            'label' => 'Users',
            'url'   => 'users',
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
            'class' => 'has-children',
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

    $menu = admin_primary_nav($nav_array, array(
        'menu_id' => '', 
        'menu_class' => '', 
        'has-sub' => ''
    ));
    
    echo $menu;
