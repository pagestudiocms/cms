
Date Format Tag
===============

Formats and outputs a local time/date based on the format given. If no date parameter is provided it will format the current date/time. For a full list of available formatting options visit PHP date function.

.. code-block:: php 

    {{ helper:date format="m/d/Y" date="2012-01-25" }}

Parameters
########## 

``format= *Required``

``date=``

format= 
*******

Specifies the format of the date/time to be outputted. For a full list of available formatting options visit PHP's date function.

.. code-block:: php 
    
    format="F j, Y h:i:s a"

date=
*****

The date/time to be formatted. If no date/time is specified the server's current date/time will be used.

.. code-block:: php 
    
    date="2012-01-25"

.. note:: The provided date is converted to a UNIX timestamp before formatting using PHP's strtotime function.