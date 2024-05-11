<?php



namespace OPNsense\e2guardian\Api;

use OPNsense\Base\ApiMutableServiceControllerBase;

class ServiceController extends ApiMutableServiceControllerBase
{
    protected static $internalServiceClass = '\OPNsense\e2guardian\General';
    protected static $internalServiceTemplate = 'OPNsense/e2guardian';
    protected static $internalServiceEnabled = 'enabled';
    protected static $internalServiceName = 'e2guardian';

}
