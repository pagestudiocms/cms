.. PageStudio documentation master file, created by
   sphinx-quickstart on Thu Sep 24 10:28:06 2015.
   You can adapt this file completely to your liking, but it should at least
   contain the root `toctree` directive.

Documentation Style Guide
======================================

This is my first line documentation

Heading h1
==========

Heading h2
##########

Heading h3
**********

Heading h4
----------

Bullet list

-  Item 1
  -  Item 2

::

	<?php
	class News_model extends CI_Model {

		public function __construct()
		{
			$this->load->database();
		}
	}
    
.. code-block:: http

	<html></html>

    {
      "status": "ok", 
      "extended": true,
      "results": [
        {"value": 0, "type": "int64"},
        {"value": 1.0e+3, "type": "decimal"}
      ]
    }
    
.. code-block:: php
    
	<?php
	class News_model extends CI_Model {

		public function __construct()
		{
			$this->load->database();
		}
	}

**bold-text** approach::

	example.com/news/article/my_article

.. note:: Query string URLs can be optionally enabled, as described
	below.
    
.. important:: Do not use leading/trailing slashes.

.. toctree::
   :maxdepth: 2
