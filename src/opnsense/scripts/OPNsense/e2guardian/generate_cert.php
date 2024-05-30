#!/usr/local/bin/php
<?php





require_once("config.inc");
require_once("certs.inc");

use OPNsense\Core\Config;



if (is_file('/usr/local/etc/e2guardian/ca.pem.id')) {
    $cert_refid = trim(file_get_contents('/usr/local/etc/e2guardian/ca.pem.id'));
    if (!empty($config['ca'])) {
        foreach ($config['ca'] as $ca) {
            if (isset($ca['refid']) && $ca['refid'] == $cert_refid) {
                $ca_key = '';
                $ca_key .= trim(base64_decode($ca['prv'])) . "\n";
                $ca_pem = '';
                $ca_pem .= trim(base64_decode($ca['crt'])) . "\n";
                echo "certificate generated\n";
                file_put_contents('/usr/local/etc/e2guardian/ca.key', $ca_key);
                file_put_contents('/usr/local/etc/e2guardian/ca.pem', $ca_pem);
            }
        }
    }
}
if (is_file('/usr/local/etc/e2guardian/private.pem.id')) {
    $cert_refid = trim(file_get_contents('/usr/local/etc/e2guardian/private.pem.id'));
    if (!empty($config['cert'])) {
        foreach ($config['cert'] as $cert) {
            if (isset($cert['refid']) && $cert['refid'] == $cert_refid) {
                $cert_key = '';
                $cert_key .= trim(base64_decode($cert['prv'])) . "\n";
                $cert_pem = '';
                $cert_pem .= trim(base64_decode($cert['crt'])) . "\n";
                echo "certificate generated\n";
                file_put_contents('/usr/local/etc/e2guardian/private.key', $cert_key);
                file_put_contents('/usr/local/etc/e2guardian/private.pem', $cert_pem);
            }
        }
    }
}
