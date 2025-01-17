<?


class Service_Chat
{
	public function getAll()
	{
		$chatModel = new Model_Chat();

		return $chatModel->getAll();
	}
}