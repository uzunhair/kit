<?php

    $this->addJS('templates/default/js/jquery-ui.js');
    $this->addCSS('templates/default/css/jquery-ui.css');

    $this->setPageTitle($profile['nickname']);
    $this->setPageDescription($profile['nickname'].' — '.mb_strtolower(LANG_USERS_PROFILE_INDEX));

    $this->addBreadcrumb(LANG_USERS, href_to('users'));
    $this->addBreadcrumb($profile['nickname']);

    if (is_array($tool_buttons)){
        foreach($tool_buttons as $button){
            $this->addToolButton($button);
        }
    }

?>

<div id="user_profile_header">
    <?php $this->renderChild('profile_header', array('profile'=>$profile, 'tabs'=>$tabs)); ?>
</div>

<div id="user_profile" class="row">

    <div id="left_column" class="col-4">
        <div class="card">
            <img id="avatar" class="card-img-top img-fluid"
                 src="<?php echo html_avatar_image_src($profile['avatar'], 'normal'); ?>"
                 alt="<?php html($profile['nickname']); ?>">
            <div class="card-block">
                <h4 class="h4 mb-0"><?php html($profile['nickname']); ?></h4>
            </div>
            <?php if ($content_counts) { ?>
                <div class="list-group list-group-flush">
                    <?php foreach ($content_counts as $ctype_name => $count) { ?>
                        <?php if (!$count['is_in_list']) {
                            continue;
                        } ?>
                        <a class="list-group-item list-group-item-action"
                           href="<?php echo href_to('users', $profile['id'], array('content', $ctype_name)); ?>">
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
                        <span class="<?php echo html_signed_class($profile['rating']); ?>"><?php echo $profile['rating']; ?></span>
                    </li>

                    <li>
                        <strong><?php echo LANG_USERS_PROFILE_LOGDATE; ?>:</strong>
                        <?php echo $profile['is_online'] ? '<span class="online">'.LANG_ONLINE.'</span>' : string_date_age_max($profile['date_log'], true); ?>
                    </li>

                    <li>
                        <strong><?php echo LANG_USERS_PROFILE_REGDATE; ?>:</strong>
                        <?php echo string_date_age_max($profile['date_reg'], true); ?>
                    </li>

                    <?php if ($profile['inviter_id']) { ?>
                        <li>
                            <strong><?php echo LANG_USERS_PROFILE_INVITED_BY; ?>:</strong>
                            <a href="<?php echo href_to('users', $profile['inviter_id']); ?>"><?php html($profile['inviter_nickname']); ?></a>
                        </li>
                    <?php } ?>

                    <?php if ($user->is_admin) { ?>
                        <li>
                            <strong><?php echo LANG_USERS_PROFILE_LAST_IP; ?>:</strong>
                            <?php html($profile['ip']); ?>
                        </li>
                    <?php } ?>

                </ul>
            </div>
        </div>

    </div>

    <div id="right_column" class="col-8">

            <div id="information" class="content_item block">
                <?php
                    $fieldsets = cmsForm::mapFieldsToFieldsets($fields, function($field, $user){
                        if (in_array($field['name'], array('nickname', 'avatar'))){ return false; }
                        return true;
                    }, $profile);
                ?>

                <?php foreach($fieldsets as $fieldset){ ?>

                    <?php if (!$fieldset['fields']) { continue; } ?>

                    <div class="fieldset mb-3">

                    <?php if ($fieldset['title']){ ?>
                        <div class="fieldset_title">
                            <h4><?php echo $fieldset['title']; ?></h4>
                        </div>
                    <?php } ?>

                    <?php foreach($fieldset['fields'] as $field){ ?>

                        <?php if (empty($profile[$field['name']]) || !$field['is_in_item']) { continue; } ?>
                        <?php if ($field['groups_read'] && !$user->isInGroups($field['groups_read'])) { continue; } ?>

                        <?php
                            if (!isset($field['options']['label_in_item'])) {
                                $label_pos = 'none';
                            } else {
                                $label_pos = $field['options']['label_in_item'];
                            }
                        ?>

                        <div class="field ft_<?php echo $field['type']; ?> f_<?php echo $field['name']; ?>">

                            <?php if ($label_pos != 'none'){ ?>
                                <div class="title title_<?php echo $label_pos; ?>"><?php echo $field['title']; ?>: </div>
                            <?php } ?>

                            <div class="value">
                                <?php
                                    echo $field['handler']->setItem($profile)->parse( $profile[$field['name']] );
                                ?>
                            </div>

                        </div>

                    <?php } ?>

                    </div>

                <?php } ?>

                <?php if ($is_friends_on && $friends) { ?>
                    <div class="block">
                        <div class="h4">
                            <?php if($show_all_flink){ ?>
                                <a href="<?php echo $this->href_to($profile['id'], 'friends'); ?>"><?php echo LANG_USERS_FRIENDS; ?></a>
                            <?php } else { ?>
                                <?php echo LANG_USERS_FRIENDS; ?>
                            <?php } ?>
                            (<?php echo $profile['friends_count']; ?>)
                        </div>
                        <div class="friends-list">
                            <?php foreach($friends as $friend){ ?>
                                <a href="<?php echo $this->href_to($friend['id']); ?>" data-toggle="tooltip" title="<?php html($friend['nickname']); ?>" class="d-inline-block">
                                    <span><?php echo html_avatar_image($friend['avatar'], 'micro', $friend['nickname']); ?></span>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

            </div>

    </div>

</div>

<?php if ($wall_html){ ?>
    <div id="user_profile_wall">
        <?php echo $wall_html; ?>
    </div>
<?php } ?>
