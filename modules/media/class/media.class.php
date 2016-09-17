<?php

class media extends db_class
{

	/** @var string
	 * Photo Album master table name
	 */
	protected $_table = 'mst_photo_albums';
	/** @var string
	 * Photos relation table name
	 */
	protected $_rel_photos = 'rel_photos';
	/** @var string
	 * Video Album master table name
	 */
	protected $_video = 'mst_video_albums';
	/** @var string
	 * Category master table name
	 */
	protected $_category = 'mst_category';


	public function mediaSlider(){
		/*  here id is album id in photos */
		 $sql = "SELECT 'photo-album' as type, ph.idPhotoAlbum as id, ph.strImagename as name, ph.dtiCreated as created FROM
".$this->_rel_photos." as ph left join " . $this->_table . " as aph on aph.id=ph.idPhotoAlbum
where ph.enmDeleted = '0' and ph.enmDefaultImage='1'
UNION
SELECT 'video-album' as type, vd.id as id, vd.txtUrl as name, vd.dtiCreated as created FROM ".$this->_video." as vd where vd.enmDeleted = '0'
		 ORDER BY created desc limit 6";
		 return $this->getResults($sql);
	}

	/** Get all photos for Photo Album ID provided
	 * @param int $album_id : Album ID to fetch list of photos
	 * @return array | int : returns Array of photos for provided album ID on success, otherwise returns 404
	 */
	public function getPhotoByAlbum($album_id)
	{
		$sql = "select p.id as albumid, rp.id as photoid, p.strName, p.txtDescription, rp.strImageName, rp.strDescription, rp.enmStatus, rp.enmDefaultImage, rp.enmDeleted
from " . $this->_rel_photos . " as rp
		left join " . $this->_table . " as p
		on p.id=rp.idPhotoAlbum
		where p.id = " . $album_id . "
			and rp.enmStatus = '1'
			and rp.enmDeleted = '0'
		order by rp.id";

		return $this->getResults($sql);
	}

	/** Get count number of mst_photo_albums form Photo Album
	 * @param string $where : condition of SQL statement to be executed
	 * @return int|array : return 404 if no data available for the query,
	 *                      otherwise return array of results
	 */
	function getMediaCount($where)
	{
		$sql = "select count(id) as total_rows from " . $this->_table . " where " . $where;
		$data = $this->getResult($sql);
		return $data['total_rows'];
	}

	/** Get count number of rel_photos form Relation Photo
	 * @param string $where : condition of SQL statement to be executed
	 * @return int|array : return 404 if no data available for the query,
	 *                      otherwise return array of results
	 */
	function getPhotocount($where)
	{
		$sql = "select count(id) as total_rows from " . $this->_rel_photos .
			" where ".$where." order by id desc limit 9";
		$data = $this->getResult($sql);
		return $data['total_rows'];
	}

	function getPhotoAlbumcount($where)
	{
		$sql = "select count(id) as total_rows from " . $this->_table . " where ".$where." order by id desc limit 9";
		$data = $this->getResult($sql);
		return $data['total_rows'];
	}

	function getMorePhotocount($lastid)
	{
		$prepare = array(
			':deleted' => '0',
			':id' => $lastid
		);
		$this->setPrepare($prepare);
		$sql = "select count(id) as total_rows from ".$this->_rel_photos ."
		 where enmDeleted = :deleted and id < :id order by id desc limit 9";
		$data = $this->getResult($sql);
		return $data['total_rows'];
	}

	/** Get all photos for rel_photos Table
	 * @param string $where : condition of SQL statement to be executed
	 * @return array | int : returns Array of photo Album on success, otherwise returns 404
	 */
	function getPhotos($where)
	{
		$sql = "select * from " . $this->_rel_photos . " where " . $where;
		return $this->getResults($sql);
	}

	/** Get all video count form Photo Album
	 * @param string $where : condition of SQL statement to be executed
	 * @return int|array : return 404 if no data available for the query,
	 *                      otherwise return array of results
	 */
	function getVideoCount($where)
	{
		$sql = "select count(id) as total_rows from " . $this->_video . " where " . $where;
		$data = $this->getResult($sql);
		return $data['total_rows'];
	}

