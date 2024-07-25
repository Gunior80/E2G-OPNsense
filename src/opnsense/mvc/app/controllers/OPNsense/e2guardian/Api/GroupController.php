<?php



namespace OPNsense\e2guardian\Api;

use OPNsense\Base\ApiMutableModelControllerBase;

class GroupController extends ApiMutableModelControllerBase
{
    protected static $internalModelName = 'group';
    protected static $internalModelClass = '\OPNsense\e2guardian\Group';

    public function searchGroupAction()
    {
        $search = $this->searchBase( 'groups.group', array("enabled", "instance", "groupname"));
        return $search;
    }
    public function getGroupAction($uuid = null, $listType = null)
    {
        return $this->getBase('group', 'groups.group', $uuid);
    }
    public function addGroupAction($uuid = null)
    {
        return $this->addBase('group', 'groups.group', $uuid);
    }
    public function delGroupAction($uuid)
    {
        return $this->delBase('groups.group', $uuid);
    }
    public function setGroupAction($uuid = null)
    {
        return $this->setBase('group', 'groups.group', $uuid);
    }
    public function toggleGroupAction($uuid)
    {
        return $this->toggleBase('groups.group', $uuid);
    }
}
