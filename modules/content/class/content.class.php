<?php 
class content extends db_class {

    public static $_types = array(
        'c' => 'Case Study',
        'e' => 'Event',
        'n' => 'News',
        'p' => 'Product',
        'r' => 'Research',
        's' => 'Studio',
    );

	/** @var string
	 * Pages master table name
	 */
	protected $_table = 'mst_content';//relation table store category and content
	protected $_rel_content='rel_content';
	protected $_rel_tag = 'rel_tag';
	protected $_mst_tag = 'mst_tag';
	protected $_rel_relation = 'rel_content_relations';
	protected $_rel_feature = 'rel_features';
    protected $_rel_trending = 'rel_trending';

    /**
     * @param $where
     *
     * @return mixed
     */
    public function getTrendingCount($where) {

        $sql = "select count(f.id) as total_rows from ".$this->_rel_trending."  as f
                inner join ".$this->_table." as cnt
                    on cnt.id = f.idContent
                where ".$where;

        $data = $this->getResult($sql);
        return $data['total_rows'];
    }

    /** getting all trending as per where filter provided
     * @param string $where : $where string to filter records
     * @param string $row : Type of data rows
     * @return int|array : return 404 if no data available for the query,
     *                     otherwise return array of results
     */
    public function getTrending($where, $row = 'all') {
        $sql = "select f.id as fid, f.*, cnt.strTitle
                from ".$this->_rel_trending."  as f
                inner join ".$this->_table." as cnt
                    on cnt.id = f.idContent
                where f.enmDeleted = '0' and f.enmStatus = '1'";

        if(!empty($where)) {
            $sql .= " and ".$where;
        }

        if($row == 'single') {
            return $this->getResult($sql);
        } else {
            return $this->getResults($sql);
        }
    }

    /** Save trending details from trending details array
     * @param array $data : Array of trending
     * @return int | bool : returns last contact ID on success, otherwise returns false
     */
    function insertTrending($data) {
        return $this->insertByArray($this->_rel_trending, $data);
    }

    /** Update trending details from Content details array with particular id
     * @param array $data : Array of content
     *              $id:Particular content's ID
     * @return int | bool : returns last contact ID on success, otherwise returns false
     */
    function updateTrending($data) {
        return $this->updateByArray($this->_rel_trending,$data,"id = ".$_POST['id']);
    }

    /**
     * @param $where
     *
     * @return mixed
     */
    public function getFeatureCount($where) {

        $sql = "select count(f.id) as total_rows from ".$this->_rel_feature."  as f
                inner join ".$this->_table." as cnt
                on cnt.id = f.idContent
                where ".$where;

        $data = $this->getResult($sql);
        return $data['total_rows'];
    }

	/** getting Feature related to Feature id
	 * @param  $where : $where is pass particular feature id
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getFeature($where){
		$sql = "select f.id as fid, f.*, cnt.strTitle from ".$this->_rel_feature."  as f
                inner join ".$this->_table." as cnt
                on cnt.id = f.idContent
                where ".$where;
		return $this->getResult($sql);
	}

	/** getting Feature related to Featureid
	 * @param  $where : $where is pass particular featureid
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getFeatures($where){

		$sql = "select f.id as fid, f.*, cnt.strTitle
                from ".$this->_rel_feature." as f
                inner join ".$this->_table." as cnt
                    on cnt.id = f.idContent
                where f.enmDeleted = '0' and f.enmStatus = '1'";

        if(!empty($where)) {
            $sql .= " and ".$where;
        }

		return $this->getResults($sql);
	}

	/** Save feature details from feature details array
	 * @param array $data : Array of feature
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function insertFeature($data) {
		return $this->insertByArray($this->_rel_feature, $data);
	}

	/** Update feature details from Content details array with particular id
	 * @param array $data : Array of content
	 *              $id:Particular content's ID
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function updateFeature($data) {
		return $this->updateByArray($this->_rel_feature,$data,"id = ".$_POST['id']);
	}

	/** Softdelete feature details from Feature details array with particular id
	 * @param array $data : Array of content
	 *              $id:Particular content's ID
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function deleteFeature($id,$data){
		$where='id='.$id;
		return $this->updateByArray($this->_rel_feature,$data,$where);
	}


	/** Delete category releated to content id from rel_content table
	 * @param  $where : Particular content's ID
	 * @return bool : returns true otherwise returns false
	 */
	function deleteContentRelationData($where){
		return $this->deleteRows($this->_rel_relation,$where);
	}


