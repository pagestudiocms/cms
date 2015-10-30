   
Contact Plugin Form Tag
=======================

Usage
#####

Builds and processes a simple contact form that when submitted is emailed to the notification email specified in the general settings of the CMS.

.. code-block:: php
    
    {{ contact:form required="name|email|phone|message" }}

By default the single {{ contact:form }} tag will return a simple form with the following fields:

- Name
- Email
- Phone
- Message
- Captcha Image (Captcha parameter required)
- Captcha Input (Captcha parameter required)

Tag Block
#########

To be much more flexible you can use the form tag as a tag block and define your own contact form with any kind of formatting you would like.

.. code-block:: php

    {{ contact:form required="first_name|last_name|email" captcha="true" }}
        <div>
            <label for="first_name">First Name:</label>
            <input id="first_name" name="first_name" />
        </div>
        <div>
            <label for="last_name">Last Name:</label>
            <input id="last_name" name="last_name" />
        </div>
        <div>
            <label for="email">Email:</label>
            <input id="email" name="email" />
        </div>
        <div>
            Please enter the characters below:<br />
            {{ captcha }}<br />
            {{ captcha_input }}
        </div>
        <div>
            <input type="submit" value="Send" />
        </div>
    {{ /contact:form }}

.. note:: The html <form> tags will automatically be added upon rendering.

Parameters
##########

.. contents::
   :local:
   :depth: 2

anchor=
-------

Anchors to a specific location on the page to go to after the form has been submitted. Can reference an anchor tag or an id located on the page. This is useful if your form is located at the bottom of the page.

anchor="#myform"

captcha=
--------

When this parameter is set to "true" it will enable a captcha image and input that will then be required to submit the form.

captcha="true"

.. important:: When using the tag block format you must include {{ captcha }} and {{ captcha_input }} in the block content.
class=
------

Adds the provided class name to the <form> tag.

class="my_class"

from=
-----

The from email address to be used in the from address of the email. If no from address is specified the from address will be noreply@your-top-level-domain.com

from="noreply@example.com"

from_name=
----------

The from name to be used along with the from email address of the emai sent. If no from name is specified the site name defined in general settings will be used.

from="My Website"

id=
---

Adds the provided id name to the <form> tag.

id="my_id"

required=
---------

Forces users to fill in the specified fields before the form can be submitted. Use the field names sperated by a "|". If a user fails to fill in a specified field the form will be repopulated with POST data with a notification message stating the fields that are required.

required="field_name1|field_name2"

subject=
--------

The subject to be used for the email sent. If no subject is specified the subject will be "Contact Form Submission".

subject="New Contact Form Submission"

success_redirect=
-----------------

This will redirect the browser to a specified page upon a successful form submission.

success_redirect="/my-thank-you-page"

to=
---

The to email address to send the emails to. If no to email address is specified emails will be sent to the notification email address set in general settings.

to="someaddress@example.com"

Spam Prevention
###############

To help prevent bots from spamming an additional input field is added to your form that is hidden using CSS. The theory is that majority of bots do not render CSS and will attempt to auto fill the hidden field. When the form is processed it will check to ensure this field is empty before sending the email. If you need additional spam protection see the captcha parameter.

.. toctree::
   :maxdepth: 2