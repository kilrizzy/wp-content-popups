<div style='display:none'>
    <?php foreach($contentPopups as $contentPopup){ ?>
    <div id="contentpopup<?php echo $contentPopup->id; ?>" class="content-popup-inline-data">
        <?php echo $contentPopup->content; ?>
    </div>
    <?php } ?>
</div>
<script>
    jQuery(document).ready(function($) {
        <?php foreach($contentPopups as $contentPopup){ ?>
        $("a[href*=contentpopup<?php echo $contentPopup->id; ?>]").colorbox({inline:true});
        <?php } ?>
    });
</script>