	/** Save content details from Content details array
	 * @param array $data : Array of content
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function insertContentRelationData($data) {

		return $this->insertByArray($this->_rel_relation, $data);
	}

    /** update content relations from provided data
     * @param array $data : Array of content relations data
     * @return int | bool : returns affected rows on success, otherwise returns false
     */
    function updateContentRelation($data) {

        $content_relations = $this->getContentRelations($data['content_id'], $data['type']);

        if($content_relations == 404) {
            return $this->insertContentRelation($data);
        } else {
            $relation_array = array(
                'intTypeId' => $data['type_id'],
            );

            return $this->updateByArray($this->_rel_relation, $relation_array, "strType = '".$data['type']."' and intContentId = ".$data['content_id']);
        }
    }

    /** Get content relations by content ID and type provided
     *
     * @param string $content_id : Content ID to get content relations
     * @param string $content_type : Content type to get content relations
     *
     * @return array | int : Returns array of content relations on content ID and type on success,
     *                      otherwise returns 404
     */
    public function getContentRelations($content_id, $content_type = '') {

        $prepare = array(':content' => $content_id);

        $query_string = '';
        if(!empty($content_type)) {
            $prepare[':type'] = $content_type;
            $query_string .= " and r.strType = :type";
        }

        $this->setPrepare($prepare);

        $sql = "select r.*
                from ".$this->_rel_relation." as r
                where r.intContentId = :content".$query_string;
        return $this->getResults($sql);
    }

    /** Get content tags by content ID array provided
     *
     * @param array $contents : Content ID array to get content tags
     * @return array | int : Returns array of contents with relations on success, otherwise returns 404
     */
    public function getTagsByContents($contents) {
        $sql = "select rt.*, t.strTag, t.strSlug
                from ".$this->_rel_tag." as rt
                inner join ".$this->_mst_tag." as t
                    on t.id = rt.intTagID
                where rt.intContentId in (".implode(", ", $contents).")";
        return $this->getResults($sql);
    }

    /** Get content tags by content type provided
     *
     * @param array $content_type : Content type to get content tags
     * @return array | int : Returns array of contents with relations on success, otherwise returns 404
     */
    public function getTagsByContentType($content_type) {
        $sql = "select rt.*, t.strTag, t.strSlug
                from ".$this->_rel_tag." as rt
                inner join ".$this->_table." as c
                    on c.id = rt.intContentID and c.strContentType in ('".implode("', '", $content_type)."')
                inner join ".$this->_mst_tag." as t
                    on t.id = rt.intTagID";
        return $this->getResults($sql);
    }

    /** Format content tags relational array from tags array provided
     *
     * @param array $tags : Tags array with content ID
     * @return array : Returns array of content ID with related tags
     */
    public function getContentTags($tags) {

        $content_tags = array();
        if($tags != 404) {

            foreach($tags as $tag) {
                $content_id = $tag['intContentID'];
                $content_tags[$content_id][] = $tag;
            }

        }

        return $content_tags;
    }

    /** Get content relations by content id provided
     *
     * @param string $content_id : Content ID to get content relations
     * @param string $relation_type : Relation type to get content relations
     * @return array | int : Returns array of contents relations on success, otherwise returns 404
     */
    public function getContentWithRelationsByID($content_id, $relation_type = 'studio') {
        $this->setPrepare(array(':content' => $content_id, ':type' => $relation_type));

        $sql = "select c1.*
                from ".$this->_rel_relation." as r
                inner join ".$this->_table." as c1
                    on c1.id = r.intContentId and c1.enmDeleted = '0' and c1.enmStatus = '1'
                where r.intTypeId = :content and r.strType = :type
                limit 3";
        return $this->getResults($sql);
    }

