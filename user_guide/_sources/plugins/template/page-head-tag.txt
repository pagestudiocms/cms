
Page Head Tag
=============

Outputs any custom JavaScript, CSS, Meta information, and/or PHP that needs to be in the ``<head>`` block of the theme template. Place this tag in between the ``<head>`` ``</head>`` tags of your theme.

.. code-block:: php 

        {{ template:page_head }}

.. note:: You do not need to use this tag if you are using the **Head Tag**, as this is included in its output.