<?php 
    $nav_array = array(
        array(
            'title' => 'Dashboard',
            'url'   => '/',
            // 'id'    => 'dashboard',
            'sub'   => array(),
        ),
        array(
            'title' => 'Content',
            'url'   => 'content/entries',
            'sub'   => array(
                    array(
                        'title' => 'Entries',
                        'url'   => 'content/entries',
                    ),
                ),
        ),
        array(
            'title' => 'Plugins',
            'url'   => '#',
            'sub'   => array(
                array(
                    'title' => 'Calendar',
                    'url'   => 'calendar/entries',
                ),
                array(
                    'title' => 'Galleries',
                    'url'   => 'galleries',
                ),
                array(
                    'title' => 'Navigations',
                    'url'   => 'navigations',
                ),
            ),
        ),
        array(
            'title' => 'Users',
            'url'   => 'users',
            'sub'   => array(
                    array(
                        'title' => 'Users',
                        'url'   => 'users',
                    ),
                    array(
                        'title' => 'User Groups',
                        'url'   => 'users/groups',
                    ),
                ),
        ),
        array(
            'title' => 'Tools',
            'url'   => 'content/types',
            'sub'   => array(
                    array(
                        'title' => 'Content Types',
                        'url'   => 'content/types',
                    ),
                    array(
                        'title'  => 'Content Fields',
                        'url'    => 'content/fields',
                        'hidden' => TRUE, // Used for selected parents for this section
                    ),
                    array(
                        'title' => 'Code Snippets',
                        'url'   => 'content/snippets',
                    ),
                    array(
                        'title' => 'Categories',
                        'url'   => 'content/categories/groups',
                    ),
                    array(
                        'title' => 'Theme Editor',
                        'url'   => 'settings/theme-editor',
                    ),
                ),
        ),
        array(
            'title' => 'System',
            'url'   => 'settings/general-settings',
            'sub'   => array(
                    array(
                        'title' => 'General Settings',
                        'url'   => 'settings/general-settings',
                    ),
                    array(
                        'title' => 'Clear Cache',
                        'url'   => 'settings/clear-cache',
                    ),
                    array(
                        'title' => 'Server Info',
                        'url'   => 'settings/server-info',
                    ),
                ),
        ),
    );

    $menu = admin_primary_nav($nav_array, array(
        'menu_id' => 'navigation', 
        'menu_class' => 'sf-navbar', 
        'has-sub' => ''
    ));
    
    echo $menu;
?>
    <!--
    <ul id="navigation" class="sf-navbar">
        <li class="selected">
            <a href="/">Dashboard</a>
        </li>
        <li>
            <a href="#">Content</a>
            <ul>
                <li>
                    <a href="#">Entries</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#">Plugins</a>
            <ul>
                <li>
                    <a href="three-columns-layout.php">Calendar</a>
                </li>
                <li>
                    <a href="three-column-small-layout.php">Galleries</a>
                </li>
                <li>
                    <a href="two-column-layout.php">Navigations</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#">Users</a>
            <ul>
                <li>
                    <a href="accordion.php">Accordion</a>
                </li>
                <li>
                    <a href="tabs.php">Tabs</a>
                </li>
                <li>
                    <a href="overlays.php">Overlays</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#">Tools</a>
            <ul>
                <li>
                    <a href="accordion.php">Accordion</a>
                </li>
                <li>
                    <a href="tabs.php">Tabs</a>
                </li>
                <li>
                    <a href="overlays.php">Overlays</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#">System</a>
            <ul>
                <li>
                    <a href="accordion.php">Accordion</a>
                </li>
                <li>
                    <a href="tabs.php">Tabs</a>
                </li>
                <li>
                    <a href="overlays.php">Overlays</a>
                </li>
            </ul>
        </li>
    </ul>
    -->