<?php

    $this->setPageTitle($group['title']);
    $this->setPageDescription($group['description'] ? string_get_meta_description($group['description']): $group['title']);

    $this->addBreadcrumb(LANG_GROUPS, href_to('groups'));
    $this->addBreadcrumb($group['title']);

?>

<div id="group_profile_header">
    <?php $this->renderChild('group_header', array('group'=>$group, 'content_counts' => $content_counts)); ?>
</div>

<div id="group_profile" class="row">

    <div id="left_column" class="col-12 col-lg-4">
        <div class="card">
            <?php if ($group['logo']) { ?>
                <?php echo html_image($group['logo'], 'normal', $group['title'], array('class' => 'card-img-top img-fluid mb-3')); ?>
            <?php } ?>

            <?php if ($content_counts) { ?>
                <div class="list-group list-group-flush">
                    <?php foreach ($content_counts as $ctype_name => $count) { ?>
                        <?php if (!$count['is_in_list']) {
                            continue;
                        } ?>
                        <a class="list-group-item list-group-item-action"
                           href="<?php echo href_to('groups', $group['id'], array('content', $ctype_name)); ?>">
                            <?php html($count['title']); ?>
                            <span class="counter"><?php html($count['count']); ?></span>
                        </a>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="card-block">

                <ul class="list-unstyled mb-0">

                    <li>
                        <strong><?php echo LANG_RATING; ?>:</strong>
                        <span
                            class="<?php echo html_signed_class($group['rating']); ?>"><?php echo $group['rating']; ?></span>
                    </li>

                    <li>
                        <strong><?php echo LANG_GROUP_INFO_CREATED_DATE; ?>:</strong>
                        <?php echo string_date_age_max($group['date_pub'], true); ?>
                    </li>
                    <li>
                        <strong><?php echo LANG_GROUP_INFO_OWNER; ?>:</strong>
                        <a href="<?php echo href_to('users', $group['owner_id']); ?>"><?php html($group['owner_nickname']); ?></a>
                    </li>
                    <li>
                        <strong><?php echo LANG_GROUP_INFO_MEMBERS; ?>:</strong>
                        <a href="<?php echo $this->href_to($group['id'], 'members'); ?>"><?php echo html_spellcount($group['members_count'], LANG_GROUPS_MEMBERS_SPELLCOUNT); ?></a>
                    </li>

                </ul>

            </div>
        </div>
    </div>

    <div id="right_column" class="col-12 col-lg-4">

        <div id="information" class="content_item block">

            <div class="group_description">
                <?php echo cmsEventsManager::hook('html_filter', $group['description']); ?>
            </div>

        </div>

    </div>

</div>

<?php if ($wall_html){ ?>
    <div id="wall_profile_wall">
        <?php echo $wall_html; ?>
    </div>
<?php } ?>

