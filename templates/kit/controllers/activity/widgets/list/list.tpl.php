<?php if ($items){ ?>

    <?php
        $last_date = '';
        $today_date = date('j F Y');
        $yesterday_date = date('j F Y', time()-3600*24);
        $is_can_delete = cmsUser::isAllowed('activity', 'delete');
    ?>

    <div class="widget_activity_list">
        <?php foreach($items as $item) { ?>

            <?php if ($show_date_groups) { ?>
                <?php $item_date = date('j F Y', strtotime($item['date_pub'])); ?>
                <?php if ($item_date != $last_date){ ?>

                    <?php
                        switch($item_date){
                            case $today_date: $date = LANG_TODAY; break;
                            case $yesterday_date: $date = LANG_YESTERDAY; break;
                            default: $date = lang_date($item_date);
                        }
                    ?>

                    <h4 class="mt-3"><?php echo $date; ?></h4>
                    <hr class="mb-3 mt-0">
                    <?php $last_date = $item_date; ?>

                <?php } ?>
            <?php } ?>

            <?php $url = href_to('users', $item['user']['id']); ?>

            <div class="item media">
                <?php if ($show_avatars){ ?>
                    <div class="image d-flex mr-3">
                        <a href="<?php echo $url; ?>"><?php echo html_avatar_image($item['user']['avatar'], 'micro', $item['user']['nickname']); ?></a>
                    </div>
                <?php } ?>
                <div class="info media-body">
                    <div class="name">
                        <a class="author" href="<?php echo $url; ?>"><?php html($item['user']['nickname']); ?></a>
                        <span class="activity-list-description">
                            <?php echo $item['description']; ?>
                        </span>
                        <?php if ($item['is_private']) { ?>
                            <span class="is_private" data-toggle="tooltip" title="<?php html(LANG_PRIVACY_PRIVATE); ?>"><i class="fa fa-low-vision"></i></span>
                        <?php } ?>
                    </div>
                    <div class="details details-muted">
                        <span class="date text-muted"><i class="fa fa-calendar"></i> <?php echo $item['date_diff']; ?></span>
                        <?php if (!empty($item['reply_url']) && cmsUser::isLogged()) { ?>
                            <span class="reply">
                                <a href="<?php echo $item['reply_url']; ?>"><i class="fa fa-comment"></i> <?php echo LANG_REPLY; ?></a>
                            </span>
                        <?php } ?>
                    </div>
                    <?php if (!empty($item['images'])) { ?>
                        <div class="images d-flex flex-wrap mt-2">
                            <?php foreach($item['images'] as $image){ ?>
                                <div class="image mr-1">
                                    <a href="<?php echo $image['url']; ?>">
                                        <img alt="<?php html($item['subject_title']); ?>" src="<?php echo $image['src']; ?>" class="img-fluid">
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if($item['images_count'] > 5){ ?>
                                <div class="more px-4 d-flex align-items-center bg-faded">
                                    <a href="<?php echo $item['subject_url']; ?>">+<span><?php echo ($item['images_count']-4); ?></span></a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <?php if ($is_can_delete) { ?>
                    <div class="actions media-right">
                        <a class="delete" href="<?php echo href_to('activity', 'delete', $item['id']); ?>" title="<?php html(LANG_DELETE); ?>"><i class="fa fa-minus-circle"></i></a>
                    </div>
                <?php } ?>
            </div>

        <?php } ?>
    </div>

<?php } ?>