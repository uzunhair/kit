<?php if ($items){ ?>
    <div class="widget_content_list owl-carousel owl-carousel-<?php echo $widget->id; ?> owl-theme">
        <?php foreach($items as $item) { ?>

            <?php
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
            <div class="item">
                <div class="card card-inverse">
                    <?php if ($image) { ?>
                        <?php if ($url) { ?>
                            <a href="<?php echo $url; ?>"><?php echo html_image($image, 'big', $item['title']); ?></a>
                        <?php } else { ?>
                            <?php echo html_image($image, 'big', $item['title']); ?>
                        <?php } ?>
                    <?php } ?>
                    <div class="<?php if($show_img_overlay && $image) { echo 'card-img-overlay ';} ?>info d-flex flex-column justify-content-end <?php echo $p_overlay; ?>">
                            <div class="title flex-last mb-0 <?php echo implode(' ', $title_class); ?>">
                                <?php if ($url) { ?>
                                    <a href="<?php echo $url; ?>"><?php html($item['title']); ?></a>
                                <?php } else { ?>
                                    <?php html($item['title']); ?>
                                <?php } ?>
                                <?php if ($item['is_private']) { ?>
                                    <span class="is_private" data-toggle="tooltip" title="<?php html(LANG_PRIVACY_PRIVATE); ?>"><i class="fa fa-low-vision"></i></span>
                                <?php } ?>
                            </div>
                            <?php if ($is_show_details) { ?>
                                <div class="details align-self-start <?php echo implode(' ', $details_class); ?>">
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
            </div>

        <?php } ?>
    </div>
    <?php if ($show_control) { ?>
        <div class="owl-control d-flex">
            <a href="#" class="prevbtn_nav d-block pl-2 pr-1"><i class="fa fa-chevron-left"></i></a>
            <a href="#" class="nextbtn_nav d-block pl-1"><i class="fa fa-chevron-right"></i></a>
        </div>
    <?php } ?>
    <script src="/templates/kit/js/owl.carousel.min.js"></script>
    <script>
        <?php if ($show_control) { ?>
            $(".owl-control").appendTo(".owl_nav_<?php echo $widget->id; ?>");
        <?php } ?>
        var owl = $('.owl-carousel-<?php echo $widget->id; ?>');
        owl.owlCarousel({
            loop:true,
            margin:10,
            dots:false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:2
                }
            }
        });

        $('.nextbtn_nav').click(function () {
            owl.trigger('next.owl.carousel');
        })
        $('.prevbtn_nav').click(function () {
            owl.trigger('prev.owl.carousel');
        })

    </script>

<?php } ?>