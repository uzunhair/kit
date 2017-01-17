<?php

    $this->setPageTitle($group['title']);

    $this->addBreadcrumb(LANG_GROUPS, href_to('groups'));
    $this->addBreadcrumb($group['title']);

?>

<div id="group_profile_header">
    <?php $this->renderChild('group_header', array('group'=>$group)); ?>
</div>

<div id="group_profile" class="row">
    <div id="left_column" class="col-12 col-lg-4">
        <div class="card">
            <?php echo html_image($group['logo'], 'normal', $group['title'], array('class' => 'card-img-top img-fluid mb-3')); ?>
        </div>
    </div>
    <div id="right_column" class="col-12 col-lg-8">
        <div id="information" class="content_item block">
            <i class="fa fa-exclamation-triangle" ></i>
            <?php echo LANG_GROUP_IS_CLOSED; ?>
        </div>
    </div>
</div>
