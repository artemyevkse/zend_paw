<?php

class Model_Album extends In2it_Model_Abstract
{
	protected $_id;
	protected $_artist;
	protected $_title;
	
	/**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }
	public function getArtist()
    {
        return $this->_artist;
    }
	public function getTitle()
	{
		return $this->_title;
	}
	public function setId($value)
	{
		$this->_id = (int)$value;
		return $this;
	}
	public function setArtist($value)
	{
		$this->_artist = (string)$value;
		return $this;
	}
	public function setTitle($value)
	{
		$this->_title = (string)$value;
		return $this;
	}
	
	/**
     * Populates this Model with data
     *
     * @param array|Zend_Db_Row $row The data
     * @return In2it_Model_Model
     */
    public function populate($row)
    {
		if (is_array($row)) {
            $row = new ArrayObject($row, ArrayObject::ARRAY_AS_PROPS);
        }
		$this->_setSafeValues($row, 'id', 'setId')
			->_setSafeValues($row, 'artist', 'setArtist')
			->_setSafeValues($row, 'title', 'setTitle');
	}
	
	 /**
     * Converts this Model into an array
     *
     * @return array
     */
    public function toArray()
    {
		return array (
            'id' => $this->getId(),
			'artist' => $this->getArtist(),
			'title' => $this->getTitle()
		);
	}
}