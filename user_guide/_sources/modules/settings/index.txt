
Settings Module
===============

WHAT IS IT?

The settings module is located in the admin panel and is where you can manage all of the global settings for your website.
General Settings
SITE NAME:

This is the name of your website. This name is also used in the meta title for your site's pages by default.
NOTIFICATION EMAIL:

This is the email address that the contact module uses to send emails to by default, however it can be overridden by the contact module's tag parameters. There are also plans to use this email address in future developments.
SITE HOMEPAGE:

This defines which page is the homepage of your website. Only static URL pages can be used as a homepage.
CUSTOM 404:

This defines which page to redirect to if the requested URL does not exist. Only static URL pages can be used as a custom 404 page.
THEME:

This allows you to select which theme to use for your website.
DEFAULT LAYOUT:

Allows you to select which layout in your theme that you want your content types to default to. This can be overridden by selecting a different layout when creating your content type.
CONTENT EDITOR'S STYLESHEET:

Enables you to specify a CSS file to extend CKEidtor's and TinyMCE's default theme and provide custom classes for the styles dropdown.

NOTE: This is not used by the inline editor as it already parses all stylesheets included on the live website.
ADMIN TOOLBAR:

Enables or disables the toolbar at located at the top of the live website when logged in as an administrator.
ENABLE PROFILER:

This is a handy tool that when enabled displays page load times and executed queries at the bottom of each page of the live site.
SUSPEND SITE:

Only visible to super admins and when enabled it disables access to all pages except for the admin panel displaying a message saying "Site Suspended. For more information please contact the site administrator.".

.. toctree::
    :maxdepth: 1
    
    site-url-tag