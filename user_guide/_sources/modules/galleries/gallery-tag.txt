
Gallery Tag
===========

This tag block allows you to output and format a gallery's images.

.. code-block:: php 
    
    {{ galleries:gallery gallery_id="1" }}    
        <div>
            <img src="{{ helper:image_thumb image=image width="150" height="150" crop="true" }}" alt="{{ alt }}" />
            <h3>{{ title }}</h3>
            {{ description }}
        </div>
    {{ /galleries:gallery }}

The following tags are available for use in the tag block's content.

.. code-block:: php 

    {{ alt }} = Outputs alternative text defined for the image. Intended for use in the <img> alt attribute.
    {{ description }} = Outputs the description that was defined for the image.
    {{ image }} = Outputs the full url for the current image. (Note: Optional parameters are available for thie tag.)
    {{ title }} = Outputs the title that was defined for the current image.

Parameters
##########

``gallery_id= *Required`` The id of the gallery you would like to render and output. 

Example
*******

Using the glallery module to render a slideshow.

.. note:: You can use the **gallery_exists** function to check if a given gallery exists before displaying any HTML to the screen. 

.. code-block:: php 
    
    {{ if {galleries:gallery_exists gallery_id=slideshow} }}
        <!-- flexSlider -->
        <div class="flexslider">
            <ul class="slides">
                {{ galleries:gallery gallery_id=slideshow }}
                <li>
                    <img src="{{ helper:image_thumb image=image crop="false"}}" alt="{{ alt }}" />
                </li>
                {{ /galleries:gallery }}
            </ul>
        </div>
    {{ endif }}

Alter native option to validate if a slideshow exists. 
    
.. code-block:: php 

    {{ if slideshow }}
        <!-- flexSlider -->
        <div class="flexslider">
            <ul class="slides">
                {{ galleries:gallery gallery_id=slideshow }}
                <li>
                    <img src="{{ helper:image_thumb image=image crop="false"}}" alt="{{ alt }}" />
                </li>
                {{ /galleries:gallery }}
            </ul>
        </div>
    {{ endif }}
    
.. note:: **slideshow** is the name of your gallery content_type field name.

.. code-block:: php 

    gallery_id="2"