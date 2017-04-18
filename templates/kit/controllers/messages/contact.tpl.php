<?php // Шаблон панели диалога // ?>

<?php if ($contact){ ?>
<div id="pm_contact">

    <div class="overview mb-3">
        <div class="media">
            <div id="contact_toggle" class="d-flex mr-3 hidden-lg-up">
                <div class="btn btn-secondary"><i class="fa fa-users"></i></div>
            </div>
            <a href="<?php echo href_to('users', $contact['id']); ?>" class="d-flex mr-3">
                <span class="<?php if ($contact['is_online']) { ?>peer_online<?php } else { ?>peer_no_online<?php } ?>">
                    <?php echo html_avatar_image($contact['avatar'], 'micro'); ?>
                </span>
            </a>
            <div class="media-body">
                <a href="<?php echo href_to('users', $contact['id']); ?>" class="user-name">
                    <span><?php echo $contact['nickname']; ?></span>
                </a>

                <?php if (!$contact['is_online']) { ?>
                    <div title="<?php echo LANG_USERS_PROFILE_LOGDATE; ?>" class="user_date_log text-muted">
                        <?php echo mb_strtolower(LANG_USERS_PROFILE_LOGDATE); ?>
                        <span><?php echo mb_strtolower(string_date_age_max($contact['date_log'], true)); ?></span>
                    </div>
                <?php } ?>
            </div>
            <div class="d-flex ml-3 flex-row-reverse">
                <div class="toogle-actions btn btn-secondary ml-1 hidden-lg-up"><i class="fa fa-bars"></i></div>
                <div class="actions pos-r">
                    <div class="btn-group">
                        <span class="btn btn-secondary button_hide" id="delete_msgs"
                           onclick="return icms.messages.deleteMsgs();"
                           title="<?php echo LANG_DELETE; ?>">
                            <i class="fa fa-trash"></i>
                            <sup class="delete_msgs_count"></sup>
                        </span>
                        <?php if (!$contact['is_admin'] && !$contact['is_ignored']) { ?>
                            <span class="btn btn-secondary" id="ignore"
                               onclick="return icms.messages.ignoreContact(<?php echo $contact['id'];?>);"
                               title="<?php echo LANG_PM_ACTION_IGNORE; ?>">
                                <i class="fa fa-ban"></i>
                            </span>
                        <?php } ?>
                        <span class="btn btn-secondary" id="delete"
                           onclick="return icms.messages.deleteContact(<?php echo $contact['id'];?>);"
                           title="<?php echo LANG_PM_DELETE_CONTACT; ?>">
                            <i class="fa fa-user-times"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="pm_chat" class="chat">

        <?php if($has_older){ ?>
            <div class="older-loading"></div>
            <a class="show-older" href="#show-older" onclick="return icms.messages.showOlder(<?php echo $contact['id'] ?>, this);" rel="<?php echo $messages[0]['id']; ?>"><?php echo LANG_PM_SHOW_OLDER_MESSAGES; ?></a>
        <?php } ?>

        <?php if ($messages){ ?>

            <?php echo $this->renderChild('message', array('messages'=>$messages, 'user'=>$user, 'last_date' => '')); ?>

        <?php } ?>


    </div>

    <div class="composer pt-3">

        <?php if ($contact['is_ignored']){ ?>

            <span class="ignored_info text-muted">
                <?php echo LANG_PM_CONTACT_IS_IGNORED; ?>
                <?php echo html_button(LANG_PM_ACTION_FORGIVE, 'forgive', 'icms.messages.forgiveContact('.$contact['id'].')', array('class'=>'btn-sm')); ?>
            </span>

        <?php } else if ($is_me_ignored){ ?>

            <span class="ignored_info"><?php echo LANG_PM_YOU_ARE_IGNORED; ?></span>

        <?php } else if ($is_private){ ?>

            <span class="ignored_info"><?php echo LANG_PM_CONTACT_IS_PRIVATE; ?></span>

        <?php } else { ?>

            <form action="<?php echo $this->href_to('send'); ?>" method="post">
                <?php echo html_input('hidden', 'last_date', '', array('id' => 'msg_last_date')); ?>
                <?php echo html_input('hidden', 'contact_id', $contact['id']); ?>
                <?php echo html_csrf_token(); ?>
                <div class="editor">
                    <?php echo html_editor('content'); ?>
                </div>
                <div class="buttons pt-3">
                    <span id="error_wrap"></span>
                    <span class="ctrenter_hint">ctrl+enter</span>
                    <?php echo html_button(LANG_SEND, 'send', 'icms.messages.send()'); ?>
                </div>
            </form>

        <?php } ?>

    </div>

</div>
<?php }
