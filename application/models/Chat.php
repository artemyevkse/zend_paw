<?


class Model_Chat extends Model_In2it_Model
{
	protected $_dbTableName = 'chat';
	
	protected $_fields = array(
		'id',
		'message',
		'userid',
		'type',
		'time'
	);
	
	
	public function getAll()
	{	
		$this->_mapper->fetchAll($this->_collection, $this->_dbModel);

		return $this->_collection;
	}
}