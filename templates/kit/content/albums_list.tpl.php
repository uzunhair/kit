<?php
$this->addCSS($this->getStylesFileName('photos'));

if( $ctype['options']['list_show_filter'] ) {
    $this->renderAsset('ui/filter-panel', array(
        'css_prefix'   => $ctype['name'],
        'page_url'     => $page_url,
        'fields'       => $fields,
        'props_fields' => $props_fields,
        'props'        => $props,
        'filters'      => $filters,
        'ext_hidden_params' => $ext_hidden_params,
        'is_expanded'  => $ctype['options']['list_expand_filter']
    ));
}
?>

<?php if ($items){ ?>

    <div class="content_list tiled <?php echo $ctype['name']; ?>_list row">

        <?php foreach($items as $item){ ?>

            <?php
                $item['ctype'] = $ctype;
                $is_private    = $item['is_private'] && $hide_except_title && !$item['user']['is_friend'];
                $stop = 0;
            ?>

            <div class="tile <?php echo $ctype['name']; ?>_list_item col-12 col-sm-6 col-md-4 mb-4">
                <div class="card mb-0 h-100">
                    <div class="photo">
                        <?php if ($is_private) { ?>
                            <?php echo html_image(default_images('private', $ctype['photos_options']['preset_small']), $ctype['photos_options']['preset_small'], $item['title']); ?>
                        <?php } else { ?>
                            <a href="<?php echo href_to($ctype['name'], $item['slug'].'.html'); ?>">
                                <?php if (!empty($item['cover_image']) && !empty($fields['cover_image']['is_in_list'])){ ?>
                                    <?php echo html_image($item['cover_image'], $ctype['photos_options']['preset_small'], $item['title']); ?>
                                    <?php unset($item['cover_image']); ?>
                                <?php } ?>
                            </a>
                        <?php } ?>
                    </div>
                    <div class="p-3">
                    <?php if (!$is_private) { ?>
                        <div class="photos_album_title_wrap">
                            <?php if (!empty($fields['title']['is_in_list'])) { ?>
                                <div class="clear">
                                    <div class="photos_album_title font-size-lg">
                                        <?php if ($item['parent_id']) { ?>
                                            <?php echo htmlspecialchars($item['parent_title']); ?> &rarr;
                                        <?php } ?>
                                        <?php if ($is_private) { ?>
                                            <?php html($item['title']); ?> <span class="is_private font-size-base" title="<?php html(LANG_PRIVACY_PRIVATE); ?>"><i class="fa fa-eye-slash"></i></span>
                                        <?php } else { ?>
                                            <a href="<?php echo href_to($ctype['name'], $item['slug'].'.html'); ?>">
                                            <?php html($item['title']); ?>
                                            <?php if ($item['is_private']) { ?>
                                                <span class="is_private" data-toggle="tooltip" title="<?php html(LANG_PRIVACY_PRIVATE); ?>"><i class="fa fa-eye-slash"></i></span>
                                            <?php } ?>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($item['content'] && !empty($fields['content']['is_in_list'])) { ?>
                                <div class="photos_album_description_wrap">
                                    <div class="photos_album_description">
                                        <?php if (!$fields['content']['groups_read'] || $user->isInGroups($fields['content']['groups_read'])) { ?>
                                            <?php if ($is_private) {
                                                $stop++; ?>
                                            <?php } else { ?>
                                                <?php echo $fields['content']['handler']->setItem($item)->parseTeaser($item['content']); ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php unset($item['cover_image'], $item['content']); ?>

                    <div class="fields">

                    <?php foreach($fields as $field){ ?>

                        <?php if ($stop === 2) { break; } ?>
                        <?php if ($field['is_system'] || !$field['is_in_list'] || !isset($item[$field['name']]) || $field['name'] == 'title') { continue; } ?>
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

                            <div class="value">
                                <?php if ($is_private) { $stop++; ?>
                                     <!--noindex--><div class="private_field_hint"><i class="fa fa-low-vision"></i> <?php echo LANG_PRIVACY_PRIVATE_HINT; ?></div><!--/noindex-->
                                <?php } else { ?>
                                     <?php echo $field['handler']->setItem($item)->parseTeaser($item[$field['name']]); ?>
                                <?php } ?>
                            </div>

                        </div>

                    <?php } ?>

                    </div>

                    <?php
                        $is_tags = $ctype['is_tags'] &&
                                !empty($ctype['options']['is_tags_in_list']) &&
                                $item['tags'];
                    ?>

                    <?php if ($is_tags){ ?>
                        <div class="tags_bar">
                            <?php echo html_tags_bar($item['tags']); ?>
                        </div>
                    <?php } ?>

                    <?php
                        $show_bar = $ctype['is_rating'] ||
                                    $fields['date_pub']['is_in_list'] ||
                                    $fields['user']['is_in_list'] ||
                                    !$item['is_approved'];
                    ?>

                    <?php if ($show_bar){ ?>
                        <div class="info_bar">
                            <?php if ($fields['user']['is_in_list']){ ?>
                                <div class="bar_item bi_user" title="<?php echo $fields['user']['title']; ?>">
                                    <i class="fa fa-user-o"></i>
                                    <?php echo $fields['user']['handler']->parse( $item['user'] ); ?>
                                </div>
                            <?php } ?>
                            <div class="bar_item note">
                                <?php echo html_spellcount($item['photos_count'], LANG_PHOTOS_PHOTO_SPELLCOUNT); ?>
                                <?php if ($item['is_public'] && !empty($fields['is_public']['is_in_list'])) { ?>
                                    / <span><?php echo LANG_PHOTOS_PUBLIC_ALBUM; ?></span>
                                <?php } ?>
                            </div>
                            </div>
                        <div class="info_bar">

                            <?php if ($ctype['is_rating']){ ?>
                                <div class="bar_item bi_rating">
                                    <?php echo $item['rating_widget']; ?>
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
                            <?php if ($fields['date_pub']['is_in_list']){ ?>
                                <div class="bar_item bi_date" title="<?php echo $fields['date_pub']['title']; ?>">
                                    <i class="fa fa-calendar"></i>
                                    <?php echo $fields['date_pub']['handler']->parse($item['date_pub']); ?>
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
            </div>

        <?php } ?>

    </div>

    <?php if ($perpage < $total) { ?>
        <?php echo html_pagebar($page, $perpage, $total, $page_url, array_merge($filters, $ext_hidden_params)); ?>
    <?php } ?>

<?php } else { echo LANG_LIST_EMPTY; } ?>