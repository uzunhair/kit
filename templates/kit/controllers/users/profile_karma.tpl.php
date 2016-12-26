<?php

    $this->setPageTitle($tab['title'], $profile['nickname']);
    $this->setPageDescription($profile['nickname'].' — '.$tab['title']);

    $this->addBreadcrumb(LANG_USERS, $this->href_to(''));
    $this->addBreadcrumb($profile['nickname'], $this->href_to($profile['id']));
    $this->addBreadcrumb($tab['title']);

?>

<div id="user_profile_header">
    <?php $this->renderChild('profile_header', array('profile'=>$profile, 'tabs'=>$tabs)); ?>
</div>

<div id="users_karma_log_window">

    <?php if ($log){ ?>

        <div id="users_karma_log_list" class="striped-list list-32">

            <?php foreach($log as $entry){ ?>

                <div class="media mt-next-1">

                    <div class="media-left">
                        <?php echo html_avatar_image($entry['user']['avatar'], 'micro', $entry['user']['nickname']); ?>
                    </div>
                    <div class="media-body">
                        <div class="title<?php if ($entry['comment']){ ?>-multiline<?php } ?>">

                            <a href="<?php echo $this->href_to($entry['user']['id']); ?>"><?php html($entry['user']['nickname']); ?></a>
                            <span class="text-muted font-size-sm"> <i class="fa fa-calendar"></i> <?php echo string_date_age_max($entry['date_pub'], true); ?></span>

                            <?php if ($entry['comment']){ ?>
                                <div class="comment">
                                    <?php html($entry['comment']); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="media-right <?php echo html_signed_class($entry['points']); ?>">
                        <i class="fa fa-thumbs-o-<?php echo ((html_signed_class($entry['points']) == 'positive' )) ? 'up' : 'down';    ?>"></i>
                        <?php echo html_signed_num($entry['points']); ?>
                    </div>

                </div>

            <?php } ?>

        </div>

    <?php } ?>

    <?php if (!$log){ ?>
        <p><?php echo LANG_USERS_KARMA_LOG_EMPTY; ?></p>
    <?php } ?>

</div>

<?php if ($perpage < $total) { ?>
    <?php echo html_pagebar($page, $perpage, $total); ?>
<?php } ?>