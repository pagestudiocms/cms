
Add Javascript Tag
==================

Used to build an array of javascript includes. The final array can then be included into your theme by using the Javascripts Tag.

.. code-block:: php 

    {{ template:add_javascript file="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" }}

Parameters
##########

``file= *Required``

file= *Required
***************

The URL of the javascript library to include. Paths not starting with http:// will be relative to the current sites base URL.

.. code-block:: php 

    file="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"