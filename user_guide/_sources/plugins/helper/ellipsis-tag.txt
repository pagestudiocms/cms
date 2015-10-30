
Ellipsis Tag
============

Strips tags from a string and splits it at a specified maximum length before inserting a ellipsis.

.. code-block:: php 

    {{ helper:ellipsis length="25" }}
        Some really long random content that needs to be much shorter to fit. 
    {{ /helper:ellipsis }}

The ellipsis tag can be used to shorten the content found within template tags.
    
.. code-block:: php 

    {{ helper:ellipsis length="200" words="true" }}
        {{ content }}
    {{ /helper:ellipsis }}
    
.. note:: This will strip any HTML tags as to be sure not to leave any orphan tags.

Parameters
##########

``length= *Require``

``words=``

length= 
*******

The maximum number of characters to be returned before splitting the string and inserting an ellipsis.

.. code-block:: php 

    length="10"
    
words=
******
    
Specifies whether or not to split words or keep whole

.. code-block:: php 

    words="true"