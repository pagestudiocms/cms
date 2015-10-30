
Site URL Tag
============

Returns your site's full URL with additional path segments appended to the end if provided.

.. code-block:: php 

    {{ helper:site_url path="path/to/page" }}

Parameters
##########

``path=``

**path=**

Specifies segments to be appended to the end of the of the site's base URL.

.. code-block:: php 
    
    path="path/to/page"