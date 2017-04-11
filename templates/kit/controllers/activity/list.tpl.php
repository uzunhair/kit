<?php if ($items){ ?>

    <?php
        $last_date = '';
        $today_date = date('j F Y');
        $yesterday_date = date('j F Y', time()-3600*24);
        $is_can_delete = cmsUser::isAllowed('activity', 'delete');
    ?>

    <div class="activity-list">
        <?php foreach($items as $item) { ?>

            <?php $item_date = date('j F Y', strtotime($item['date_pub'])); ?>
            <?php if ($item_date != $last_date){ ?>

                <?php
                    switch($item_date){
                        case $today_date: $date = LANG_TODAY; break;
                        case $yesterday_date: $date = LANG_YESTERDAY; break;
                        default: $date = lang_date($item_date);
                    }
                ?>

                <h3 class="h4 mt-3">
                    <svg aria-hidden="true" class="octicon" height="18" version="1.1" viewBox="0 0 14 16" width="14"><path fill-rule="evenodd" d="M10.86 7c-.45-1.72-2-3-3.86-3-1.86 0-3.41 1.28-3.86 3H0v2h3.14c.45 1.72 2 3 3.86 3 1.86 0 3.41-1.28 3.86-3H14V7h-3.14zM7 10.2c-1.22 0-2.2-.98-2.2-2.2 0-1.22.98-2.2 2.2-2.2 1.22 0 2.2.98 2.2 2.2 0 1.22-.98 2.2-2.2 2.2z"></path></svg>
                    <?php echo $date; ?>
                </h3>
                <?php $last_date = $item_date; ?>
                <hr class="mb-3 mt-0">

            <?php } ?>

            <?php $url = href_to('users', $item['user']['id']); ?>

            <div class="media">
                <div class="d-flex mr-3">
                    <a href="<?php echo $url; ?>"><?php echo html_avatar_image($item['user']['avatar'], 'micro', $item['user']['nickname']); ?></a>
                </div>
                <div class="media-body">
                    <a class="author" href="<?php echo $url; ?>"><?php html($item['user']['nickname']); ?></a>
                    <?php echo $item['description']; ?>
                    <?php if ($item['is_private']) { ?>
                        <span class="is_private" data-toggle="tooltip" title="<?php html(LANG_PRIVACY_PRIVATE); ?>"><i class="fa fa-low-vision"></i></span>
                    <?php } ?>
                    <div class="details">
                        <span class="date"><?php echo $item['date_diff']; ?></span>
                        <?php if (!empty($item['reply_url']) && cmsUser::isLogged()) { ?>
                            <span class="reply">
                                <a href="<?php echo $item['reply_url']; ?>"><?php echo LANG_REPLY; ?></a>
                            </span>
                        <?php } ?>
                    </div>
                    <?php if (!empty($item['images'])) { ?>
                        <div class="images d-flex flex-wrap mt-2">
                            <?php foreach($item['images'] as $image){ ?>
                                <div class="mr-1">
                                    <a href="<?php echo $image['url']; ?>">
										<img src="<?php echo $image['src']; ?>" alt="">
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
                    <div class="media-right">
                        <a class="delete" href="<?php echo $this->href_to('delete', $item['id']); ?>" title="<?php html(LANG_DELETE); ?>"><i class="fa fa-minus-circle"></i></a>
                    </div>
                <?php } ?>
            </div>

        <?php } ?>
    </div>

    <?php if ($perpage < $total) { ?>
        <?php echo html_pagebar($page, $perpage, $total, $page_url, $filters); ?>
    <?php } ?>

<?php } else { echo LANG_LIST_EMPTY; } ?>
