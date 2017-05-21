<?php
    if( $this->controller->options['is_filter'] ) {
        $this->renderAsset('ui/filter-panel', array(
            'css_prefix' => 'profiles',
            'page_url' => $page_url,
            'fields' => $fields,
            'filters' => $filters,
        ));
    }
?>

<?php if ($profiles){ ?>

    <?php
        $index_first = $page * $perpage - $perpage + 1;
        $index = 0;
    ?>

    <div id="users_profiles_list" class="row">

        <?php foreach($profiles as $profile){ ?>
            <?php
            if (!empty($profile['avatar'])) {
                $img_link = substr(html_avatar_image_src($profile['avatar'], 'normal', true), 1);
                $size = getimagesize($img_link);
                if ($size[0] < $size[1]) {
                    $img_orientation = 'orientation_portrait align-items-center';
                } else {
                    $img_orientation = 'orientation_landscape';
                }
            } else {
                $img_orientation = 'align-items-center';
            }

            ?>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100">

					<a href="<?php echo $this->href_to($profile['id']); ?>" class="<?php echo $img_orientation; ?>">
                        <img class="card-img-top" src="<?php echo html_avatar_image_src($profile['avatar'], 'normal'); ?>" alt="<?php html($profile['nickname']); ?>">
                    </a>
                    <div class="card-block">
                        <h4 class="card-title">
                            <a class="text-gray-dark" href="<?php echo $this->href_to($profile['id']); ?>"><?php html($profile['nickname']); ?></a>
                        </h4>


                        <?php if ($dataset_name == 'popular') { ?>

                            <?php echo $profile['friends_count'] ? html_spellcount($profile['friends_count'], LANG_USERS_FRIENDS_SPELLCOUNT) : '&mdash;'; ?>

                        <?php } elseif ($dataset_name == 'rating') { ?>
                            <div class="d-flex">
                                <div class="position">
                                    <?php $position = $index_first + $index; ?>
                                    <i class="fa fa-list-ol" aria-hidden="true"></i>
                                    <?php echo $position; ?>
                                </div>
                                <div class="ml-auto">
                                    <span class="rate_value cursor-pointer karma <?php echo html_signed_class($profile['karma']); ?>" title="<?php echo LANG_KARMA; ?>"><?php echo html_signed_num($profile['karma']); ?></span> /
                                    <span class="rate_value cursor-pointer rating" title="<?php echo LANG_RATING; ?>"><?php echo $profile['rating']; ?></span>
                                </div>
                            </div>

                        <?php } else { ?>

                            <?php if (!$profile['is_online']){ ?>
                                <?php echo string_date_age_max($profile['date_log'], true); ?>
                            <?php } else { ?>
                                <span class="is_online"><?php echo LANG_ONLINE; ?></span>
                            <?php } ?>

                        <?php } ?>

                    </div>
                </div>
            </div>
            <?php $index++; ?>
        <?php } ?>

    </div>

    <?php if ($perpage < $total) { ?>
        <?php echo html_pagebar($page, $perpage, $total, $page_url, $filters); ?>
    <?php } ?>

<?php } ?>
