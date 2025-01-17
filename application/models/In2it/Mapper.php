<?


class Model_In2it_Mapper extends In2it_Model_Mapper
{
	public function __construct($dbTableName, $tableName = null)
	{
		$this->setDbTable($dbTableName);

		$dbTable = $this->getDbTable();

		if (is_null($dbTable->info['name']) && !is_null($tableName)) {
			$dbTable->setOptions(array('name' => $tableName));
		}
	}

    public function save(In2it_Model_Abstract $modelObject)
    {
        if (0 < $modelObject->getId()) {
            $modelObject->setModified('now');
        }
        parent::save($modelObject);
    }
}