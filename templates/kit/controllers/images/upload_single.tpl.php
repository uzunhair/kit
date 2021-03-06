<?php
	$this->addJSFromContext( $this->getJavascriptFileName('fileuploader') );
	$this->addJSFromContext( $this->getJavascriptFileName('images-upload') );
?>
<div id="widget_image_<?php echo $dom_id; ?>" class="widget_image_single">

    <div class="data" style="display:none">
        <?php if ($is_image_exists) { ?>
            <?php foreach($paths as $type=>$path){ ?>
                <?php echo html_input('hidden', "{$name}[{$type}]", $path); ?>
            <?php } ?>
        <?php } ?>
    </div>

    <div class="preview row" <?php if (!$is_image_exists) { ?>style="display:none"<?php } ?>>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xs-4">
            <div class="card">
                <div class="preview-height">
                    <img src="<?php if ($is_image_exists) { echo cmsConfig::get('upload_host') . '/' . reset($paths); } ?>" class="card-img-top img-fluid mx-auto" />
                </div>
                <a href="javascript:" onclick="icms.images.remove('<?php echo $dom_id; ?>')" class="btn btn-link btn-block"><?php echo LANG_DELETE; ?></a>
            </div>
        </div>
    </div>

    <div class="upload block" <?php if ($is_image_exists) { ?>style="display:none"<?php } ?>>
        <div id="file-uploader-<?php echo $dom_id; ?>"></div>
    </div>

    <div class="loading block" style="display:none">
        <?php echo LANG_LOADING; ?>
    </div>

    <?php if($allow_import_link){ ?>
        <div class="image_link upload block" <?php if ($is_image_exists) { ?>style="display:none"<?php } ?>>
            <span><?php echo LANG_OR; ?></span> <a class="input_link_block" href="#"><?php echo LANG_PARSER_ADD_FROM_LINK; ?></a>
        </div>
    <?php } ?>

    <script type="text/javascript">

        <?php echo $this->getLangJS('LANG_SELECT_UPLOAD', 'LANG_DROP_TO_UPLOAD', 'LANG_CANCEL', 'LANG_ERROR'); ?>

        $(document).ready(function(){
            icms.images.upload('<?php echo $dom_id; ?>', '<?php echo $upload_url; ?>');
            <?php if($allow_import_link){ ?>
                $('#widget_image_<?php echo $dom_id; ?> .image_link a').on('click', function (){
                    link = prompt('<?php echo LANG_PARSER_ENTER_IMAGE_LINK; ?>');
                    if(link){
                        icms.images.uploadByLink('<?php echo $dom_id; ?>', '<?php echo $upload_url; ?>', link);
                    }
                    return false;
                });
            <?php } ?>
        });

    </script>

</div>
