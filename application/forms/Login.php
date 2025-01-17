<?


class Form_Login extends In2it_Form
{
	public function __construct($options = null) 
	{
		parent::__construct($options);
		
		$nickName = $this->createElement('text', 'nickname')
			->setLabel('Nickname')
			->setRequired(true)
			->addFilters(array('StripTags', 'StringTrim'))
			->addValidators(array(
				array('NotEmpty', true, array('messages' => 'Please enter your Nickname.'))
			));
		
		$password = $this->createElement('password', 'password')
			->setLabel('Password')
			->setRequired(true)
			->addFilters(array('StripTags', 'StringTrim'))
			->addValidators(array(
				array('NotEmpty', true, array('messages' => 'Please enter your password.'))
			));
		
		$this->addElements(array($nickName, $password));
	}
}