	/** Get all photos for Photo Album
	 * @param string $where : condition of SQL statement to be executed
	 * @return array | int : returns Array of fields of photo Album on success, otherwise returns 404
	 */
	function getPhoto($where)
	{
		$sql = "select * from " . $this->_table . " where " . $where;
		return $this->getResult($sql);
	}

	/** Get all video for Video Album
	 * @param string $where : condition of SQL statement to be executed
	 * @return array | int : returns Array of fields of Video Album on success, otherwise returns 404
	 */
	function getVideo($where)
	{
		$sql = "select * from " . $this->_video . " where " . $where;
		return $this->getResult($sql);
	}

	/** Get all photos for Photo Album
	 * @param string $where : condition of SQL statement to be executed
	 * @return array | int : returns Array of photo Album on success, otherwise returns 404
	 */
	function getMedias($where)
	{
		$sql = "select * from " . $this->_table . " where " . $where;
		return $this->getResults($sql);
	}


	function getPhotoAlbum($where)
	{
		$sql = "select ".$this->_table.".id as albumid, ".$this->_table.".*, ".$this->_rel_photos.".* from " . $this->_table . " left join ".$this->_rel_photos." on "
			.$this->_table.".id=" .
			$this->_rel_photos. "
		.idPhotoAlbum where  ".$where;


		return $this->getResults($sql);
	}

	/** Get all Video for Video Album
	 * @param string $where : condition of SQL statement to be executed
	 * @return array | int : returns Array of Video Album on success, otherwise returns 404
	 */
	function getVideos($where)
	{
		$sql = "select " . $this->_video . ".*, " . $this->_category . ".strCategory  from " . $this->_video . "
		LEFT JOIN " . $this->_category . " ON
		" . $this->_category . ".id=" . $this->_video . ".idCategory where  " . $where;
		return $this->getResults($sql);
	}

	/** Inserts data into mst_photo_albums table
	 * @param array $data: array of the table field name and post data of the fields
	 * @return bool|int : id of the row inserted otherwise false on failure
	 */
	function insertData($data)
	{
		return $this->insertByArray($this->_table, $data);
	}

	/** Inserts data into rel_photos table
	 * @param array $data: array of the table field name and post data of the fields
	 * @return bool|int : id of the row inserted otherwise false on failure
	 */
	function insertPhotosData($data)
	{
		return $this->insertByArray($this->_rel_photos, $data);
	}

	/** Updates data of table mst_photo_album provided from key->value pairs in an array
	 * @param array $data : array of the data with key->value pair of table fields as a key
	 * @return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function updateData($data)
	{
		return $this->updateByArray($this->_table, $data, "id = " . $_POST['id']);
	}

	/** Updates data of table rel_photos provided from key->value pairs in an array
	 * @param array $data : array of the data with key->value pair of table fields as a key
	 * @return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function updatephotoData($data)
	{
		return $this->updateByArray($this->_rel_photos, $data, "id = " . $_POST['id']);
	}

	/** Updates data of table rel_photos provided from key->value pairs in an array
	 * @param array $data : array of the data with key->value pair of table fields as a key
	 * @return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function updatephoto($data)
	{
		return $this->updateByArray($this->_rel_photos, $data, "");
	}

	/** Inserts data into mst_video_album table
	 * @param array $data: array of the table field name and post data of the fields
	 * @return bool|int : id of the row inserted otherwise false on failure
	 */
	function insertVideoData($data)
	{
		return $this->insertByArray($this->_video, $data);
	}

	/** Updates data of table mst_video_album provided from key->value pairs in an array
	 * @param array $data : array of the data with key->value pair of table fields as a key
	 * @return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function updateVideoData($data)
	{
		return $this->updateByArray($this->_video, $data, "id = " . $_POST['id']);
	}

	/** Updates status of delete (soft delete) of table mst_video_album provided.
	 * @param int $id : id of table which should be
	 * @param array $data : array of the data with key->value pair of table fields as a key
	 * @return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function deleteVideo($id, $data)
	{
		$where = 'id=' . $id;
		return $this->updateByArray($this->_video, $data, $where);
	}

	/** Updates status of delete (soft delete) of table mst_photo_album provided
	 * @param int $id : id of table which should be
	 * @param array $data : array of the data with key->value pair of table fields as a key
	 * @return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function deletePhoto($id, $data)
	{
		$where = 'id=' . $id;
		return $this->updateByArray($this->_table, $data, $where);
	}
}