<?


class Form_User	extends In2it_Form
{
	public function __construct($options = null) 
	{
		parent::__construct($options);
		$this->setName('user');
		
		$nickName = $this->createElement('text', 'nickname')
			->setLabel('Nickname')
			->setRequired(true)
			->addFilters(array('StripTags', 'StringTrim'))
			->addValidators(array(
				array('NotEmpty', true, array('messages' => 'Please enter your Nickname.')),
				array('StringLength', true, array('min' => 3, 'max' => 16,
					'messages' => 'Your Nickname must be between 3 and 16 characters in length.'
				))
			));
		
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Name')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('StringLength', true, array(0,32));
			
		$race = new Zend_Form_Element_Radio('race');
		$race->setLabel('Race')
			->setRequired(true)
			->addMultiOptions(array(1 => 'Орк', 2 => 'Эльф', 3 => 'Человек'))
			->setValue(1);

		$city = new Zend_Form_Element_Text('city');
		$city->setLabel('City')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidators(array(
				array('StringLength', true, array('min' => 0, 'max' => 32,
					'messages' => 'Your city name can not be more than 32 characters in length.'
				))
			));

		$password = new Zend_Form_Element_Password('password');
		$password->setLabel('Password')
			->setRequired(true)
			->addFilter('StringTrim')
			->addValidators(array(
				array('NotEmpty', true, array('messages' => 'Please repeat password.')),
				array('StringLength', true, array('min' => 6, 'max' => 32,
					'messages' => 'Your password must be between 6 and 32 characters in length.'
				))
			));
		$repeatPassword = new Zend_Form_Element_Password('password2');
		$repeatPassword->setLabel('Repeat password')
			->setRequired(true)
			->addFilter('StringTrim');
			
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Register');
		
		$birthday = new Zend_Form_Element_Text('birthday');
		$birthday->setLabel('Birthday')
			->setRequired(true)
			->setAttrib('placeholder', 'e.g. 01.01.2025')
			->addFilter('StringTrim')
			->addValidators(array(
				array('Date', true, array('format' => 'dd.MM.YYYY',
					'messages' => 'Incorrect date'
				)),
				array('Regex', true, array('pattern' => '%[0-9]{2}.[0-9]{2}.[0-9]{4}%',
					'messages' => 'Incorrect date format. (Must be type dd.MM.YYYY, e.g. 01.01.2025)'
				))
			));	


		$this->addElements(array($nickName, $name, $birthday, $race, $city, $password, $repeatPassword, $submit));

		$this->setElementDecorators(
			array(
				array('ViewScript', array('viewScript' => 'forms/elements/element.phtml'))
			),
			array('nickname', 'name', 'city', 'password', 'password2', 'birthday')
		);
		$this->setElementDecorators(
			array(
				array('ViewScript', array('viewScript' => 'forms/elements/radio.phtml'))
			),
			array('race')
		);
	}

	public function isValid($data)
	{
		$valid = parent::isValid($data);

		$valid = $valid && $this->validatePassword($data);		

		return $valid;
	}

	public function validatePassword($data)
	{
		$valid = true;

		if (!array_key_exists('password', $data)
			|| !array_key_exists('password2', $data)
		) {
			$valid = false;
		} else {
			if ($data['password'] !== $data['password2']) {
				$valid = false;
				$this->getElement('password2')
					->addError('Пароли не совпадают');
			}
		}

		if (!$valid) {
			$this->markAsError();
		}

		return $valid;
	}
}