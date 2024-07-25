# e2guardian plugin for OPNsense

The e2guardian plugin for OPNsense is designed to provide advanced web content filtering.

The plugin supports various lists for blocking or allowing sites, URLs, IP addresses, phrases, file extentions, MIME types and regular expressions.

## Plugin features:

1. Content scanner which includes Clamav scanning.
2. HTTPS transparent filtering
3. ICAP server mode
4. Upstream proxy
5. Multiple filter configurations to provide varying degrees of web filtering to different groups of users
6. IP authentication support
7. Port authentication support
8. Whitelist domains and urls
9. Blacklist domains and urls
10. Deny regular Expressions on urls and body content
11. URL regular expression replacement so you can for example force safe search in search engines
12. Deep URL scanning to spot URLs in URLs to for example block images in Google images

To use the e2guardian plugin, you need to build e2guardian version 5.5 from ports, applying the provided patch from this project to the 5.3 port version.


## e2guardian v5.5.5r Install
```
opnsense-code tools ports

cd /usr/ports/www

curl https://raw.githubusercontent.com/Gunior80/E2G-OPNsense/master/e2guardian.patch --output ./e2guardian.patch

patch -t -p0 < e2guardian.patch

cd ./e2guardian

make deps-recursive

make install
```

# Plugin Install
```
git clone https://github.com/Gunior80/E2G-OPNsense

cp -R ./E2G-OPNsense/src/* /usr/local/
```
Finally, you need to restart OPNsense services.