<?php
$where = "strSlug='$req[slug]'";
$page = $page_obj->getPage($where);
echo $page['content'];
?>