<?php

    $this->addJS($this->getJavascriptFileName('photos'));
    $this->addJS($this->getJavascriptFileName('jquery-owl.carousel'));
    $this->addJS($this->getJavascriptFileName('screenfull'));
    $this->addCSS('templates/default/css/jquery-owl.carousel.css');

    $this->setPageTitle($photo['title']);
    $this->setPageDescription($photo['content'] ? string_get_meta_description($photo['content']) : ($photo['title'].' — '.$album['title']));

    if ($ctype['options']['list_on']) {
        $this->addBreadcrumb($ctype['title'], href_to($ctype['name']));
    }
    if (isset($album['category'])) {
        foreach ($album['category']['path'] as $c) {
            $this->addBreadcrumb($c['title'], href_to($ctype['name'], $c['slug']));
        }
    }
    if ($ctype['options']['item_on']) {
        $this->addBreadcrumb($album['title'], href_to($ctype['name'], $album['slug']) . '.html');
    }
    $this->addBreadcrumb($photo['title']);

    if ($is_can_edit) {
        $this->addToolButton(array(
            'class' => 'edit',
            'title' => LANG_PHOTOS_EDIT_PHOTO,
            'href'  => $this->href_to('edit', $photo['id'])
        ));
    }

    if ($is_can_delete) {
        $this->addToolButton(array(
            'class'   => 'delete',
            'title'   => LANG_PHOTOS_DELETE_PHOTO,
            'href'    => 'javascript:icms.photos.delete()',
            'onclick' => "if(!confirm('" . LANG_PHOTOS_DELETE_PHOTO_CONFIRM . "')){ return false; }"
        ));
    }

?>

