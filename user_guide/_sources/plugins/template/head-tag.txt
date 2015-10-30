
Head Tag
==========

Outputs the contents of the ``Metadata Tag``, ``Stylesheets Tag``, ``Javascripts Tag``, ``Page Head Tag``, and ``Analytics Tag`` in that order without the need to call each tag individually. Place this tag between the ``<head>`` ``</head>`` tags of your theme.

.. code-block:: php 

    {{ template:head }}

.. note:: Do not use **Metadata Tag**, **Stylesheets Tag**, **Javascripts Tag**, **Page Head Tag**, or **Analytics Tag** when using this tag as it already outputs the data from each of these.