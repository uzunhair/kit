<?php
    $this->setPageTitle(LANG_LOG_IN);
    $this->addBreadcrumb(LANG_LOG_IN);
    $is_ajax = $this->controller->request->isAjax();
?>

<?php if($is_ajax && $captcha_html){ ?>
    <script>window.location.href='<?php echo $this->href_to('login'); ?>';</script>
    <?php return; ?>
<?php } ?>

<?php if($is_ajax){ ?>
    <div style="padding: 20px">
<?php } ?>

<div class="login_layout">
    <?php if (!$is_ajax){ ?>
        <div colspan="3" class="top_cell">
            <h1><?php echo LANG_PLEASE_LOGIN; ?></h1>
        </div>
    <?php } ?>
        <div class="left_cell">
            <form action="<?php echo $this->href_to('login'); ?>" method="POST">

                <?php if ($back_url){ echo html_input('hidden', 'back', $back_url); } ?>

                <div class="login_form">

                    <div class="font-size-lg"><?php echo LANG_LOG_IN_ACCOUNT; ?></div>
                    <div class="form-group">
                        <label for="login_email"><?php echo LANG_EMAIL; ?>:</label>
                        <?php echo html_input('text', 'login_email', '', array('id'=>'login_email', 'required'=>true, 'autofocus'=>true)); ?>
                    </div>
                    <div class="form-group">
                        <label for="login_password"><?php echo LANG_PASSWORD; ?>:</label>
                        <?php echo html_input('password', 'login_password', '', array('id'=>'login_password', 'required'=>true)); ?>
                    </div>

                    <div class="form-group options">
                        <label class="custom-control custom-checkbox">
                          <input type="checkbox" id="remember" name="remember" value="1" class="custom-control-input">
                          <span class="custom-control-indicator"></span>
                          <span class="custom-control-description"><?php echo LANG_REMEMBER_ME; ?></span>
                        </label>
                        <a href="<?php echo $this->href_to('restore'); ?>"><?php echo LANG_FORGOT_PASS; ?></a>
                    </div>
                    <?php echo $captcha_html; ?>
                    <div>
                        <?php echo html_submit(LANG_LOG_IN); ?>
                        <span class="reg_link">
                            <?php echo LANG_NO_ACCOUNT; ?> <a href="<?php echo $this->href_to('register'); ?>"><?php echo LANG_REGISTRATION; ?></a>
                        </span>
                    </div>

                </div>

            </form>
        </div>

        <?php /*

        <div class="center_cell">
            <div>или</div>
        </div>

        <div class="right_cell" valign="top">

            <h3><?php echo LANG_LOG_IN_OPENID; ?></h3>

            <p>В разработке</p>

        </div>
         *
         *
         */ ?>

</div>

<?php if($is_ajax){ ?>
    </div>
<?php } ?>

