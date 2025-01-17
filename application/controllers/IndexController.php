<?


class IndexController extends Zend_Controller_Action
{
	function init()
	{
		//$this->view->layout()->setLayout('layout2');
		//Zend_Layout::getMvcInstance()->setLayout('layout');
		
	}
	
    function indexAction()
    {
		$userService = new Service_User();
		$form = new Form_Login();
		
		if ($this->getRequest()->isPost()) {
			
			$data = $this->getRequest()->getPost();
			
			if ($form->isValid($data)) {
				if ($userService->login($data['nickname'], $data['password'])) {
					$this->_redirect('/online');
				} else {
					$this->view->errors = array('Incorrect login/password validation');
				}
			} else {
				$this->view->errors = $form->getMessages();
			}

			$form->populate($data);
			
		}

		$this->view->form = $form;

		$this->view->users = $userService->getAll();
    }
	
	function addAction()
    {
    }
	
	function registrationAction()
	{
		$form = new Form_User();
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				$userService = new Service_User();
				$userService->addUser(array(
					'login' => $formData['nickname'],
					'name' => $formData['name'],
					'city' => $formData['city'],
					'birthday' => date('Y-m-d', strtotime($formData['birthday'])),
					'password' => md5($formData['password']),
					'race' => $formData['race']
				));
				$this->_helper->redirector('index');
			} else {
				$form->populate($formData);
			}
		}

		$this->view->form = $form;
	}

	public function logoutAction()
	{
		$userService = new Service_User();

		if ($userService->isLogined()) {
			$userService->logout();
		}

		$this->_helper->redirector('index');
	}
}