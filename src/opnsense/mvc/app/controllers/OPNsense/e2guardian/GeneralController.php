<?php



namespace OPNsense\e2guardian;

class GeneralController extends \OPNsense\Base\IndexController
{
    public function indexAction()
    {
        $this->view->generalForm = $this->getForm('general');
        $this->view->formDialogEditE2guardianGroup = $this->getForm("dialogEditE2guardianGroup");
        $this->view->pick('OPNsense/e2guardian/general');
    }
}
