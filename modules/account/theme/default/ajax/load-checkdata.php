<?php
//pr($_GET);exit;
if((isset($_REQUEST['email']) && !empty($_REQUEST['email']))){
    $email=$_REQUEST['email'];
    $where="strEmail='$email'";
    $project_count = $account_obj->getAccountsCount($where);//echo $account_obj->last_query;exit;
    if($project_count==0) {
        _e("true");
    }else{
        _e("false");
    }
}
?>