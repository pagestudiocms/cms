
Add Stylesheet Tag
==================

Used to build an array of stylesheet includes. The final array can then be included into your theme by using the Stylesheets Tag.

.. code-block:: php 
    
    {{ template:add_stylesheet file="http://somedomain.com/css/main.css" }}

Parameters
##########

``file= *Required``

file=
*****

The URL of the stylesheet to include. Paths not starting with ``http://`` will be relative to the current sites base URL.

.. code-block:: php 

    file="http://somedomain.com/css/main.css"