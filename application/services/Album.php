<?


class Service_Album
{
	public function getAllAlbums()
    {
        $collection = new Model_AlbumCollection();
        $mapper = new Model_AlbumMapper();
        $mapper->fetchAll($collection, 'Model_Album');
        return $collection;
    }
}