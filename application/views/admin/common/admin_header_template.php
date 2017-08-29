<div class="content-head">
    <div class="breadcrumbs">
        <?php echo (isset($breadcrumbs) ? $breadcrumbs : ""); ?>
    </div>
    <div class="page-heading">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <?php if( isset($backlink) ){ ?>
        	<a class="ui button primary labeled icon huge app-button page-header-button" type="submit" href="<?php echo $backlink['url'] ?>">
        		<?php echo( isset($backlink['icon']) ? $backlink['icon'] : "" ); ?>
        		<?php echo $backlink['label'] ?>
    		</a>
        <?php } ?>
    </div>
</div>
