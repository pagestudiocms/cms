<?php 
$nav_array = array(
    array(
        'title' => 'Dashboard',
        'url'   => '/',
        'id'    => 'dashboard',
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
                array(
                    'title' => 'Navigations',
                    'url'   => 'navigations',
                ),
                array(
                    'title' => 'Galleries',
                    'url'   => 'galleries',
                ),
            ),
    ),
    array(
        'title' => 'Posts', 
        'url'   => 'posts/posts',
        'sub'   => array( 
                array(
                    'title' => 'All Posts',
                    'url'   => 'posts/posts',
                ),
                array(
                    'title' => 'Add New',
                    'url'   => 'posts/new',
                ),
                array(
                    'title' => 'Categories',
                    'url'   => 'posts/categories',
                ),
                array(
                    'title' => 'Tags',
                    'url'   => 'posts/tags',
                ),
            )
    ),
    array(
        'title' => 'File Manager', 
        'url' => 'posts/file-manager',
        'sub' => array()
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

// echo admin_sidebar($nav_array);

// -----------------------------------------------------------

require_once APPPATH . 'libraries/FlexiMenu/Flex_Menu.php';
require_once APPPATH . 'libraries/FlexiMenu/Flex_Item.php';
require_once APPPATH . 'libraries/FlexiMenu/Flex_Link.php';

function bootstrapItems($items) {
    
    // Starting from items at root level
    if( !is_array($items) ) {
        $items = $items->roots();
    }
    
    foreach( $items as $item ) {
    ?>
        <li<?php if($item->hasChildren()): ?> class="dropdown"<?php endif ?>>
        <a href="<?php echo $item->link->get_url() ?>" <?php if($item->hasChildren()): ?> class="dropdown-toggle" data-toggle="dropdown" <?php endif ?>>
         <?php echo $item->link->get_text() ?> <?php if($item->hasChildren()): ?> <b class="caret"></b> <?php endif ?></a>
        <?php if($item->hasChildren()): ?>
        <ul class="dropdown-menu">
        <?php bootstrapItems( $item->children() ) ?>
        </ul> 
        <?php endif ?>
        </li>
    <?php
    }
}

// $menu #1
$main = new Flex_Menu;

$main->add('<span class="glyphicon glyphicon-home"></span>', '');
$about = $main->add('about', 'about');
   $about->add('Who we are?', 'who-we-are?');
   $about->add('What we do?', 'what-we-do?');
$main->add('Services', 'services');
$main->add('Portfolio', 'portfolio');
$main->add('Contact', 'contact');

// menu #2
$user = new Flex_Menu;

$user->add('login', 'login');
$profile = $user->add('Profile', 'profile');
  $profile->add('Account', 'account')
          ->link->prepend('<span class="glyphicon glyphicon-user"></span> ');
  
  $profile->add('Settings', 'settings')
          ->link->prepend('<span class="glyphicon glyphicon-cog"></span> ');
          
?>    
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Sitepoint</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php echo bootstrapItems($main); ?>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
            <?php echo bootstrapItems($user); ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
