<div class="content">
    <?php echo (isset($header) ? $header : ""); ?>
    <?php $error_messages = $this->session->flashdata('form_error');?>
    
    <div class="content-area">
        <table id="courses_list" class="ui striped table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created On</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>