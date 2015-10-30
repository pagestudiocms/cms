
Is Auth Tag
===========

Intended to be used in a conditional statement. Returns true if the current user is logged in and false otherwise.

.. code-block:: php 

    {{ if secure:is_auth }}
        <div>Logged In</div>
    {{ else }}
        <div>Logged Out</div>
    {{ endif }}