<?php if ($items){ ?>

    <div class="widget_comments_list">
        <?php foreach($items as $item) { ?>

            <?php $author_url = href_to('users', $item['user']['id']); ?>
            <?php $target_url = href_to($item['target_url']) . "#comment_{$item['id']}"; ?>

            <div class="media mt-next-3">
                <?php if ($show_avatars){ ?>
                <div class="d-flex mr-3">
                    <a href="<?php echo $author_url; ?>"><?php echo html_avatar_image($item['user']['avatar'], 'micro', $item['user']['nickname']); ?></a>
                </div>
                <?php } ?>
                <div class="media-body">
                    <div class="media-heading">
                        <?php if ($item['user_id']) { ?>
                            <a class="author" href="<?php echo $author_url; ?>"><?php html($item['user']['nickname']); ?></a>
                        <?php } else { ?>
                            <span class="author"><?php echo $item['author_name']; ?></span>
                        <?php } ?>
                        &rarr;
                        <a class="subject" href="<?php echo $target_url; ?>"><?php echo html_strip($item['target_title'], 50); ?></a>
                    </div>
                    <?php if ($show_text) { ?>
                        <div class="text m-b5">
                            <?php echo html_clean($item['content_html'], 50); ?>
                        </div>
                    <?php } ?>
                    <div class="font-size-sm">
                         <span class="text-muted">
                             <i class="fa fa-calendar"></i>
                             <?php echo string_date_age_max($item['date_pub'], true); ?>
                         </span>
                        <?php if ($item['is_private']) { ?>
                            <span class="is_private cursor-pointer" data-toggle="tooltip" title="<?php html(LANG_PRIVACY_PRIVATE); ?>">
                                <i class="fa fa-eye-slash"></i>
                            </span>
                        <?php } ?>
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>

<?php } ?>