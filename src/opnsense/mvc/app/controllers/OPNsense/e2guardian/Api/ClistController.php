<?php



namespace OPNsense\e2guardian\Api;

use OPNsense\Base\ApiMutableModelControllerBase;

class ClistController extends ApiMutableModelControllerBase
{
    protected static $internalModelName = 'clist';
    protected static $internalModelClass = '\OPNsense\e2guardian\Clist';

    public function searchClistAction()
    {
        $search = $this->searchBase( 'clists.clist', array("enabled", "listtype", "listname"));
        return $search;
    }
    public function getClistAction($uuid = null)
    {
        return $this->getBase('clist', 'clists.clist', $uuid);
    }
    public function addClistAction($uuid = null)
    {
        return $this->addBase('clist', 'clists.clist', $uuid);
    }
    public function delClistAction($uuid)
    {
        return $this->delBase('clists.clist', $uuid);
    }
    public function setClistAction($uuid = null)
    {
        return $this->setBase('clist', 'clists.clist', $uuid);
    }
    public function toggleClistAction($uuid)
    {
        return $this->toggleBase('clists.clist', $uuid);
    }
}
