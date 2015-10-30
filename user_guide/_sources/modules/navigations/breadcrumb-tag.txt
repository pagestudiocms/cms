
Breadcrumb Tag
==============

Generates and outputs a breadcrumb list of links.

.. code-block:: php 

    {{ navigations:breadcrumb nav_id="12" }}

By default the single ``{{ navigations:breadcrumb }}`` tag will return your links as an unordered list with the following html formatting:

.. code-block:: php 

    <ul>
        <li class="first"><a href="http://somedomain.com/link1">Link 1</a></li>
        <li><a target="_blank" href="http://somedomain.com/link2">Link 2</a></li>
        <li class="current last"><a href="http://somedomain.com/link3">Link 3</a></li>
    </ul>

.. note:: The current page's list item will be marked with a class of "current". It will also always be the last item.

Tag Block
#########

To be much more flexible you can use the breadcrumb tag as a tag block and define your own custom formatting inside the <li> tags.

.. code-block:: php 

    {{ navigations:breadcrumb nav_id="12" }}
      <span><a href="{{ url }}" target="{{ target}}">{{ title }}</a></span> <span class="delimiter">|</span>
    {{ /navigations:breadcrumb }}

When using the tag block the following tags are available for use in the content:

.. code-block:: php 

    {{ class }}  = Outputs the defined class for the current link
    {{ id }}       = Outputs the defined id for the current link
    {{ path }}   = Outputs the full URL for the current link
    {{ target }} = Outputs the target for the current link (ex: _blank)
    {{ title }}    = Outputs the title for the current link
    {{ url }}      = An alias of {{ path }}

Parameters
##########

``class=``

``hide_single=``

``id=``

``include_home=``

``nav_id= *Required``

**class=**

Allows you to add a class name to the breadcrumbs's parent unordered list tag (ex: <ul class="my_class">).

class="my_class"

hide_single=

If only one crumb is found and this parameter is set to true it will not show the crumb on the page.

hide_single="true"

**id=**

Allows you to add a id to the breadcrumbs's parent unordered list tag (ex: <ul id="my_id">).

id="my_id"

**include_home=**

Adds a link to the homepage to the beginning of the crumbs if include_home is set to true.

include_home="true"

**nav_id= *Required**

The #ID of the navigation of which to output.

nav_id="15"
