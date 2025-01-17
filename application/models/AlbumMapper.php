<?php

class Model_AlbumMapper extends In2it_Model_Mapper
{
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Model_DbTable_Album');
        }
        return parent::getDbTable();
    }

    public function save(In2it_Model_Abstract $model)
    {
        if (0 < $model->getId()) {
            $model->setModified('now');
        }
        parent::save($model);
    }
}