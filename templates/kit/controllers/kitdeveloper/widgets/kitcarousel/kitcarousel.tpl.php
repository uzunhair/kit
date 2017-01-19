<?php if ($items){ ?>
    <?php
        $indicators = -1;
        $indicators_id = 'carouselIndicators-'.$widget->id;
        $carousel_item = -1;
    ?>
    <div id="<?php echo $indicators_id; ?>" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php foreach($items as $item) { ?>
                <?php $indicators++ ?>
                <li data-target="#<?php echo $indicators_id; ?>" data-slide-to="<?php echo $indicators; ?>" <?php if($indicators == 0) { ?>class="active"<?php } ?>></li>
            <?php } ?>
        </ol>
        <div class="carousel-inner" role="listbox">
            <?php foreach($items as $item) { ?>

                <?php
                $carousel_item++;
                $url        = href_to($ctype['name'], $item['slug']) . '.html';
                $is_private = $item['is_private'] && $hide_except_title && !$item['user']['is_friend'];
                $image      = (($image_field && !empty($item[$image_field])) ? $item[$image_field] : '');
                if ($is_private) {
                    if($image_field && !empty($item[$image_field])){
                        $image = default_images('private', 'small');
                    }
                    $url    = '';
                }
                ?>
                <div class="carousel-item <?php if($carousel_item == 0) { ?>active<?php } ?>">
                    <?php if ($image) { ?>
                        <?php if ($url) { ?>
                            <a href="<?php echo $url; ?>"><?php echo html_image($image, 'big', $item['title']); ?></a>
                        <?php } else { ?>
                            <?php echo html_image($image, 'big', $item['title']); ?>
                        <?php } ?>
                    <?php } ?>
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="title">
                            <?php if ($url) { ?>
                                <a href="<?php echo $url; ?>"><?php html($item['title']); ?></a>
                            <?php } else { ?>
                                <?php html($item['title']); ?>
                            <?php } ?>
                            <?php if ($item['is_private']) { ?>
                                <span class="is_private" data-toggle="tooltip" title="<?php html(LANG_PRIVACY_PRIVATE); ?>"><i class="fa fa-low-vision"></i></span>
                            <?php } ?>
                        </h3>
                        <?php if ($teaser_field && !empty($item[$teaser_field])) { ?>
                            <div class="teaser mb-2">
                                <?php if (!$is_private) { ?>
                                    <?php echo string_short($item[$teaser_field], $teaser_len); ?>
                                <?php } else { ?>
                                    <!--noindex--><div class="private_field_hint"><i class="fa fa-low-vision"></i> <?php echo LANG_PRIVACY_PRIVATE_HINT; ?></div><!--/noindex-->
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <?php if ($is_show_details) { ?>
                            <div class="details">
                            <span class="author list-inline-item">
                                <a href="<?php echo href_to('users', $item['user']['id']); ?>"><i class="fa fa-user"></i> <?php html($item['user']['nickname']); ?></a>
                                <?php if ($item['parent_id']){ ?>
                                    <?php echo LANG_WROTE_IN_GROUP; ?>
                                    <a href="<?php echo rel_to_href($item['parent_url']); ?>"><?php html($item['parent_title']); ?></a>
                                <?php } ?>
                            </span>
                                <span class="date list-inline-item">
                                <i class="fa fa-calendar"></i>
                                    <?php html(string_date_age_max($item['date_pub'], true)); ?>
                            </span>
                                <?php if($ctype['is_comments']){ ?>
                                    <span class="comments list-inline-item">
                                    <i class="fa fa-comment-o"></i>
                                        <?php if ($url) { ?>
                                            <a href="<?php echo $url . '#comments'; ?>" title="<?php echo LANG_COMMENTS; ?>">
                                            <?php echo intval($item['comments']); ?>
                                        </a>
                                        <?php } else { ?>
                                            <?php echo intval($item['comments']); ?>
                                        <?php } ?>
                                </span>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

        </div>
        <a class="carousel-control-prev" href="#<?php echo $indicators_id; ?>" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#<?php echo $indicators_id; ?>" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
<?php } ?>