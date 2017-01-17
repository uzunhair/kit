<?php

    $this->addJS('templates/default/js/groups.js');
    $this->addJS('templates/default/js/jquery-ui.js');
    $this->addCSS('templates/default/css/jquery-ui.css');

    $this->setPageTitle(LANG_GROUPS_EDIT_STAFF);

    $this->addBreadcrumb(LANG_GROUPS, $this->href_to(''));
    $this->addBreadcrumb($group['title'], $this->href_to($group['id']));
    $this->addBreadcrumb(LANG_GROUPS_EDIT, $this->href_to($group['id'], 'edit'));
    $this->addBreadcrumb(LANG_GROUPS_EDIT_STAFF);

?>

<h1><?php echo LANG_GROUPS_EDIT ?></h1>

<?php $this->renderChild('group_edit_header', array('group'=>$group)); ?>

<?php if ($staff){ ?>

<div id="group_staff_list" class="striped-list">

    <?php foreach($staff as $member) { ?>
        <?php echo $this->renderChild('group_edit_staff_item', array('member'=>$member, 'group'=>$group)); ?>
    <?php } ?>

</div>

<?php } ?>

<div id="group_staff_add" class="gui-panel">

    <h4><?php echo LANG_GROUPS_ADD_STAFF; ?></h4>
    <div class="mb-3"><?php echo LANG_GROUPS_ADD_STAFF_HINT; ?></div>
    <div class="form-inline">
        <?php echo html_input('text', 'username', '', array('id'=>'staff-username', 'autocomplete'=>'off')); ?>
        <?php echo html_button(LANG_ADD, 'add', 'icms.groups.addStaff()', array('id'=>'staff-submit', 'disabled'=>'disabled')); ?>
        <div class="loading-icon" style="display:none"></div>
    </div>

</div>

<script>

    <?php
        $list = array();
        if (is_array($members)){
            foreach($members as $member){
                $list[] = $member['email'];
            }
        }
    ?>

    $(document).ready(function(){

        icms.groups.url_submit = '<?php echo $this->href_to($group['id'], array('edit', 'staff')); ?>';
        icms.groups.url_delete = '<?php echo $this->href_to($group['id'], array('edit', 'staff_delete')); ?>';

        var members_list = <?php echo $list ? json_encode($list) : '[]'; ?>;

        $( "#staff-username" ).autocomplete({
            source: members_list
        });

        $( "#staff-submit" ).prop('disabled', false);

    });

</script>