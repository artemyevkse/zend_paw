<?


class Model_User extends Model_In2it_Model
{
	protected $_dbTableName = 'users';
	
	protected $_fields = array(
		'id',
		'login',
		'password',
		'name',
		'birthday',
		'city',
		'race',
		'regdate',
		'activitytime'
	);


	public function getAll()
	{	
		$this->_mapper->fetchAll($this->_collection, $this->_dbModel);

		return $this->_collection;
	}

	public function findByLogin($login)
	{
		$this->_mapper->fetchRow($this, array('login = ?' => $login));

		return is_null($this->getId()) ? null : $this;
	}
	
}