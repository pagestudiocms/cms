
Set Layout Tag
==============

This tag can be used change the content type's theme layout. Theme layouts are located in the layouts directory of the current theme's directory (/themes/theme_name/views/layouts).

.. code-block:: php 

    {{ template:set_layout layout="layout_filename" }}

.. note:: This tag will not work in theme files because the layout will already already been selected.

Parameters
##########

``layout= *Required``

layout=
*******

The filename without the extension of the layout to load.

.. code-block:: php 

    file="layout_filename"