    /** Get content with relations by content type provided
     *
     * @param string $content_type : Content type to get content with relations
     * @param string $relation_type : Relation type to get content relations
     * @return array | int : Returns array of contents with relations on success, otherwise returns 404
     */
    public function getContentWithRelationsByType($content_type, $relation_type = 'studio') {
        $this->setPrepare(array(':content' => $content_type, ':type' => $relation_type));

        $sql = "select c.*, c1.strTitle as relation_name, c1.strSlug as relation_slug
                from ".$this->_table." as c
                left join ".$this->_rel_relation." as r
                    on r.intContentId = c.id and r.strType = :type
                left join ".$this->_table." as c1
                    on c1.id = r.intTypeId and c1.enmDeleted = '0' and c1.enmStatus = '1'
                where c.enmDeleted = '0' and c.enmStatus = '1' and c.strContentType = :content
                order by c1.intPosition";
        return $this->getResults($sql);
    }

    /** Insert content relations from provided data
     * @param array $data : Array of content relations data
     * @return int | bool : returns inserted ID on success, otherwise returns false
     */
    function insertContentRelation($data) {

        $relation_array = array(
            'intContentId' => $data['content_id'],
            'intTypeId' => $data['type_id'],
            'strType' => $data['type'],
        );

        return $this->insertByArray($this->_rel_relation, $relation_array);
    }

    /** Get content type slug for provided char
     * @param string $type : Content type key char
     * @return string : Returns content type slug string on success,
     *                otherwise returns false;
     */
    public function getContentTypeSlug($type) {
        if(!in_array($type, array_keys(self::$_types))) {
            return false;
        }

        return str_replace(' ', '-', strtolower(self::$_types[$type]));
    }

    /** Get content for tag ID provided
     * @param int $tag_id : Tag ID to get content list
     * @return array | int : Returns array of content list for provided tag ID on success,
     *                     otherwise returns 404
     */
    public function getContentByTag($tag_id) {

        $this->setPrepare(array(':tag' => $tag_id));

        $sql = "select main.*
                from ".$this->_rel_tag." as t
                inner join ".$this->_table." as main
                    on main.id = t.intContentId
                    and main.enmStatus = '1'
                    and main.enmDeleted = '0'
                    and main.strContentType in ('c', 'e', 'n', 'r')
                where t.intTagId = :tag";
        return $this->getResults($sql);
    }

    /** Get tag details from slug provided
     *
     * @param string $slug : tag slug to get tag details
     * @return array | int : Returns array of tag details on success, otherwise returns 404
     */
    public function getTagBySlug($slug) {
        $this->setPrepare(array(':slug' => $slug));

        $sql = "select t.*
                from ".$this->_mst_tag." as t
                where t.strSlug = :slug";
        return $this->getResult($sql);
    }

	function getContentTag($where){
		$sql = "select mtag.strTag, mtag.id, mtag.strSlug
                from ".$this->_table."  as mst_cnt
                join ".$this->_rel_tag." as rtag on mst_cnt.id=rtag.intContentID
                join ".$this->_mst_tag." as mtag on mtag.id=rtag.intTagID
                where ".$where." and  mtag.enmStatus = '1'
                and mtag.enmDeleted = '0' ";
		return $this->getResults($sql);
	}

	function getFrontContent(){
		$sql = "(select id, strTitle, strContentType, strDescription, strSlug, strContentImg
                from ".$this->_table."
                where `strContentType` = 'n'
                    and enmStatus = '1'
                    and enmDeleted = '0'
                order by dtiCreated desc LIMIT 3)
                UNION ALL
                (select id, strTitle, strContentType, strDescription, strSlug, strContentImg
                from ".$this->_table."
                where `strContentType` = 'r'
                    and enmStatus = '1'
                    and enmDeleted = '0'
                order by dtiCreated desc LIMIT 3)
                UNION ALL
                (select id, strTitle, strContentType, strDescription, strSlug, strContentImg
                from ".$this->_table."
                where `strContentType` = 'c'
                    and enmStatus = '1'
                    and enmDeleted = '0'
                order by dtiCreated desc LIMIT 3)";

