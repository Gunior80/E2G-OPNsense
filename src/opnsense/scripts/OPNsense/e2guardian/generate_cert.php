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
                $pem_contents = '';
                $pem_contents .= trim(base64_decode($ca['prv'])) . "\n";
                $pem_contents .= trim(base64_decode($ca['crt'])) . "\n";
                $pem_contents .= ca_chain($ca);
                echo "certificate generated\n";
                file_put_contents('/usr/local/etc/e2guardian/ca.pem', $pem_contents);
            }
        }
    }
}
