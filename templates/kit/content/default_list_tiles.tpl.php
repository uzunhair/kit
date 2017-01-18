<?php
    if( $ctype['options']['list_show_filter'] ) {
        $this->renderAsset('ui/filter-panel', array(
            'css_prefix'   => $ctype['name'],
            'page_url'     => $page_url,
            'fields'       => $fields,
            'props_fields' => $props_fields,
            'props'        => $props,
            'filters'      => $filters,
            'is_expanded'  => $ctype['options']['list_expand_filter']
        ));
    }
?>

<?php if ($items){ ?>

    <div class="content_list tiled <?php echo $ctype['name']; ?>_list row">

        <?php $columns = 3; $index = 1; ?>

        <?php foreach($items as $item){ ?>

            <?php
                $item['ctype'] = $ctype;
                $is_private    = $item['is_private'] && $hide_except_title && !$item['user']['is_friend'];
                $stop = 0;
                $preset = $fields['photo']['options']['size_teaser'];
            ?>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="tile card h-100 <?php echo $ctype['name']; ?>_list_item<?php if (!empty($item['is_vip'])){ ?> is_vip<?php } ?>">

                <?php if (isset($fields['photo']) && $fields['photo']['is_in_list'] && !empty($item['photo'])){ ?>
                    <div class="photo pos-r">
                        <?php if ($is_private) { ?>
                            <?php echo html_image(default_images('private', $preset), $preset, $item['title']); ?>
                        <?php } else { ?>
                            <a href="<?php echo href_to($ctype['name'], $item['slug'].'.html'); ?>">
                                <?php echo html_image($item['photo'], $preset, $item['title']); ?>
                            </a>
                        <?php } ?>
                        <?php unset($item['photo']); ?>

                        <?php if ($fields['date_pub']['is_in_list']){ ?>
                            <div class="note card-img-overlay d-flex align-items-end" title="<?php echo $fields['date_pub']['title']; ?>">
                                <span class="bg-faded py-1 px-2  d-inline-block">
                                    <i class="fa fa-calendar"></i>
                                    <?php echo $fields['date_pub']['handler']->parse( $item['date_pub'] ); ?>
                                </span>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

                <div class="fields card-block">

                <?php foreach($fields as $field){ ?>

                    <?php if ($stop === 2) { break; } ?>
                    <?php if ($field['is_system'] || !$field['is_in_list'] || !isset($item[$field['name']])) { continue; } ?>
                    <?php if ($field['groups_read'] && !$user->isInGroups($field['groups_read'])) { continue; } ?>
                    <?php if (!$item[$field['name']] && $item[$field['name']] !== '0') { continue; } ?>

                    <?php
                        if (!isset($field['options']['label_in_list'])) {
                            $label_pos = 'none';
                        } else {
                            $label_pos = $field['options']['label_in_list'];
                        }
                    ?>

                    <div class="field ft_<?php echo $field['type']; ?> f_<?php echo $field['name']; ?>">

                        <?php if ($label_pos != 'none'){ ?>
                            <div class="title_<?php echo $label_pos; ?>"><?php echo $field['title'] . ($label_pos=='left' ? ': ' : ''); ?></div>
                        <?php } ?>

                        <?php if ($field['name'] == 'title' && $ctype['options']['item_on']){ ?>
                            <h2 class="value title h4">
                                <?php if ($item['parent_id']){ ?>
                                    <a class="parent_title" href="<?php echo rel_to_href($item['parent_url']); ?>"><?php html($item['parent_title']); ?></a>
                                    &rarr;
                                <?php } ?>
                                <?php if ($is_private) { $stop++; ?>
                                    <?php html($item[$field['name']]); ?> <span class="is_private" data-toggle="tooltip" title="<?php html(LANG_PRIVACY_PRIVATE); ?>"><i class="fa fa-low-vision"></i></span>
                                <?php } else { ?>
                                    <a class="title" href="<?php echo href_to($ctype['name'], $item['slug'].'.html'); ?>"><?php html($item[$field['name']]); ?></a>
                                    <?php if ($item['is_private']) { ?>
                                        <span class="is_private" data-toggle="tooltip" title="<?php html(LANG_PRIVACY_PRIVATE); ?>"><i class="fa fa-low-vision"></i></span>
                                    <?php } ?>
                                <?php } ?>
                            </h2>
                        <?php } else { ?>
                            <div class="value">
                                <?php if ($is_private) { ?>
                                     <!--noindex--><div class="private_field_hint"><i class="fa fa-low-vision"></i> <?php echo LANG_PRIVACY_PRIVATE_HINT; ?></div><!--/noindex-->
                                <?php } else { ?>
                                     <?php echo $field['handler']->setItem($item)->parseTeaser($item[$field['name']]); ?>
                                <?php } ?>
                            </div>
                        <?php } ?>

                    </div>

                <?php } ?>

                </div>

                <?php
                    $show_bar = !empty($item['rating_widget']) ||
                                $fields['date_pub']['is_in_list'] ||
                                $fields['user']['is_in_list'] ||
                                !$item['is_approved'];
                ?>

                <?php if ($show_bar){ ?>
                    <div class="info_bar card-footer mt-0">
                        <?php if (!empty($item['rating_widget'])){ ?>
                            <div class="bar_item bi_rating">
                                <?php echo $item['rating_widget']; ?>
                            </div>
                        <?php } ?>
                        <?php if ($fields['user']['is_in_list']){ ?>
                            <div class="bar_item bi_user" title="<?php echo $fields['user']['title']; ?>">
                                <i class="fa fa-user-o"></i>
                                <?php echo $fields['user']['handler']->parse( $item['user'] ); ?>
                            </div>
                        <?php } ?>
                        <?php if ($ctype['is_comments'] && $item['is_comments_on']){ ?>
                            <div class="bar_item bi_comments">
                                <?php if ($is_private) { ?>
                                    <i class="fa fa-comment-o"></i>
                                    <?php echo intval($item['comments']); ?>
                                <?php } else { ?>
                                    <a href="<?php echo href_to($ctype['name'], $item['slug'].'.html'); ?>#comments" title="<?php echo LANG_COMMENTS; ?>">
                                        <i class="fa fa-comment-o"></i>
                                        <?php echo intval($item['comments']); ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <?php if (!$item['is_approved']){ ?>
                            <div class="bar_item bi_not_approved">
                                <i class="fa fa-exclamation-triangle"></i> 
                                <?php echo LANG_CONTENT_NOT_APPROVED; ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

            </div>
            </div>

            <?php if ($index % $columns == 0) { ?>
                <div class="clear"></div>
            <?php } ?>

        <?php $index++; } ?>

    </div>

    <?php if ($perpage < $total) { ?>
        <?php echo html_pagebar($page, $perpage, $total, $page_url, $filters); ?>
    <?php } ?>

<?php } else { echo LANG_LIST_EMPTY; } ?>