<div id="album-photo-item" class="content_item row" data-item-delete-url="<?php if ($is_can_delete){ echo $this->href_to('delete'); } ?>" data-id="<?php echo $photo['id']; ?>" itemscope itemtype="http://schema.org/ImageObject">
    <div class="left col-lg-8 col-12">
        <div class="inside mb-3">
            <div class="inside_wrap orientation_<?php echo $photo['orientation']; ?>" id="fullscreen_cont">
                <div id="photo_container" <?php if($full_size_img){?>data-full-size-img="<?php echo $full_size_img; ?>"<?php } ?> class="mb-3">
                    <?php echo $this->renderChild('view_photo_container', array(
                        'photo'      => $photo,
                        'preset'     => $preset,
                        'prev_photo' => $prev_photo,
                        'next_photo' => $next_photo
                    )); ?>
                </div>
            </div>
            <?php if($photos){ ?>
            <div id="related_photos_wrap">
                <h3><?php echo $related_title; ?></h3>
                <div class="album-photos-wrap owl-carousel" id="related_photos" data-delete-url="<?php echo href_to('photos', 'delete'); ?>">
                    <?php echo $this->renderChild('photos', array(
                        'photos'        => $photos,
                        'is_owner'      => false,
                        'user'          => $user,
                        'photo_wrap_id' => 'related_photos',
                        'preset_small'  => $preset_small,
                        'disable_flex'  => true
                    )); ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <div class="right col-lg-4 col-12">
        <div class="photo_author media mb-3">
            <div class="d-flex mr-3 album_user" title="<?php echo LANG_AUTHOR ?>">
                <a href="<?php echo href_to('users', $photo['user']['id']); ?>">
                    <?php echo html_avatar_image($photo['user']['avatar'], 'micro', $photo['user']['nickname']); ?>
                </a>
            </div>
            <div class="media-body align-self-center">
                <a href="<?php echo href_to('users', $photo['user']['id']); ?>" title="<?php echo LANG_AUTHOR ?>" class="pr-3">
                    <i class="fa fa-user-o"></i>
                    <?php echo $photo['user']['nickname']; ?>
                </a>
                <span class="album_date text-muted" title="<?php echo LANG_DATE_PUB; ?>">
                    <i class="fa fa-calendar"></i>
                    <?php echo html_date_time($photo['date_pub']); ?>
                </span>
            </div>
        </div>

        <div class="like_buttons info_bar">
        <?php if (!empty($photo['rating_widget'])){ ?>
            <div class="bar_item bi_rating">
                <?php echo $photo['rating_widget']; ?>
            </div>
        <?php } ?>
            <div class="bar_item share">
                <script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
<script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>
<div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus,twitter,viber,whatsapp" data-size="s"></div>
            </div>
        </div>

        <?php if (!empty($photo['content'])){ ?>
            <div class="photo_content mt-3" itemprop="description">
                <?php echo $photo['content']; ?>
            </div>
        <?php } ?>

        <?php if (!empty($downloads)){ ?>
            <div class="download_menu pos-r">
                <span id="download-button" class="download-button btn btn-primary display-b mt-3"><i class="photo_icon icon_download"></i> <?php echo LANG_DOWNLOAD; ?></span>
                <div id="bubble" class="dropdown-menu p-3 w-100">
                            <?php foreach ($downloads as $download) { ?>
                            <div class="row <?php echo $download['preset']; ?>_download_preset <?php echo (!$download['link'] ? 'disable_download' : ''); ?>">
                                <div class="col-8">
                                    <label><input <?php echo ($download['select'] ? 'checked=""' : ''); ?> type="radio" name="download" <?php echo (!$download['link'] ? 'disabled=""' : ''); ?> value="<?php echo $download['link']; ?>"> <?php echo $download['name']; ?> </label>
                                </div>
                                <div class="col-4">
                                    <?php echo $download['size']; ?>
                                </div>
                            </div>
                            <?php } ?>
                    </table>
                    <a class="download-button process_download btn btn-outline-primary" href=""><?php echo LANG_DOWNLOAD; ?></a>
                </div>
            </div>
        <?php } ?>
        <div class="bg-faded p-3 mt-3">
        <?php if ($photo['exif'] || $photo['camera']){ ?>
            <div class="exif_wrap">
                <?php if ($photo['camera']){ ?>
                    <a href="<?php html(href_to('photos', 'camera-'.urlencode($photo['camera']))); ?>">
                        <?php html($photo['camera']); ?>
                    </a>
                <?php } ?>
                <?php if ($photo['exif']){ ?>
                    <div class="exif_info">
                        <?php foreach ($photo['exif'] as $name => $value) { ?>
                            <span title="<?php echo string_lang('lang_exif_'.$name); ?>"><?php html($value); ?></span>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <dl class="photo_details mt-3 row">
            <?php foreach ($photo_details as $detail) { ?>
                <dt class="col-6"><?php echo $detail['name']; ?></dt>
                <dd class="col-6">
                    <?php if(isset($detail['link'])){ ?>
                        <a href="<?php echo $detail['link']; ?>" title="<?php html($detail['value']); ?>">
                            <?php echo $detail['value']; ?>
                        </a>
                    <?php } else { ?>
                        <?php echo $detail['value']; ?>
                    <?php } ?>
                </dd>
            <?php } ?>
        </dl>
        </div>

    </div>
    <meta itemprop="height" content="<?php echo $photo['sizes'][$preset]['height']; ?> px">
    <meta itemprop="width" content="<?php echo $photo['sizes'][$preset]['width']; ?> px">
</div>

<?php if ($hooks_html) { echo html_each($hooks_html); } ?>

<?php if (!empty($photo['comments_widget'])){ ?>
    <?php echo $photo['comments_widget']; ?>
<?php } ?>

<script type="text/javascript">
    icms.photos.init = true;
    icms.photos.mode = 'photo';
    $(function(){
        icms.photos.initCarousel('#related_photos', function (){
            left_height = $('#album-photo-item .inside_wrap').height();
            side_height = $('#album-photo-item .right').height();
            if(side_height <= left_height){
                $('#album-photo-item').append($('#related_photos_wrap'));
            }
        });
    });
</script>