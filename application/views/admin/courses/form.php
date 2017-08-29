<div class="content">
    <?php echo (isset($header) ? $header : ""); ?>
    <?php $error_messages = $this->session->flashdata('form_error'); ?>
    <div class="content-area">
        <form class="ui form" method="post" action="<?php echo (isset($url) ? $url : ""); ?>" enctype="multipart/form-data">
            <?php if (!is_null($error_messages)) {?>
                <div class="ui red message">
                    You have some form errors.
                </div>
                <?php if( isset($error_messages['custom_error_message']) ){ ?>
                    <div class="ui red message">
                        <?php echo($error_messages['custom_error_message']); ?>
                    </div>
                <?php } ?>
            <?php }?>
            <?php if ($this->session->flashdata('form_success')) {?>
                <div class="ui green message"><?php echo $this->session->flashdata('form_success'); ?></div>
            <?php }?>
            <div class="field">
                <label>Course Name</label>
                <input type="text" name="name" placeholder="Course Name" value="<?php echo (isset($course['name']) ? $course['name'] : ""); ?>">
                <?php echo isset($error_messages['name']) ? "<p class='input-error'>{$error_messages['name']}</p>" : "" ?>
            </div>
            <div class="field">
                <label>Course Parent</label>
                <select name="courseparent" id="">
                    <?php echo( isset($courses) ? $courses : "" ); ?>
                </select>
                <?php echo isset($error_messages['courseparent']) ? "<p class='input-error'>{$error_messages['courseparent']}</p>" : "" ?>
            </div>
            <div class="field">
                <label>Course Short Description</label>
                <textarea type="text" name="shortdescription" rows="3" placeholder="Course Short Description"><?php echo (isset($course['shortdescription']) ? $course['shortdescription'] : ""); ?></textarea>
                <?php echo isset($error_messages['shortdescription']) ? "<p class='input-error'>{$error_messages['shortdescription']}</p>" : "" ?>
            </div>
            <div class="field">
                <label>Course Long Description</label>
                <textarea type="text" name="longdescription" placeholder="Course Long Description"><?php echo (isset($course['longdescription']) ? $course['longdescription'] : ""); ?></textarea>
                <?php echo isset($error_messages['longdescription']) ? "<p class='input-error'>{$error_messages['longdescription']}</p>" : "" ?>
            </div>
            <div class="field">
                <label>Course Tags</label>
                <textarea type="text" name="tags" rows="3" placeholder="Course Tags"><?php echo (isset($course['tags']) ? $course['tags'] : ""); ?></textarea>
                <?php echo isset($error_messages['tags']) ? "<p class='input-error'>{$error_messages['tags']}</p>" : "" ?>
            </div>
            <div class="field">
                <label>Course Image</label>
                <input type="file" name="image">
                <?php if (isset($course['image'])) {?>
                    <a href="javascript:void(0);" class="openimagemodal"><img src="<?php echo $course['image']; ?>" alt="" style="width:200px;margin-top:20px;"></a>
                    <div class="ui modal image-show">
                        <img src="<?php echo $course['image']; ?>" alt="" style="width:100%">
                    </div>
                    <input type="hidden" name="image_public_id" value="<?php echo( isset($course['image_public_id']) ? $course['image_public_id'] : "" ); ?>">
                <?php }?>
                <?php echo isset($error_messages['image']) ? "<p class='input-error'>{$error_messages['image']}</p>" : "" ?>
            </div>
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" name="isactive" id="isactive" value="1" <?php echo( isset($course['isactive']) ? ( $course['isactive'] == 1 ? "checked" : "") : "" ); ?>>
                    <label for="isactive">Is Active</label>
                </div>
                <?php echo isset($error_messages['isactive']) ? "<p class='input-error'>{$error_messages['isactive']}</p>" : "" ?>
            </div>
            <button class="ui button primary huge app-button" type="submit"><?php echo (isset($submitButtonText) ? $submitButtonText : ""); ?></button>
        </form>
    </div>
</div>