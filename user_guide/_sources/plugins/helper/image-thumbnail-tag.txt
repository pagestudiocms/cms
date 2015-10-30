
Image Thumbnail Tag
===================

Generates and caches a proportional resized thumbnail of the provided image. Tag returns the path of the cached thumbnail.

.. code-block:: php 

    {{ helper:image_thumb image="path/to/image.jpg" width="100" height="100" }}
    
You can also pass a template tag variable to the ``image_thumb`` template tag. 

.. code-block:: php 

    {{ path_to_image }}
    
    {{ helper:image_thumb image=path_to_image width="100" height="100" }}
    
.. note:: When passing a template tag do not use quotes ("") or the thumbnail functon will interpret it as a litteral string.

Parameters
##########

``image= *Required``

``width=``

``height=``

``crop=``

image=
******

Specifies the path of the source image in which the thumbnail will be generated from.

.. code-block:: php 
    
    image="path/to/image.jpg"

width=
******

The max width the generated thumbnail can be.

.. code-block:: php 
    
    width="250"

height=
*******

The max height the generated thumbnail can be.

.. code-block:: php 
    
    height="250"

crop=
*****

If set to "true" the image will be cropped from the center of the image to the provided width and height.

.. code-block:: php 
    
    crop="true"