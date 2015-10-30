
Nav Tag
=======

Generates and outputs a navigational list of links.

.. code-block:: php 

    {{ navigations:nav nav_id="12" }}

By default the single {{ navigations:nav }} tag will return your links as an unordered list with the following html formatting:

.. code-block:: php 

    <ul>
        <li class="first"><a href="http://somedomain.com/link1">Link 1</a></li>
        <li class="current_trail"><a href="http://somedomain.com/link2">Link 2</a>
            <ul>
                <li class="first current current_trail">
                    <a href="http://somedomain.com/sublink-link1">Sub Link 1</a>
                </li>
            </ul>
        </li>
        <li class="last"><a href="http://somedomain.com/link3">Link 3</a></li>
    </ul>

.. note:: The current page's list item will be marked with a class of "current" and any parent list item will be marked with a class of "current_trail"

Tag Block
#########

To be much more flexible you can use the nav tag as a tag block and define your own custom formatting.

.. code-block:: php 

    {{ navigations:nav nav_id="12" backspace="34" nested="false" }}
      <span><a href="{{ url }}" target="{{ target}}">{{ title }}</a></span> <span class="delimiter">|</span>
    {{ /navigations:nav }}

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

    backspace=
    class=
    disable_current=
    id=
    max_depth=
    nav_id= *Required
    nested=
    start_nav_from_parent_depth=
    start_nav_on_level_of_current=
    start_nav_with_kids_of_current=
    start_node=
    start_x_levels_above_current=
    subnav_visiblity=

backspace=
**********

The number of characters to remove from the end of the content on the last iteration. This is used to trim unwanted formatting such as a comma or a line break on the last navigation item.

backspace="2"

Example:
--------

.. code-block:: php 

    {{ navigations:nav nav_id="12" backspace="2" nested="false" }}
        {{ title }},
    {{ /navigations:nav }}

Output:
Home, Page Not Found, About Us

.. note:: In this example the backspace is 2 because we trimmed a space and a comma. In order for there to be no space after the comma and be able to use a backspace of 1 there whould have to be no whitespace between the comma and the closing {{ /navigations:nav }} tag.

class=

Allows you to add a class name to the navigation's parent unordered list tag (ex: <ul class="my_class">).

class="my_class"

.. note:: The nested parameter must not be disabled for this parameter to work.

disable_current=

Setting this to true will disable adding current and current_trail classes to navigation items. Enabling this parameter will decrease navigation processing times on large navigations.

disable_current="true"

id=

Allows you to add a id to the navigation's parent unordered list tag (ex: <ul id="my_id">).

id="my_id"

.. note:: The nested parameter must not be disabled for this parameter to work.
max_depth=

The depth at which to stop outputting navigation links. For example a max depth of 1 would ouput only the root level of the navigation with no children. A max depth of 2 would output the root level and the first level of children.

max_depth="2"

nav_id= *Required

The #ID of the navigation of which to output.

nav_id="15"

nested=

By default navigation items are nested in an unordered list. This can be disabled by setting the nested parameter to false.

nested="false"

start_nav_from_parent_depth=

Returns a navigation subset at the specified depth starting from the root parent of the current nav item.

start_nav_from_parent_depth="2"

Take the following navigation tree for example:

.. code-block:: php 

    -Home
    -Page 1
        -Sub Page 1 (Current Page)
            -Sub Sub Page 1
        -Sub Page 2
    -Page 2
        -Sub Page 1

A parent depth of 1 would return the tree as is, however, a parent depth of 2 would return:

.. code-block:: php 

    -Sub Page 1
        -Sub Sub Page 1
    -Sub Page 2

start_nav_on_level_of_current=

Returns a navigation subset starting at the depth that the current page and it's siblings reside in the navigation.

start_nav_on_level_of_current="true"

start_nav_with_kids_of_current=

Returns a navigation subset starting with the children of the current page.

start_nav_with_kids_of_current="true"

start_node=

Returns a navigation subset starting at the depth of the specified navigation id and its siblings reside.

start_node="15"

start_x_levels_above_current=

This parameter functions similiar to start_nav_from_parent_depth only rather than starting from the top parent and counting down, this parameter starts at the current depth and counts ups.

start_x_levels_above_current="2"

subnav_visiblity=

Sets the visibility of sub-navigations. There are 3 options available. By default the setting is set as show.

subnav_visibility="hide"    subnav_visibility="current_trail"    subnav_visibility="show"

    hide - Doesn't show any sub-navigations
    current_trail - Only shows sub-navigations that are in the current trail
    show - Shows all sub-navigations (Default)
