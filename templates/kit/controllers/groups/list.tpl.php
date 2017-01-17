<?php if ($groups){ ?>

    <?php
        $index_first = $page * $perpage - $perpage + 1;
        $index = 0;
    ?>

    <div class="groups-list">

        <?php foreach($groups as $group){ ?>

            <div class="media mt-next-3">

                <?php if ($dataset_name == 'rating') { ?>
                    <div class="d-flex mr-3">
                        <?php $position = $index_first + $index; ?>
                        <?php echo $position; ?>
                    </div>
                <?php } ?>

                <div class="d-flex mr-3">
                    <?php
                        echo html_image($group['logo'], 'small', $group['title']);
                    ?>
                </div>

                <div class="media-body">
                    <a class="media-heading h4" href="<?php echo $this->href_to($group['id']); ?>"><?php html($group['title']); ?></a>
                    <?php if ($group['is_closed']) { ?>
                        <span class="is_closed" title="<?php html(LANG_GROUP_IS_CLOSED_ICON); ?>"></span>
                    <?php } ?>
                </div>

                <div class="media-right">

                    <?php if ($dataset_name == 'popular') { ?>

                        <?php echo $group['members_count'] ? html_spellcount($group['members_count'], LANG_GROUPS_MEMBERS_SPELLCOUNT) : '&mdash;'; ?>

                    <?php } elseif ($dataset_name == 'rating') { ?>

                        <span class="rate_value rating" title="<?php echo LANG_RATING; ?>"> <i class="fa fa-star-o"></i> <?php echo $group['rating']; ?></span>

                    <?php } else { ?>
                        <i class="fa fa-calendar"></i>
                        <?php echo html_date($group['date_pub']); ?>

                    <?php } ?>

                </div>

            </div>

            <?php $index++; ?>

        <?php } ?>

    </div>

    <?php if ($perpage < $total) { ?>
        <?php echo html_pagebar($page, $perpage, $total, $page_url); ?>
    <?php } ?>

<?php } ?>
