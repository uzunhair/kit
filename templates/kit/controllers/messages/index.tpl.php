<?php // Шаблон окна личных сообщений // ?>

<?php if (!$is_allowed) { ?>
    <div class="text-muted"><?php echo LANG_PM_NO_ACCESS; ?></div>
    <?php return; ?>
<?php } ?>

<script><?php
    echo $this->getLangJS('LANG_PM_DELETE_CONTACT_CONFIRM', 'LANG_PM_IGNORE_CONTACT_CONFIRM', 'LANG_YES', 'LANG_NO');
?></script>

<div id="pm_window"
     data-contact-url="<?php echo $this->href_to('contact'); ?>"
     data-refresh-url="<?php echo $this->href_to('refresh'); ?>"
     data-show-older-url="<?php echo $this->href_to('show_older'); ?>"
     data-ignore-url="<?php echo $this->href_to('ignore'); ?>"
     data-forgive-url="<?php echo $this->href_to('forgive'); ?>"
     data-delete-url="<?php echo $this->href_to('delete'); ?>"
     data-delete-mesage-url="<?php echo $this->href_to('delete_mesage'); ?>"
     data-restore-mesage-url="<?php echo $this->href_to('restore_mesage'); ?>"
     >

    <?php if (!$contacts) { ?>
        <div class="text-muted"><?php echo LANG_PM_NO_MESSAGES; ?></div>
    <?php } ?>

    <?php if ($contacts) { ?>

        <div class="layout row no-gutters">

            <div class="right-panel col-12 col-lg-3 bg-faded">

                    <div id="user_search_panel">
                        <?php echo html_input('text', '', '', array('placeholder' => LANG_PM_USER_SEARCH)); ?>
                    </div>
                    <div class="contacts">
                        <?php $first_id = false; ?>
                        <?php foreach($contacts as $contact){ ?>
                            <?php $first_id = $first_id ? $first_id : $contact['id']; ?>
                            <?php $nickname = mb_strlen($contact['nickname']) > 15 ? mb_substr($contact['nickname'], 0, 15).'...' : $contact['nickname']; ?>
                            <div id="contact-<?php echo $contact['id']; ?>" class="contact" rel="<?php echo $contact['id']; ?>">
                                <a href="#<?php echo $contact['id']; ?>" onclick="return icms.messages.selectContact(<?php echo $contact['id']; ?>);" title="<?php echo $contact['nickname']; ?>" class="media">
                                    <span class="peer_off_online d-flex mr-2 <?php if ($contact['is_online']) { ?>peer_online<?php } ?>"><?php echo html_avatar_image($contact['avatar'], 'micro'); ?></span>
                                    <span class="media-body">
                                        <span class="contact_nickname"><?php echo $nickname; ?></span>
                                        <span class="d-flex justify-content-between">
                                            <?php if (!$contact['is_online']) { ?>
                                                <strong class="contact-date-log" title="<?php echo LANG_USERS_PROFILE_LOGDATE; ?>"><?php echo string_date_age_max($contact['date_log'], true); ?></strong>
                                            <?php } ?>
                                            <?php if ($contact['new_messages']) { ?>
                                                <span class="counter"><i class="fa fa-commenting-o"></i> <?php echo $contact['new_messages']; ?></span>
                                            <?php } ?>
                                        </span>
                                    </span>
                                </a>
                            </div>
                        <?php } ?>
                    </div>

            </div>

            <div class="left-panel loading-panel col-12 col-lg-9 p-3">

            </div>

        </div>

        <script type="text/javascript">
            icms.messages.options.refreshInterval = <?php echo $refresh_time; ?>;
            icms.messages.initUserSearch();
            icms.messages.selectContact(<?php echo $first_id; ?>);
            icms.messages.bindMyMsg();
            var resize_func = function(){
                var pm_window = $('#pm_window:visible');
                if ($(pm_window).length == 0){
                    $(window).off('resize', resize_func);
                    return false;
                }
                icms.modal.resize();
            };
            $(window).on('resize', resize_func);

            $('#pm_window').on('click', '.toogle-actions', function(){
                $('.actions > .btn-group').toggleClass('active');
                $(this).toggleClass('active');
            });

            icms.modal.setCallback('close', function (){
                $('#popup-manager').removeClass('nyroModalMessage');
            });
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-body').addClass('p-0');
        </script>

    <?php } ?>

</div>