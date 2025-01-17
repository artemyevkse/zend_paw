<?


class OnlineController extends Zend_Controller_Action
{
	protected $_login = null;
	
	
	public function preDispatch()
	{
		$userService = new Service_User();
		$login = $userService->isLogined();
		
		if (!$login) {
			$this->_redirect('/');
		}
		
		$this->_login = $login;
	}

	public function indexAction()
	{
		$userService = new Service_User();
		
		$userService->updateUserActivity($this->_login);

		$this->view->layout()->disableLayout();
	}
	
	public function innerAction()
	{
		$this->view->login = $this->_login;
	}
	
	public function locationAction()
	{
		$userService = new Service_User();
		
		$this->view->users = $userService->getAll();
	}
}