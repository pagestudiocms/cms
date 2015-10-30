Usage

Intended to be used in a conditional statement. Returns true if the current user is logged in and false otherwise.

{{ if users:is_logged_in }}
    <div>Logged In</div>
{{ else }}
    <div>Logged Out</div>
{{ endif }}