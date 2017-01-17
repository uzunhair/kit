<?php if ($profiles){ ?>

    <div class="widget_profiles_list <?php echo $style; ?>">

        <?php if ($style=='list'){ ?>
            <?php foreach($profiles as $profile) { ?>

                <?php $url = href_to('users', $profile['id']); ?>

                <div class="media mb-3">
                    <a class="d-flex mr-3" href="<?php echo $url; ?>" title="<?php html($profile['nickname']); ?>"><?php echo html_avatar_image($profile['avatar'], 'micro', $profile['nickname']); ?></a>
                    <div class="media-body align-self-center">
                        <a href="<?php echo $url; ?>"><?php html($profile['nickname']); ?></a>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <?php foreach($profiles as $profile) { ?>

                <?php $url = href_to('users', $profile['id']); ?>

                <div class="mb-3">
                    <a class="d-flex mr-3" href="<?php echo $url; ?>" title="<?php html($profile['nickname']); ?>"><?php echo html_avatar_image($profile['avatar'], 'small', $profile['nickname']); ?></a>
                    <div class="media-body align-self-center">
                        <a href="<?php echo $url; ?>"><?php html($profile['nickname']); ?></a>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>

<?php } ?>
