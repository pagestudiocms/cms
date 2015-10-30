.. PageStudio documentation master file, created by
   sphinx-quickstart on Thu Sep 24 10:28:06 2015.
   You can adapt this file completely to your liking, but it should at least
   contain the root `toctree` directive.

Calendar Plugin Tag
======================================

Generates a 30 day calendar or a list of upcoming events on pages where embeded.

30 Day Calendar
###############

Allows you to display a 30-day calendar on your website. This tag is inserted in your template.

+---------------+--------------------------------------------------------------------------+
| Parameter     | Description                                                              | 
+===============+==========================================================================+
| status=       | Specifies the status of the events to be displayed. Options published,   | 
|               | draft. **Not required.**                                                 |
+---------------+--------------------------------------------------------------------------+
| segment=      | The URL segment and page name to match against with the `|` as the       | 
|               | delimeter.                                                               |
|               | Example: segment="2|calendar" **Not Required.**                          |
+---------------+--------------------------------------------------------------------------+

.. code-block:: php

    {{ calendar:month status="published" segment="1|calendar" }}
    
.. note:: When the optional parameter **segment** is not set, the tag returns the 30-day calendar on any page that uses the template it's embeded into.


Calendar Event Listing
######################

Allows you to display a set of events from the calendar table. Use this when you want to embed a listing of events in a section of your template.

Optional Parameters
-------------------

+---------------+--------------------------------------------------------------------------+
| Parameter     | Description                                                              | 
+===============+==========================================================================+
| status=       | Specifies the status of the events to be displayed. Options              |
|               | published, draft.                                                        |
+---------------+--------------------------------------------------------------------------+
| segment=      | The URL segment and page name to match against with the | as the         | 
|               | delimeter.                                                               |
|               | When not set the system shows the results on any page the tag is embeded.| 
|               | Example: segment="2|calendar" **Not Required.**                          |
+---------------+--------------------------------------------------------------------------+
| sort=         | Let's you define the sort order of the result set. Options are asc,      |
|               | or desc, default is asc.                                                 |
+---------------+--------------------------------------------------------------------------+
| limit=        | Sets the limit of the number of events to be displayed.                  |
+---------------+--------------------------------------------------------------------------+

Example Without Optional Parameters

.. code-block:: php

    {{ calendar:events }}
        <a href="{{ url }}">{{ title }}</a>
    {{ /calendar:events }}

Example With Optional Parameters

.. code-block:: php

    {{ calendar:events segment="1|calendar" status="published" sort="desc" limit="5" }}
        <a href="{{ url }}">{{ title }}</a>
    {{ /calendar:events }}

The above example will only display on pages where segment [ 1 ] is [ calendar ]. It will not be displayed on any other page.

.. toctree::
   :maxdepth: 2