#!/bin/sh

E2G_DIRS="/var/log/e2guardian /usr/local/etc/e2guardian/generatedcerts"

for E2G_DIR in ${E2G_DIRS}; do
    mkdir -p ${E2G_DIR}
    chown -R clamav:clamav ${E2G_DIR}
    chmod -R 750 ${E2G_DIR}
done



/usr/local/opnsense/scripts/OPNsense/e2guardian/generate_cert.php > /dev/null 2>&1