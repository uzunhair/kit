<?php

    $this->addJS('templates/default/js/jquery-ui.js');
    $this->addCSS('templates/default/css/jquery-ui.css');

    $this->setPageTitle($profile['nickname']);

    $this->addBreadcrumb(LANG_USERS, href_to('users'));
    $this->addBreadcrumb($profile['nickname']);

    if (is_array($tool_buttons)){
        foreach($tool_buttons as $button){
            $this->addToolButton($button);
        }
    }

?>

<div id="user_profile_header">
    <?php $this->renderChild('profile_header', array('profile'=>$profile, 'tabs'=>false, 'is_can_view'=>false)); ?>
</div>

<div id="user_profile" class="row">

    <div id="left_column" class="col-12 col-lg-4">
        <div class="card">
            <img id="avatar" class="card-img-top img-fluid" src="<?php echo html_avatar_image_src($profile['avatar'], 'normal'); ?>" alt="<?php html($profile['nickname']); ?>">
            <div class="card-block">
                <div>
                    <strong><?php echo LANG_USERS_PROFILE_REGDATE; ?>:</strong>
                    <?php echo string_date_age_max($profile['date_reg'], true); ?>
                </div>
                <div>
                    <strong><?php echo LANG_USERS_PROFILE_LOGDATE; ?>:</strong>
                    <?php echo $profile['is_online'] ? '<span class="online">'.LANG_ONLINE.'</span>' : string_date_age_max($profile['date_log'], true); ?>
                </div>
            </div>
        </div>
    </div>

    <div id="right_column" class="col-12 col-lg-8">
        <div class="height-full text-center">
            <div class="display-1">
                <i class="fa fa-lock"></i>
            </div>
            <p><?php echo LANG_USERS_PROFILE_IS_HIDDEN; ?></p>
        </div>
    </div>

</div>
