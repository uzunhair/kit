<?php

    $this->addMenuItems('group_tabs', $this->controller->getGroupEditMenu($group));

?>

<div id="group_profile_tabs" class="mb-1">
    <div class="tabs-menu">
        <?php $this->menu('group_tabs', true, 'nav nav-tabs'); ?>
    </div>
</div>
