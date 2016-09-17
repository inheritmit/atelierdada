<?php 
$row = $account_obj->getAccountByID($_SESSION[PF.'USERID']);
?>
<style type="text/css">
  h3.timeline-title{
    display: none;
  }
</style>
<aside class="profile-nav col-lg-3">
    <section class="panel">
        <div class="user-heading round">

                <?php if($row['strImgurl'] != "" && $row['strImgurl'] != NULL){
                    ?>
                        <img src="<?php _e(SITE_URL.'file-manager/account/avtar/140/'.$row['strImgurl']); ?>" alt="">
                    <?php 
                    } ?>

            <h1><?php _e($row['strFirstName'].' '.$row['strLastName']); ?></h1>
            <p><?php _e($row['strEmail']); ?></p>
        </div>

        <!--<ul class="nav nav-pills nav-stacked">
            <li class="active"><a href="profile"> <i class="fa fa-user"></i> Profile</a></li>
        </ul>-->

    </section>
</aside>