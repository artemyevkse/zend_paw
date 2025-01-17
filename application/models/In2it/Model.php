<?


abstract class Model_In2it_Model extends In2it_Model_Abstract
{
	protected $_mapperName = 'Model_In2it_Mapper';
	protected $_collectionName = 'Model_In2it_Collection';
	protected $_dbTableModel = 'Zend_Db_Table';

	protected $_dbTableName = null;
	protected $_dbModel = null;	

	protected $_mapper = null;
	protected $_collection = null;	

	protected $_fields = array();


	public function init()
	{
		$this->_mapper = new $this->_mapperName($this->_dbTableModel, $this->_dbTableName);
		$this->_collection = new $this->_collectionName();

		if (is_null($this->_dbModel)) {
			$this->_dbModel = get_class($this);
		}

		return $this;
	}
	
	public function populate($row)
    {
		if (is_array($row)) {
            $row = new ArrayObject($row, ArrayObject::ARRAY_AS_PROPS);
        }
		
		foreach ($this->_fields as $value) {
			$this->_setSafeValues($row, $value, 'set' . $value);
		}
	}
	
	public function toArray()
    {
		$resultArray = array();
		
		foreach ($this->_fields as $value) {
			$method = 'get' . $value;
			$resultArray[$value] = $this->$method();
		}
		
		return $resultArray;
	}
	
	public function save() { return $this->_mapper->save($this); }

	public function __call($method, $args)
	{
		if ('set' == substr($method, 0, 3)
				&& count($args) == 1
		) {
			$name = strtolower(substr($method, 3));
			$value = $args[0];
			
			if (in_array($name, $this->_fields)) {
				$name = '_' . $name;
				$this->$name = $value;
			}
		} else if ('get' == substr($method, 0, 3))
		{
			$name = strtolower(substr($method, 3));

			if (in_array($name, $this->_fields)) {
				$name = '_' . $name;

				return $this->$name;
			}

			return null;
		} else if (!method_exists($this, $method))
		{
			throw new InvalidArgumentException('Method ' . $method . ' does not exists.');
		}


		return $this;
	}
	
	protected function _setSafeValues($resultRow, $key, $method)
    {
        if (!method_exists($this, $method)
				&& !('set' == substr($method, 0, 3) && in_array($key, $this->_fields))
		) {
            throw new InvalidArgumentException('Method ' . $method . ' does not exists.');
        }
        if (isset ($resultRow->$key)) {
            $this->$method($resultRow->$key);
        }
        return $this;
    }
}