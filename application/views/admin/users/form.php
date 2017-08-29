<div class="content">
    <?php echo (isset($header) ? $header : ""); ?>
    <?php $error_messages = $this->session->flashdata('form_error'); ?>
    <?php 
        if( $this->session->flashdata('insert_error_formdata') == true ){
            $user = $this->session->flashdata('insert_error_formdata');
        }
     ?>
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
                <label>User Name</label>
                <input type="text" name="name" placeholder="User Name" value="<?php echo (isset($user['name']) ? $user['name'] : ""); ?>">
                <?php echo isset($error_messages['name']) ? "<p class='input-error'>{$error_messages['name']}</p>" : "" ?>
            </div>
            <div class="field">
                <label>User Email</label>
                <input type="email" name="email" placeholder="User Email" value="<?php echo (isset($user['email']) ? $user['email'] : ""); ?>">
                <?php echo isset($error_messages['email']) ? "<p class='input-error'>{$error_messages['email']}</p>" : "" ?>
            </div>
            <div class="field">
                <label>User Password</label>
                <input type="password" name="password" placeholder="User Password" value="<?php echo (isset($user['password']) ? $user['password'] : ""); ?>">
                <?php echo isset($error_messages['password']) ? "<p class='input-error'>{$error_messages['password']}</p>" : "" ?>
            </div>
            <div class="field">
                <label>Retype Password</label>
                <input type="password" name="retype_password" placeholder="Retype Password" value="<?php echo (isset($user['retype_password']) ? $user['retype_password'] : ""); ?>">
                <?php echo isset($error_messages['retype_password']) ? "<p class='input-error'>{$error_messages['retype_password']}</p>" : "" ?>
            </div>
            <button class="ui button primary huge app-button" type="submit"><?php echo (isset($submitButtonText) ? $submitButtonText : ""); ?></button>
        </form>
    </div>
</div>