<?


class Service_User
{
	public function addUser($data)
	{
		$userModel = new Model_User($data);
		
		$userModel->setRegdate(date('Y-m-d H:i:s', time()));

		return $userModel->save();
	}
	
	public function getAll()
	{
		$userModel = new Model_User();

		return $userModel->getAll();
	}

	public function login($login, $password)
	{
		$auth  = Zend_Auth::getInstance();

		(new Zend_Session_Namespace('Zend_Auth'))->setExpirationSeconds(60*60*2);

		if (!$auth->authenticate(
			(new Zend_Auth_Adapter_DbTable(
				(new Model_DbTable_User())->getAdapter()
			))->setTableName('users')
				->setIdentityColumn('login')->setCredentialColumn('password')
				->setIdentity($login)->setCredential(md5($password))
		)) {
			return false;
		}

		$this->updateUserActivity($login);

		return true;
	}
	
	public function isLogined()
	{
		return Zend_Auth::getInstance()->getIdentity();
	}

	public function updateUserActivity($user)
	{
		$userModel = ($user instanceof Model_User) ? $user
			: (new Model_User())->findByLogin($user);

		if (is_null($userModel)) {
			return false;
		}

		$userModel->setActivitytime(time())->save();

		return true;
	}

	public function logout()
	{
		return Zend_Auth::getInstance()->clearIdentity();
	}
}