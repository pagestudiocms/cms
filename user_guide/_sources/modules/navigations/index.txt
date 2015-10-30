
Navigations Module 
==================

This is a powerful tool that lets you build navigation trees with drag and drop functionality that can then be used for navigations and breadcrumbs on your site. See the navigations plugin for instructions on how to embed a navigation tree into your theme.

NAVIGATION ITEM SETTINGS

LINK TYPE:

    Page: Defines a navigation link to a static URL entry page. 
    URL: Defines a relative or absolute navigation link to an internal page or 3rd party site.
    Dynamic Route: Defines a content type that has a dynamic route.

LINK TEXT:

Defines the anchor text for the navigation link. If the link type is set to page and the link text is left blank, the link text will default to the title of the entry.
URL:

Specifies the source URL or dynamic route for the navigation link.
TARGET:

    Current Window: Opens the link in the current window.
    New Tab / Window (_blank): Opens the link in a new window or tab depending on your browser settings.

SUBNAV VISIBILITY:

    Always Show: Always show the subnavigation of the navigation item.
    Only Show In Current Trail: Only shows the subnavigation if the navigation item is the current or a parent of the current page loaded.
    Never Show: Never shows the subnavigation of the navigation item.

HIDE:

Does not show the navigation item when the navigation tree is embedded in the site.
ADVANCED NAVIGATION ITEM SETTINGS
Tag ID:

Adds a id attribute to the navigation items list item tag (ex. <li id="blah">)
Class:

Adds a class attribute to to the navigation items list item tag (ex. <li class="blah">)
Disable Current:

Prevents the navigation item from ever being marked as current
Disable Current Trail:

Prevents the navigation item from ever being marked as part of the current trail

Tempalte Tags
#############

.. toctree::
    :maxdepth: 1
    
    breadcrumb-tag
    nav-tag