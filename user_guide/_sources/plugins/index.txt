
Plugins
=======

Plugins are the simplest type of add-on in PageStudio, but they are at the core of how you access functionality via **tags**.

For an example, let's take the user plugin, which is a part of the user module. 

.. note:: 

    Modules can have a plugin as a part of the module, see the module overview for more info on that.

Each plugin has a name (or slug) by which we reference it in the tags. For example, if we wanted to get the username of the current user, we would use:

.. code-block:: php 
	
    {{ user:username }}

We can also specify a user id and get the username of a specific user:

.. code-block:: php 
	
    {{ user:username user_id="5" }}

Whenever you are using tags in PageStudio, you are interfacing with a plugin.

Template Tag Logic
##################

To get a full idea of what tags can do, make sure you read over the PageStudio tag system documentation.

Installing Plugins
##################

Plugins have no installation procedure. Just upload them to application/plugins/ and use the tag in your template layouts/partials!

Core Plugins
############

.. toctree::
	:titlesonly:
    :maxdepth: 1
   
    helper/index
    secure/index
    template/index
    theme-tag

.. toctree::