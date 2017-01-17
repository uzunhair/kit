<div class="widget_user_avatar">

    <div class="user_info media px-3">

        <div class="d-flex mr-3 avatar">
            <a href="<?php echo href_to('users', $user->id); ?>">
                <?php echo html_avatar_image($user->avatar, 'micro', $user->nickname); ?>
            </a>
        </div>

        <div class="media-body align-self-center">
            <a href="<?php echo href_to('users', $user->id); ?>">
                <?php html($user->nickname); ?>
            </a>
        </div>

    </div>

    <?php $this->menu( $widget->options['menu'], $widget->options['is_detect'], 'nav flex-column', $widget->options['max_items'] ); ?>

</div>
