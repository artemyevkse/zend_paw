<?


class ChatController extends Zend_Controller_Action
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
		$this->view->layout()->disableLayout();
		
		$chatService = new Service_Chat();
		
		$this->view->chat = $chatService->getAll();
	}
}