		return $this->getResults($sql);
	}

	/** Save content details from Content details array
	 * @param array $data : Array of content
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function insertData($data) {
		return $this->insertByArray($this->_table, $data);
	}


	/** getting Content reletd to Contentid
	 * @param  $where : $where is pass particular contentid
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getRelationContents($where){
		$sql = "select cr.*, c.strTitle, c.strSlug
                from ".$this->_rel_relation." as cr
                inner join ".$this->_table." as c
                    on c.id = cr.intTypeId
                where ".$where;
		return $this->getResults($sql);
	}

	/** getting Content reletd to Contentid
	 * @param  $where : $where is pass particular contentid
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getContents($where){
		$sql = "select * from ".$this->_table." where enmStatus = '1'".$where." order by dtiCreated desc";
		return $this->getResults($sql);
	}

    /** Get Contents by content type
     * @param  $content_type : Type of content to filter records
     * @return int|array : return 404 if no data available for the query,
     *                     otherwise return array of contents for provided content type
     */
    function getContentsByType($content_type){

        $order = in_array($content_type, array('s', 'p')) ? "intPosition" : "dtiContent desc";

        $sql = "select *
                from ".$this->_table."
                where enmDeleted = '0'
                    and enmStatus = '1'
                    and strContentType = '".$content_type."'
                order by ".$order;
        return $this->getResults($sql);
    }

	/** getting Content reletd to Contentid
	 * @param  $where : $where is pass particular contentid
	 * @return int : Send particular count
	 */
	function getContentCount($where) {
	    $sql = "select count(id) as total_rows from " . $this->_table . " where 1".$where;
		$data = $this->getResult($sql);
		return $data['total_rows'];
	}

	/** Update content details from Content details array with particular id
	 * @param array $data : Array of content
	 *              $id:Particular content's ID
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function updateData($data) {
		return $this->updateByArray($this->_table,$data,"id = ".$_POST['id']);
	}

	/** Soft delete content details from Content details array with particular id
	 * @param array $data : Array of content
	 *              $id:Particular content's ID
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function deleteData($id,$data){
		$where='id='.$id;
		return $this->updateByArray($this->_table,$data,$where);
	}
	/** Save content details from Content details array
	 * @param array $data : Array of content
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function insertCategoryData($data) {
		return $this->insertByArray($this->_rel_content, $data);
	}

	/** Save content details from Content details array
	 * @param array $data : Array of content
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function insertRelTagData($data) {
		return $this->insertByArray($this->_rel_tag, $data);
	}

	/** getting category reletd to content using Contentid
	 * @param  $contentid : particular contentid
	 * @return results set with array
	 */
	function getCategoryFromContent($contentid){
		$sql="SELECT mst_category.id,rel_content.intCategoryID FROM `mst_category` as mst_category
              INNER join rel_content as rel_content
                     on mst_category.id=rel_content.intCategoryID
              where rel_content.intContentID=$contentid";
		return $this->getResults($sql);
	}

	/** Update content Category in rel_content table related to  particular id
	 * @param array $data : Array of content
	 *              $where:Particular content's ID
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function updateCategoryData($data,$where) {
		return $this->updateByArray($this->_rel_content,$data,$where);
	}

	/** Delete category releated to content id from rel_content table
	 * @param  $where : Particular content's ID
	 * @return bool : returns true otherwise returns false
	 */
	function deleteCategory($where){
		return $this->deleteRows($this->_rel_content,$where);
	}

	/** getting Content reletd to Contentid
	 * @param  $where : $where is pass particular contentid
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getContent($where){
		$sql = "select * from ".$this->_table." where ".$where;
		return $this->getResult($sql);
	}

	function deleteTag($where){
		return $this->deleteRows($this->_rel_tag, $where);
	}

	function getRelTag($id){

		$sql = "select mst_tag.strTag as tag_name from " . $this->_rel_tag . " as rel_tag
				join " . $this->_mst_tag . " as mst_tag
					on rel_tag.intTagID = mst_tag.id
				where mst_tag.enmStatus = '1'
					and mst_tag.enmDeleted = '0'
					and rel_tag.intContentID = " . $id;

		return $this->getResults($sql);
	}

    /** Get related content list for provided tags of content
     * @param array $tags : Array of tags to match the related content
     * @param int $limit : Limit the number of records
     * @return array | int : Returns array of related content list for provided tags on success,
     *                     otherwise returns 404
     */
    public function getRelatedContent($tags, $limit = 3) {

        $limit_query = ($limit != 0) ? " limit ".$limit : '';

        $sql = "select main.*
                from ".$this->_rel_tag." as t
                inner join ".$this->_table." as main
                    on main.id = t.intContentId and main.enmStatus = '1' and enmDeleted = '0' and strContentType in ('r', 'n', 'c')
                where t.intTagId in (".implode(",", $tags).")
                group by main.id
                ".$limit_query;
        return $this->getResults($sql);
    }
}