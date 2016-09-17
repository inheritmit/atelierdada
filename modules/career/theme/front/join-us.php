<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>css/fileinput.min.css">
<div class="wrapper">
    <div class="row container centerAlign">

        <div class="col-md-12">
            <h1>About Working Here</h1>
            <p> At Nascent you can be yourself, and that’s the best anyone can be. We believe in the power of innovation and free-spirited mind.<br>
Your creativity, out-of-the-line uniqueness is of great value to the company and we encourage such free flow of ideas for our products and processes.</p>
        </div>

        <div class="col-md-3">
            <div class="workList">
                <div><img src="<?php _e($theme_url);?>images/join-us/create.jpg" alt=""/></div>
                <h3>WE CREATE</h3>
                A place where creativity flourishes in full circle.
            </div>
        </div>
        <div class="col-md-3">
            <div class="workList">
                <div><img src="<?php _e($theme_url);?>images/join-us/help.jpg" alt=""/></div>
                <h3>WE HELP</h3>
                Innovative ideas are shaped into reality.
            </div>
        </div>
        <div class="col-md-3">
            <div class="workList">
                <div><img src="<?php _e($theme_url);?>images/join-us/interact.jpg" alt=""/></div>
                <h3>WE INTERACT</h3>
                Communication and engaging discussions lead to correct decisions.
            </div>
        </div>
        <div class="col-md-3">
            <div class="workList">
                <div><img src="<?php _e($theme_url);?>images/join-us/grow.jpg" alt=""/></div>
                <h3>WE GROW</h3>
                Ownership and freedom in profession leads to unparalleled growth.
            </div>
        </div>

    </div>
</div>

<img src="<?php _e($theme_url);?>images/join-us/join-us.jpg" alt="join-us" class="picW100p"/>
<div class="paddMobile"></div>


<div class="wrapper">
    <div class="row container centerAlign">
        <h2><p>We’re Hiring!</p>Current Openings</h2>

        <div class="col-md-12">
            <ul class="openingList cf">
                <?php
                    $get_job_list = $career_obj->getCareers("enmStatus = '1' and enmDeleted = '0'");
                    foreach($get_job_list as $joinus){
                ?>
                <li>
                    <h5><?php echo $joinus['strTitle']; ?></h5>
                    <?php echo $joinus['strDescription']; ?>
                    <a href="<?php echo SITE_URL . 'file-manager/career/pdf/' . $joinus['strPdfFile'] ?>" target="_blank">Read More</a>
                    <a href="#" class="apply" data-toggle="modal" data-target="#myModal" id="<?php echo $joinus['id']; ?>" data-title="<?php echo $joinus['strTitle']; ?>">Apply for Position</a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

<div class="greyBg">
    <div class="wrapper">
        <div class="row container centerAlign">

            <div class="col-md-12"><p class="font21">So if you want to be a part of a progressive team and want your ideas to take real dimension, please drop in a mail</p>
                <a href="#" data-toggle="modal" data-target="#myModal" class="upload yellowBtn" id="0" data-title="Upload Resume">Upload Resume</a></div>

        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-title" id="modal-title">Modal Header</div>
            </div>
            <div class="modal-body">
                <form role="form" id="join_form" name="join_form" method="post" class="formBox cf" enctype="multipart/form-data" action="<?php _e($module_url);?>/joinus/do">
                    <input type="hidden" name="auth" id="auth" value="false"/>
                    <input type="hidden" name="id" id="id"/>
                    <input type="hidden" name="action" id="action" value="add"/>
                    <div class="form-group">
                        <p>All fields are mandatory.</p>
                    </div>
                    <div class="form-group">
                        <label for="name">Name </label>
                        <input type="text" class="form-control required" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone No.</label>
                        <input type="text" class="form-control required" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control required" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control required" rows="3" id="message" name="message"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Select File</label>
                        <input id="pdf_file" name="pdf_file" type="file" class="file required" data-show-preview="false">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default sendMsg">Send Message</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
<script type="text/javascript" src="<?php _e(ASSET_URL);?>jquery-validate/jquery.validate.js" ></script>
<script type="text/javascript" src="<?php _e($theme_url);?>js/fileinput.min.js"></script>
<script>
    $(document).ready(function() {

        $(".apply, .upload").click(function (){
            var id = $(this).attr('id');
            $('#id').val(id);
            $('#modal-title').html($(this).attr('data-title'));
        });

        $("#join_form").validate();

    });
</script>