<?php
    if(!isset($_SESSION[PF.'MSG']) && !isset($_SESSION[PF.'ERROR'])) {
        _error(404);
        exit;
    }

    $displayTitle = isset($_SESSION[PF.'MSG']) ? 'Thank You' : 'ERROR!'
?>
<div class="wrapper">
    <div class="row container centerAlign">

        <div class="col-md-12">
            <h1><?php _e($displayTitle);?></h1>
            <?php _e($_SESSION[PF.'MSG']); unsetSession(PF.'MSG'); ?>
        </div>
    </div>
</div>