<?php



namespace OPNsense\e2guardian\Api;

use OPNsense\Core\Backend;
use OPNsense\Base\ApiMutableServiceControllerBase;

class ServiceController extends ApiMutableServiceControllerBase
{
    protected static $internalServiceClass = '\OPNsense\e2guardian\General';
    protected static $internalServiceTemplate = 'OPNsense/e2guardian';
    protected static $internalServiceEnabled = 'enabled';
    protected static $internalServiceName = 'e2guardian';

    /**
     * @return array
     */
    public function reconfigureAction()
    {
        if (!$this->request->isPost()) {
            return ['result' => 'failed'];
        }

        $this->sessionClose();
        $backend = new Backend();
        $backend->configdRun('template cleanup ' . escapeshellarg(static::$internalServiceTemplate));
        $backend->configdRun('template reload ' . escapeshellarg(static::$internalServiceTemplate));

        return ['result' => 'ok'];
    }


}
