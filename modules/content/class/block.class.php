<?php 
class block extends content {

    protected $_mst_block = 'mst_blocks';
    protected $_rel_content_blocks = 'rel_content_blocks';
    protected $_rel_block_details = 'rel_block_details';

    public static $_mobile_apps = array('android', 'ios');

    /** Update content block status for provided ID
     * @param int $content_block_id : Content block ID to update status
     * @param int $status : Status of content block
     * @return int | bool : Returns affected rows on success, otherwise returns false
     */
    public function updateContentBlockStatus($content_block_id, $status) {
        $status_array = array(
            'enmStatus' => $status
        );
        return $this->updateByArray($this->_rel_content_blocks, $status_array, "id = ".$content_block_id);
    }

    /** Update block detail status for provided ID
     * @param int $block_id : Block ID to update status
     * @param int $status : Status of block
     * @return int | bool : Returns affected rows on success, otherwise returns false
     */
    public function updateBlockDetailStatus($block_id, $status) {
        $status_array = array(
            'enmStatus' => $status
        );
        return $this->updateByArray($this->_rel_block_details, $status_array, "id = ".$block_id);
    }

    /** Mark content block deleted for provided ID
     * @param int $content_block_id : Content block ID to be deleted
     * @return int | bool : Returns affected rows on success, otherwise returns false
     */
    public function deleteContentBlock($content_block_id) {
        $delete_array = array(
            'enmDeleted'=>'1',
            'idDeletedBy' => $_SESSION[PF.'USERID'],
            'dtiDeleted' => TODAY_DATETIME
        );
        return $this->updateByArray($this->_rel_content_blocks, $delete_array, "id = ".$content_block_id);
    }

    /** Mark block details deleted for provided ID
     * @param int $block_id : Block ID to be deleted
     * @return bool : Returns true on success, otherwise returns false
     */
    public function deleteBlockDetails($block_id) {
        $delete_array = array(
            'enmDeleted'=>'1',
            'idDeletedBy' => $_SESSION[PF.'USERID'],
            'dtiDeleted' => TODAY_DATETIME
        );
        return $this->updateByArray($this->_rel_block_details, $delete_array, "id = ".$block_id);
    }

	/** Insert content block from relations provided
	 * @param array $data : Array of content block relations
	 * @return int | bool : returns last content block ID on success, otherwise returns false
	 */
	function insertContentBlock($data) {

        $content_block_array = array(
            'intContentId' => $data['content'],
            'intBlockId' => $data['block'],
            'strHeading' => $data['heading'],
            'txtShortDescription' => $data['description'],
            'intPosition' => $data['position'],
            'intCreatedBy' => $_SESSION[PF.'USERID'],
            'dtiCreated' => TODAY_DATETIME,
            'idModifiedBy' => $_SESSION[PF.'USERID'],
            'dtiModified' => TODAY_DATETIME
        );

		return $this->insertByArray($this->_rel_content_blocks, $content_block_array);
	}

    /** Update content block from relations provided
     * @param array $data : Array of content block relations
     * @return int | bool : returns affected rows count on success, otherwise returns false
     */
    function updateContentBlock($data) {

        $content_block_array = array(
            'intContentId' => $data['content'],
            'intBlockId' => $data['block'],
            'intPosition' => $data['position'],
            'strHeading' => $data['heading'],
            'txtShortDescription' => $data['description'],
            'idModifiedBy' => $_SESSION[PF.'USERID'],
            'dtiModified' => TODAY_DATETIME
        );

        return $this->updateByArray($this->_rel_content_blocks, $content_block_array, "id = ".$data['id']);
    }

    /** Insert block details from details array provided
     * @param array $data : Array of block details
     * @return int | bool : returns last block details ID on success, otherwise returns false
     */
    function insertBlockDetails($data) {

        $block_details_array = array(
            'intContentBlockId' => $data['content_block'],
            'txtContent' => $data['details']
        );

        if(isset($data['latitude']) || isset($data['longitude'])) {
            $block_details_array['decLatitude'] = $data['latitude'];
            $block_details_array['decLongitude'] = $data['longitude'];
        }

        if(isset($data['type'])) {
            $block_details_array['strType'] = $data['type'];
        }

        return $this->insertByArray($this->_rel_block_details, $block_details_array);
    }

