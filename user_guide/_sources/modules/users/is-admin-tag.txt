Usage

Intended to be used in a conditional statement. Returns true if the current user is an administrative user.

{{ if users:is_admin }}
    <div>You are an admin!</div>
{{ else }}
    <div>You are NOT an admin :(</div>
{{ endif }}