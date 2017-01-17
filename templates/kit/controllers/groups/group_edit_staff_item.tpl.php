<div class="media mb-3" id="staff-<?php echo $member['id']; ?>">
    <div class="d-flex mr-3">
        <?php echo html_avatar_image($member['avatar'], 'micro'); ?>
    </div>
    <div class="media-body align-self-center">
        <a href="<?php echo href_to('users', $member['id']); ?>"><?php html($member['nickname']); ?></a>
    </div>
    <?php if ($member['id'] != $group['owner_id']) { ?>
        <div class="actions media-right align-self-center">
            <a class="ajaxlink" href="javascript:" onclick="icms.groups.deleteStaff(<?php echo $member['id']; ?>)"><?php echo LANG_CANCEL; ?></a>
            <div class="loading-icon" style="display:none">
                <i class="fa-li fa fa-spinner fa-spin"></i>
            </div>
        </div>
    <?php } ?>
</div>
