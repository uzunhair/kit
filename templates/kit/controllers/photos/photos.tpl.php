<?php if ($photos){ ?>
    <?php $disable_owner = isset($disable_owner) ? true : false; ?>
    <?php foreach($photos as $photo){ ?>

        <?php
            $is_photo_owner = ($is_owner || $photo['user_id'] == $user->id) && !$disable_owner;
            $photo_url = $photo['slug'] ? href_to('photos', $photo['slug'].'.html') : '#';
            $photo['title'] = $photo_url=='#' ? LANG_PHOTOS_NO_PUB : $photo['title'];
        ?>

        <div class="photo pos-r photo-<?php echo $photo['id']; ?> <?php if ($is_photo_owner) { ?> is_my_photo<?php } ?> <?php echo (($photo_url=='#') ? 'unpublished' : ''); ?>" data-w="<?php echo $photo['sizes'][$preset_small]['width']; ?>" data-h="<?php echo $photo['sizes'][$preset_small]['height']; ?>" itemscope itemtype="http://schema.org/ImageObject">
            <a  class="photo-link" href="<?php echo $photo_url; ?>" title="<?php html($photo['title']); ?>">
                <img src="<?php echo html_image_src($photo['image'], $preset_small, true, false); ?>" title="<?php html($photo['title']); ?>" alt="<?php html($photo['title']); ?>" itemprop="thumbnail" />
            </a>
            <h3 class="title text-center">
                <a href="<?php echo $photo_url; ?>" title="<?php html($photo['title']); ?>" itemprop="name">
                    <?php html($photo['title']); ?>
                </a>
            </h3>
            <div class="info clearfix">
                <?php if(!empty($photo['user']['nickname'])){ ?>
                    <a title="<?php echo LANG_AUTHOR; ?>" href="<?php echo href_to('users', $photo['user']['id']); ?>" class="float-xl-left">
                        <i class="fa fa-user"></i>
                        <?php html($photo['user']['nickname']); ?>
                    </a>
                <?php } ?>
                <div class="photo-counts float-xl-right list-inline">
                    <span class="hits-count list-inline-item" title="<?php echo LANG_HITS; ?>">
                        <i class="fa fa-photo"></i>
                        <?php echo $photo['hits_count']; ?>
                    </span>
                    <span title="<?php echo LANG_RATING; ?>" class="rating list-inline-item <?php echo html_signed_class($photo['rating']); ?>">
                        <i class="fa fa-star"></i>
                        <?php echo html_signed_num($photo['rating']); ?>
                    </span>
                    <span class="comments list-inline-item" title="<?php echo LANG_COMMENTS; ?>">
                        <i class="fa fa-comment"></i>
                        <?php echo $photo['comments']; ?>
                    </span>
                </div>
            </div>

            <?php if ($is_photo_owner) { ?>
                <a class="delete  btn btn-sm btn-danger " href="#" data-id="<?php echo $photo['id']; ?>"><?php echo LANG_DELETE; ?></a>
            <?php } ?>
            <meta itemprop="height" content="<?php echo $photo['sizes'][$preset_small]['height']; ?> px">
            <meta itemprop="width" content="<?php echo $photo['sizes'][$preset_small]['width']; ?> px">
        </div>

    <?php } ?>

    <?php if(isset($has_next) || isset($page) || empty($disable_flex)){ ?>
        <script type="text/javascript">
            <?php if(isset($has_next)){ ?>
                <?php if($has_next){ ?>
                    icms.photos.has_next = true;
                <?php } else { ?>
                    icms.photos.has_next = false;
                <?php } ?>
            <?php } ?>
            <?php if(isset($page)){ ?>
                icms.photos.page = <?php echo $page; ?>;
            <?php } ?>
            <?php if(empty($disable_flex)){ ?>
                icms.photos.flexImagesInit('<?php echo (isset($photo_wrap_id) ? '#'.$photo_wrap_id : ''); ?>');
            <?php } ?>
        </script>
    <?php } ?>
<?php }
