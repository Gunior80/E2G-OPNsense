{% if helpers.exists('OPNsense.e2guardian.general.enabled') and OPNsense.e2guardian.general.enabled == '1' %}
e2guardian_enable="YES"
{% else %}
e2guardian_enable="NO"
{% endif %}