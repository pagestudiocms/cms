
Themes
=======

Folder Structure
################

The ``themes`` directory located in the root directory on PageStudio contains the available themes for the current project. Every base install of PageStudio comes with the ``default`` theme which is a good starting point for building custom themes.

A standard theme directory tree should be similar to the following:

::

    /theme_name
        /assets
            /css
            /img
            /js
            /video
        /views
            /layouts
            /partials

.. important:: The only required naming conventions are the folders: views, layouts, and partials

Assets
*******

The assets directory typically contains items that will be included in the theme. For example stylesheets, images,  javascript libraries, etc. This folder is not required and can be named anything you would like.
Views *Required

This directory contains a layouts and partials subdirectory which contain all the core template files.

Layouts ``*Required``
*********************

Layouts are the base of the theme and typically contain the **doctype**, **header**, **footer**, **stylesheet**, and **javavascripts**. When a page is requested it first determines the page's content type. Typically the content type will have a theme layout which is located in this directory assigned to it but not always. If the page's content type has a layout assigned, it will load that layout and replace the short tag ``{{ content }}`` with the content type's content.

Partials
********

This directory contains reusable code snippets that can be included in your layouts. For example if you have 2 or more layouts that all have the same header and footer you could create header partial and a footer partial.

Building A Custom Theme
#######################

The best way to get started building a custom theme is to copy the default theme to the themes directory and rename it to whatever you would like. If you plan on renaming the default layout located in ``/themes/your_theme/views/layouts``, do that now as well.

The next step is to login to the admin panel of your site and go to ``System => General Settings`` and select your newly created theme from the dropdown (Shown below). Also select the default layout for the theme and then click save.

The site is now using the newly created theme. From here use ``/theme/default/views/layouts/default.php`` and ``/theme/default/views/partials/header.php`` as a guide on how to build your theme. For a full list of available tags and their usage take a look at the Template Plugin and Theme Plugin.
