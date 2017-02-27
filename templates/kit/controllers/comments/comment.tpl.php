<?php // Шаблон одного комментария // ?>

<?php
	$limit_nesting = !empty($this->controller->options['limit_nesting']) ? $this->controller->options['limit_nesting'] : 0;
	$dim_negative = !empty($this->controller->options['dim_negative']);
	$is_guests_allowed = !empty($this->controller->options['is_guests']);
    $is_can_add = ($user->is_logged && cmsUser::isAllowed('comments', 'add')) || (!$user->is_logged && $is_guests_allowed);
    $is_highlight_new = isset($is_highlight_new) ? $is_highlight_new : false;
    if (!isset($is_can_rate)) { $is_can_rate = false; }
?>

<?php foreach($comments as $entry){

    $no_approved_class = $entry['is_approved'] ? '' : 'no_approved';

    if (!isset($is_levels)){ $is_levels = true; }
    if (!isset($is_controls)){ $is_controls = true; }
    if (!isset($is_show_target)){ $is_show_target = false; }

    if ($is_show_target){
        $target_url = rel_to_href($entry['target_url']) . "#comment_{$entry['id']}";
    }

    if ($is_controls){
        $is_can_edit = cmsUser::isAllowed('comments', 'edit', 'all') || (cmsUser::isAllowed('comments', 'edit', 'own') && $entry['user']['id'] == $user->id);
        $is_can_delete = cmsUser::isAllowed('comments', 'delete', 'all') || (cmsUser::isAllowed('comments', 'delete', 'own') && $entry['user']['id'] == $user->id);
    }

    $is_selected = $is_highlight_new && ((int)strtotime($entry['date_pub']) > (int)strtotime($user->date_log));

    $level = (($limit_nesting && $entry['level'] > $limit_nesting) ? $limit_nesting : ($entry['level']-1))*30;

?>

<div id="comment_<?php echo $entry['id']; ?>" class="mt-next-3 comment<?php if($is_selected){ ?> selected-comment<?php } ?><?php if($target_user_id == $entry['user_id']){ ?> is_topic_starter<?php } ?>" <?php if ($is_levels) { ?>style="margin-left: <?php echo $level; ?>px" data-level="<?php echo $entry['level']; ?>"<?php } ?>>
    <div class="media">
        <?php if(!$entry['is_deleted']){ ?>
            <div class="d-flex mr-3">
                <?php if ($entry['user_id']) { ?>
                    <a href="<?php echo href_to('users', $entry['user']['id']); ?>">
                        <?php echo html_avatar_image($entry['user']['avatar'], 'micro', $entry['user']['nickname']); ?>
                    </a>
                <?php } else { ?>
                    <?php echo html_avatar_image($entry['user']['avatar'], 'micro', $entry['user']['nickname']); ?>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="media-body<?php if($entry['is_deleted'] && ($entry['level'] != 1 )){ ?> ml-3<?php }?>">

        <?php if($entry['is_deleted']){ ?>
            <span><?php echo LANG_COMMENT_DELETED; ?></span>
            <span class="scroll-nav">
                <?php if ($entry['parent_id']){ ?>
                    <a href="#up" class="scroll-up" onclick="return icms.comments.up(<?php echo $entry['parent_id']; ?>, <?php echo $entry['id']; ?>)" data-toggle="tooltip" title="<?php html( LANG_COMMENT_SHOW_PARENT ); ?>"><i class="fa fa-level-up"></i></a>
                <?php } ?>
                <a href="#down" class="scroll-down" onclick="return icms.comments.down(this)" data-toggle="tooltip" title="<?php echo html( LANG_COMMENT_SHOW_CHILD ); ?>"><i class="fa fa-level-down"></i></a>
            </span>
        <?php } ?>

        <?php if(!$entry['is_deleted']){ ?>
        <ul class="info list-inline">
            <li class="list-inline-item name">
                <?php if ($entry['user_id']) { ?>
                    <a class="user" href="<?php echo href_to('users', $entry['user']['id']); ?>"><?php echo $entry['user']['nickname']; ?></a>
                <?php } else { ?>
                    <span class="guest_name user"><?php echo $entry['author_name']; ?></span>
                    <?php if ($user->is_admin && !empty($entry['author_url'])) { ?>
                        <span class="guest_ip">
                            [<?php echo $entry['author_url']; ?>]
                        </span>
                    <?php } ?>
                <?php } ?>
                <?php if($is_show_target){ ?>
                    &rarr;
                    <a class="subject" href="<?php echo $target_url; ?>"><?php html($entry['target_title']); ?></a>
                <?php } ?>
            </li>
            <li class="list-inline-item text-muted">
                <span class="<?php echo $no_approved_class; ?>"><i class="fa fa-calendar"></i> <?php echo html_date_time($entry['date_pub']); ?></span>
            </li>
            <?php if ($no_approved_class){ ?>
                <li class="list-inline-item">
                    <span class="hide_approved text-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo html_bool_span(LANG_CONTENT_NOT_APPROVED, false); ?></span>
                </li>
            <?php } ?>
            <?php if ($is_controls){ ?>
                <li class="list-inline-item">
                    <a href="#comment_<?php echo $entry['id']; ?>" name="comment_<?php echo $entry['id']; ?>" data-toggle="tooltip" title="<?php html( LANG_COMMENT_ANCHOR ); ?>"><i class="fa fa-link"></i></a>
                </li>
                <li class="list-inline-item mr-0 scroll-nav">
                    <?php if ($entry['parent_id']){ ?>
                        <a href="#up" class="scroll-up m-r5" onclick="return icms.comments.up(<?php echo $entry['parent_id']; ?>, <?php echo $entry['id']; ?>)" data-toggle="tooltip" title="<?php html( LANG_COMMENT_SHOW_PARENT ); ?>"><i class="fa fa-level-up"></i></a>
                    <?php } ?>
                    <a href="#down" class="scroll-down m-r5" onclick="return icms.comments.down(this)" data-toggle="tooltip" title="<?php echo html( LANG_COMMENT_SHOW_CHILD ); ?>"><i class="fa fa-level-down"></i></a>
                </li>
                <li class="list-inline-item rating <?php echo $no_approved_class; ?> <?php if (($entry['user_id'] == $user->id) && !$entry['is_rated']){ ?> mr-0<?php }?>">
                    <span class="value <?php echo html_signed_class($entry['rating']); ?>">
                        <?php echo $entry['rating'] ? html_signed_num($entry['rating']) : ''; ?>
                    </span>
                    <?php if ($is_can_rate && ($entry['user_id'] != $user->id) && !$entry['is_rated']){ ?>
                        <span class="buttons">
                            <a href="#rate-up" class="rate-up h-dec-no" data-toggle="tooltip" title="<?php echo html( LANG_COMMENT_RATE_UP ); ?>" data-id="<?php echo $entry['id']; ?>">
                                <i class="fa fa-thumbs-o-up"></i>
                            </a>
                            <a href="#rate-down" class="rate-down h-dec-no m-l5 " data-toggle="tooltip" title="<?php echo html( LANG_COMMENT_RATE_DOWN ); ?>" data-id="<?php echo $entry['id']; ?>">
                                <i class="fa fa-thumbs-o-down"></i>
                            </a>
                        </span>
                    <?php } ?>
                </li>
                <?php if ($no_approved_class) { ?>
                    <li class="list-inline-item">
                        <a href="#approve" class="approve hide_approved" onclick="return icms.comments.approve(<?php echo $entry['id']; ?>)"><?php echo LANG_COMMENTS_APPROVE; ?></a>
                    </li>
                <?php } ?>
                <?php if ($is_can_add) { ?>
                    <li class="list-inline-item">
                        <a href="#reply" class="reply <?php echo $no_approved_class; ?>" onclick="return icms.comments.add(<?php echo $entry['id']; ?>)"><?php echo LANG_REPLY; ?></a>
                    </li>
                <?php } ?>
                <?php if ($is_can_edit) { ?>
                    <li class="list-inline-item">
                        <a href="#edit" class="edit" onclick="return icms.comments.edit(<?php echo $entry['id']; ?>)"><?php echo LANG_EDIT; ?></a>
                    </li>
                <?php } ?>
                <?php if ($is_can_delete) { ?>
                    <li class="list-inline-item">
                        <a href="#delete" class="delete" onclick="return icms.comments.remove(<?php echo $entry['id']; ?>)"><?php echo LANG_DELETE; ?></a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
        <div class="body">
            <div class="content">
                <div class="text<?php if($dim_negative && $entry['rating'] < 0){ ?> bad<?php echo ($entry['rating'] < -6 ? 6 : abs($entry['rating'])) ?> bad<?php } ?>">
                    <?php echo $entry['content_html']; ?>
                </div>
            </div>
        </div>
        <?php } ?>
        </div>
    </div>
</div>

<?php } ?>