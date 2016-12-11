<?php // Шаблон списка уведомлений // ?>

<?php if (!$notices) { ?>
    <div class="notice"><?php echo LANG_PM_NO_NOTICES; ?></div>
    <?php return; ?>
<?php } ?>

<div id="pm_notices_window" data-action-url="<?php echo $this->href_to('notice_action'); ?>">

    <div id="pm_notices_list" class="p-1">

        <?php foreach($notices as $notice){ ?>

            <div id="notice-<?php echo $notice['id']; ?>" class="item alert alert-info mb-1">

                <?php if ($notice['options']['is_closeable']){ ?>
                    <a href="#close" onclick="return icms.messages.noticeAction(<?php echo $notice['id']; ?>, 'close')" title="<?php echo LANG_CLOSE; ?>" class="close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                <?php } ?>
                <div class="date"><?php echo html_date_time($notice['date_pub']); ?></div>
                <div class="content mb-1"><?php echo $notice['content']; ?></div>
                <?php if ($notice['actions']){ ?>
                    <div class="buttons">
                        <?php foreach($notice['actions'] as $name=>$action){ ?>
                            <?php echo html_button($action['title'], $name, "icms.messages.noticeAction({$notice['id']}, '{$name}')", array('class'=>'button-small')); ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

        <?php } ?>

    </div>

</div>
