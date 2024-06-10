{% if helpers.exists('OPNsense.e2guardian.general.enabled') and OPNsense.e2guardian.general.enabled == '1' %}
e2guardian_setup="sh /usr/local/opnsense/scripts/OPNsense/e2guardian/setup.sh"
e2guardian_enable="YES"
{% else %}
e2guardian_enable="NO"
{% endif %}