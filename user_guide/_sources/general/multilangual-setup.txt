
Multilangual Setup
==================

Folder Setup
############

.. code-block:: php 

    /cms-canvas
        /application
        /assets
        /en
            .htaccess
            .index.php
        /es
            .htaccess
            .index.php
        /fr
            .htaccess
            .index.php
        /install
        /system
        /themes
            .htaccess
            favicon.co
            index.php
            lincense.txt
            README.md
            
To add a new language to your website, create a new directory in CMS Canvas's root directory and give it the name of the language code (ex: fr). Copy the index.php and the .htaccess from the CMS Canvas's root directory and paste it into this new directory.

.. note::: In this example we will be adding French (fr).

Open the ``.htaccess`` in the ``"fr"`` directory and change:

From:

.. code-block:: php 
    
    RewriteBase /

To:

.. code-block:: php 

    RewriteBase /fr/

Save your changes and now open the index.php inside the "fr" directory.

Change the following lines:

From:

.. code-block:: php 

    $system_path = 'system';

To

.. code-block:: php 

    $system_path = '../system';

From:

.. code-block:: php 
    
    $application_folder = 'application';

To:

.. code-block:: php 

    $application_folder = '../application';

From:

.. code-block:: php 

    $assign_to_config['global_tags']['lang'] = 'en';

To:

.. code-block:: php 

    $assign_to_config['base_url'] = dirname(BASE_URL) . '/';
    $assign_to_config['site_url'] = BASE_URL;
    $assign_to_config['global_tags']['lang'] = 'fr';

Content Setup

Next you will want to create a content field for each language translation starting with the language code.

Then in your content type simply reference your field with the following tag syntax:

.. code-block:: php 

    {{ {{ lang }}_title }}

Now when you visit your website with the following URL at "http://example.com/fr/" you will see your French translations and now all navigational page links will automatically now point to "http://example.com/fr/some-page".

Navigations
###########

Currently the best way to translate navigations is to create a new navigation tree for the translation. Then you can use a tag conditional to determine which navigation to load.

.. code-block:: php 

    {{ if lang == 'fr' }}
        {{ navigations:nav nav_id="2" }}
    {{ else }}
        {{ navigations:nav nav_id="1" }}
    {{ endif }}

