
Snippets Tag
============

Provides reusable code and/or content bits that can be used in content types, entries, and themes. Snippets are very powerful in that they inherit content tags from its parent and offers the ability to rename the inherited tags.

.. code-block:: php 

    {{ content:snippets snippet="short_name" my_snippet_title="title" }}

Parameters
##########

``snippet= *Required``

``Dynamic Parameters``

snippet= *Required

The short name of the code snippet to output.

Dynamic Parameters
******************

With the dynamic parameters you can define or rename tags that can then be used in the code snippet.

Example
*******

.. code-block:: php 

    {{ content:snippets snippet="my_snippet" my_snippet_title="title" }}

The above example returns the snippet "short_name" and renames the parent ``{{ title }}`` tag to ``{{ my_snippet_title }}``. The ``{{ my_snippet_title }}`` tag can then be used anywhere in the snippet code.

You can also use dynamic parameters to assign strings to a tag:

.. code-block:: php 
    
    {{ content:snippets snippet="my_snippet" my_snippet_title="title" sub_heading="My Subheading" }}

Occasionally you might have a scenario where you want to assign a string but there is a parent tag with the same name. You can specify that it is a literal by wrapping it in single quotes:

.. code-block:: php 

    {{ content:snippets snippet="my_snippet" my_snippet_title="'title'" }}