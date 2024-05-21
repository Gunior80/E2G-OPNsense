<?php



namespace OPNsense\e2guardian\FieldTypes;

use OPNsense\Base\FieldTypes\PortField;
use OPNsense\Firewall\Alias;
class CustomPortField extends PortField
{
    private static $wellknownservices = [
        'cvsup',
        'domain',
        'ftp',
        'hbci',
        'http',
        'https',
        'aol',
        'auth',
        'imap',
        'imaps',
        'ipsec-msft',
        'isakmp',
        'l2f',
        'ldap',
        'ms-streaming',
        'afs3-fileserver',
        'microsoft-ds',
        'ms-wbt-server',
        'wins',
        'msnp',
        'nntp',
        'ntp',
        'netbios-dgm',
        'netbios-ns',
        'netbios-ssn',
        'openvpn',
        'pop3',
        'pop3s',
        'pptp',
        'radius',
        'radius-acct',
        'avt-profile-1',
        'sip',
        'smtp',
        'igmpv3lite',
        'urd',
        'snmp',
        'snmptrap',
        'ssh',
        'nat-stun-port',
        'submission',
        'teredo',
        'telnet',
        'tftp',
        'rfb'
    ];

    /**
     * @var array cached collected ports
     */
    private static $internalCacheOptionList = [];
    private $enableWellKnown = false;
    private $enableAlias = false;

    protected function actionPostLoadingEvent()
    {
        $setid = $this->enableWellKnown ? "1" : "0";
        $setid .= $this->enableAlias ? "1" : "0";
        if (empty(self::$internalCacheOptionList[$setid])) {
            self::$internalCacheOptionList[$setid] = [];
            if ($this->enableWellKnown) {
                foreach (["any"] + self::$wellknownservices as $wellknown) {
                    self::$internalCacheOptionList[$setid][(string)$wellknown] = $wellknown;
                }
            }
            if ($this->enableAlias) {
                foreach ((new Alias())->aliases->alias->iterateItems() as $alias) {
                    if (strpos((string)$alias->type, "port") !== false) {
                        self::$internalCacheOptionList[$setid][(string)$alias->name] = (string)$alias->name;
                    }
                }
            }
            for ($port = 1000; $port <= 9000; $port++) {
                self::$internalCacheOptionList[$setid][(string)$port] = (string)$port;
            }
        }
        $this->internalOptionList = self::$internalCacheOptionList[$setid];
    }
}
