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
                <label>Module Name</label>
                <input type="text" name="name" placeholder="Module Name" value="<?php echo (isset($module['name']) ? $module['name'] : ""); ?>">
                <?php echo isset($error_messages['name']) ? "<p class='input-error'>{$error_messages['name']}</p>" : "" ?>
            </div>
            <div class="field">
                <label>Module Parent</label>
                <select name="parent" id="">
                    <?php echo( isset($parentmodules) ? $parentmodules : "" ); ?>
                </select>
                <?php echo isset($error_messages['parent']) ? "<p class='input-error'>{$error_messages['parent']}</p>" : "" ?>
            </div>
            <div class="field">
                <label>Module Short Description</label>
                <textarea type="text" name="shortdescription" rows="3" placeholder="Module Short Description"><?php echo (isset($module['shortdescription']) ? $module['shortdescription'] : ""); ?></textarea>
                <?php echo isset($error_messages['shortdescription']) ? "<p class='input-error'>{$error_messages['shortdescription']}</p>" : "" ?>
            </div>
            <div class="field">
                <label>Module Long Description</label>
                <textarea type="text" name="longdescription" placeholder="Module Long Description"><?php echo (isset($module['longdescription']) ? $module['longdescription'] : ""); ?></textarea>
                <?php echo isset($error_messages['longdescription']) ? "<p class='input-error'>{$error_messages['longdescription']}</p>" : "" ?>
            </div>
            <div class="field">
                <label>Module Tags</label>
                <textarea type="text" name="tags" rows="3" placeholder="Module Tags"><?php echo (isset($module['tags']) ? $module['tags'] : ""); ?></textarea>
                <?php echo isset($error_messages['tags']) ? "<p class='input-error'>{$error_messages['tags']}</p>" : "" ?>
            </div>
            <div class="field">
                <label>Module Image</label>
                <input type="file" name="image">
                <?php if (isset($module['image'])) {?>
                    <a href="javascript:void(0);" class="openimagemodal"><img src="<?php echo $module['image']; ?>" alt="" style="width:200px;margin-top:20px;"></a>
                    <div class="ui modal image-show">
                        <img src="<?php echo $module['image']; ?>" alt="" style="width:100%">
                    </div>
                    <input type="hidden" name="image_public_id" value="<?php echo( isset($module['image_public_id']) ? $module['image_public_id'] : "" ); ?>">
                <?php }?>
                <?php echo isset($error_messages['image']) ? "<p class='input-error'>{$error_messages['image']}</p>" : "" ?>
            </div>
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" name="isactive" id="isactive" value="1" <?php echo( isset($module['isactive']) ? ( $module['isactive'] == 1 ? "checked" : "") : "" ); ?>>
                    <label for="isactive">Is Active</label>
                </div>
                <?php echo isset($error_messages['isactive']) ? "<p class='input-error'>{$error_messages['isactive']}</p>" : "" ?>
            </div>
            <button class="ui button primary huge app-button" type="submit"><?php echo (isset($submitButtonText) ? $submitButtonText : ""); ?></button>
        </form>
    </div>
</div>