    /** Update block details from details array provided
     * @param array $data : Array of block details
     * @return int | bool : returns rows affected count on success, otherwise returns false
     */
    function updateBlockDetails($data) {

        $block_details_array = array(
            'intContentBlockId' => $data['content_block'],
            'txtContent' => $data['details']
        );

        if(isset($data['latitude']) || isset($data['longitude'])) {
            $block_details_array['decLatitude'] = $data['latitude'];
            $block_details_array['decLongitude'] = $data['longitude'];
        }

        $query_add = (isset($data['type']) && in_array($data['type'], self::$_mobile_apps)) ? " and strType = '".$data['type']."'" : '';

        return $this->updateByArray($this->_rel_block_details, $block_details_array, "intContentBlockId = ".$data['content_block'].$query_add);
    }

	/** Getting type of blocks for content
	 * @param  $where : Where query to filter records
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	public function getBlocks($where = ''){
		$sql = "select * from ".$this->_mst_block." where enmDeleted = '0'".$where." order by enmStatus desc";
		return $this->getResults($sql);
	}

    /** Get all content block details for content type
     *
     * @param string $content_type : Content type to fetch all content block details
     * @return int | array : Returns array of all content block details for content type provided on success,
     *                     otherwise returns 404
     */
    public function getBlockDetailsByContentType($content_type) {

        $this->setPrepare(array(':content_type' => $content_type));

        $sql = "select bl.*, b.strSlug as block_slug, b.id as block_id,
                  cb.id as content_block_id, cb.strHeading as block_heading,
                  cb.enmStatus as content_block_status, cb.txtShortDescription as block_description,
                  cb.intPosition as block_position, cb.intContentId as content_id
                from ".$this->_rel_content_blocks." as cb
                inner join ".$this->_mst_block." as b
                    on b.id = cb.intBlockId
                inner join ".$this->_table." as c
                    on c.id = cb.intContentId and c.strContentType = :content_type
                left join ".$this->_rel_block_details." as bl
                    on cb.id = bl.intContentBlockId
                where cb.enmDeleted = '0' and cb.enmStatus = '1'
                order by cb.intPosition, bl.intPosition";
        return $this->getResults($sql);

    }

    /** Get content details for search query provided
     *
     * @param string $search_query : Search query to filter contents
     * @return int | array : Returns array of content details for search query provided on success,
     *                     otherwise returns 404
     */
    public function getContentsBySearchQuery($search_query) {

        $prepare = array(':block_id' => 1);

        $search_array = explode(" ", $search_query);

        $query_array = array();
        if(sizeof($search_array) > 0) {
            $w = 1;
            foreach($search_array as $word) {
                $query_array[] = "concat(c.strTitle, bl.txtContent) like :word".$w;
                $prepare['word'.$w++] = "%".$word."%";
            }
        }

        $this->setPrepare($prepare);

        $sql = "select c.*
                from ".$this->_table." as c
                inner join ".$this->_rel_content_blocks." as cb
                    on cb.intContentId = c.id and cb.intBlockId = :block_id
                left join ".$this->_rel_block_details." as bl
                    on cb.id = bl.intContentBlockId
                where cb.enmDeleted = '0'";

        if(sizeof($query_array) > 0) {
            $sql .= " and (".implode(" or ", $query_array).")";
        }

        $sql .= " group by c.id order by c.strTitle";

        return $this->getResults($sql);

    }

    /** Get content block details for content ID provided
     *
     * @param int $content_id : Content ID to fetch content block details
     * @return int | array : Returns array of content block details for content ID provided on success,
     *                     otherwise returns 404
     */
    public function getBlockDetailsByContentID($content_id) {

        $this->setPrepare(array(':content_id' => $content_id));

        $sql = "select bl.*, b.strSlug as block_slug, b.id as block_id,
                  cb.id as content_block_id, cb.strHeading as block_heading,
                  cb.enmStatus as content_block_status, cb.txtShortDescription as block_description,
                  cb.intPosition as block_position
                from ".$this->_rel_content_blocks." as cb
                inner join ".$this->_mst_block." as b
                    on b.id = cb.intBlockId
                left join ".$this->_rel_block_details." as bl
                    on cb.id = bl.intContentBlockId
                where cb.intContentId = :content_id and cb.enmDeleted = '0'
                order by cb.intPosition, bl.intPosition";
        return $this->getResults($sql);

    }

    /** Get content block details for content block ID provided
     *
     * @param int $content_block_id : Content block ID to fetch content block details
     * @return int | array : Returns array of content block details for content block ID provided on success,
     *                     otherwise returns 404
     */
    public function getBlockDetailsByContentBlockID($content_block_id) {

        $this->setPrepare(array(':content_block_id' => $content_block_id));

        $sql = "select bl.*
                from ".$this->_rel_block_details." as bl
                where bl.intContentBlockId = :content_block_id";
        return $this->getResults($sql);

    }
}