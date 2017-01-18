<?php

$user = cmsUser::getInstance();

$is_tags = $ctype['is_tags'] && !empty($ctype['options']['is_tags_in_item']) && $item['tags'];

$show_bar = $is_tags || $item['parent_id'] ||
            $fields['date_pub']['is_in_item'] ||
            $fields['user']['is_in_item'] ||
            !empty($ctype['options']['hits_on']);

?>

<?php if ($fields['title']['is_in_item']){ ?>
    <h1>
        <?php if ($fields['user']['is_in_item'] && !empty($item['folder_title'])){ ?>
            <a href="<?php echo href_to('users', $item['user']['id'], array('content', $ctype['name'], $item['folder_id'])); ?>"><?php echo $item['folder_title']; ?></a>&nbsp;&rarr;&nbsp;
        <?php } ?>
        <?php html($item['title']); ?>
        <?php if ($item['is_private']) { ?>
            <span class="is_private" data-toggle="tooltip" title="<?php html(LANG_PRIVACY_PRIVATE); ?>"><i class="fa fa-eye-slash"></i></span>
        <?php } ?>
    </h1>
    <?php if ($show_bar){ ?>
        <h2 class="parent_title media mb-3">
            <?php if ($fields['user']['is_in_item']){ ?>
                <div class="d-flex mr-3 album_user ">
                    <a href="<?php echo href_to('users', $item['user']['id']); ?>">
                        <?php echo html_avatar_image($item['user']['avatar'], 'micro', $item['user']['nickname']); ?>
                    </a>
                </div>
            <?php } ?>
            <div class="media-body align-self-center font-size-base">
                <div class="info_bar mt-0">
                    <?php if ($fields['user']['is_in_item']){ ?>
                        <div class="bar_item">
                            <i class="fa fa-user-o"></i>
                            <?php echo $fields['user']['html']; ?>
                        </div>
                    <?php } ?>
                    <?php if ($fields['date_pub']['is_in_item']){ ?>
                        <span class="bar_item album_date" title="<?php html( $fields['date_pub']['title'] ); ?>">
                            <?php if (!$item['is_pub']){ ?>
                                <span class="bi_not_pub">
                                    <i class="fa fa-exclamation-triangle"></i>
                                    <?php echo LANG_CONTENT_NOT_IS_PUB; ?>
                                </span>
                            <?php } else { ?>
                                <i class="fa fa-calendar"></i>
                                <?php echo $fields['date_pub']['html']; ?>
                            <?php } ?>
                        </span>
                    <?php } ?>
                    <?php if (!empty($ctype['options']['hits_on']) && $item['hits_count']){ ?>
                        <div class="bar_item album_hits">
                            <?php echo html_spellcount($item['hits_count'], LANG_HITS_SPELL); ?>
                        </div
                    <?php } ?>
                    <?php if ($item['parent_id']){ ?>
                        <div class="bar_item">
                            <a href="<?php echo rel_to_href($item['parent_url']); ?>"><?php html($item['parent_title']); ?></a>
                        </div>
                    <?php } ?>
                    <?php if ($is_tags){ ?>
                        <div class="bar_item tags_bar"> <i class="fa fa-tags"></i> <?php echo html_tags_bar($item['tags']); ?></div>
                    <?php } ?>
                </div>
            </div>
        </h2>
    <?php } ?>
    <?php unset($fields['title']); ?>
<?php } ?>

<div class="photo_filter mb-3">
    <form action="<?php echo $item['base_url']; ?>" method="get">
        <div class="navbar navbar-inverse bg-inverse navbar-toggleable-md">
        <ul class="nav navbar-nav">
            <li class="nav-item dropdown<?php echo !isset($item['filter_selected']['ordering']) ?'': ' active'; ?>">
                <a href="#" title="<?php echo LANG_SORTING; ?>" class="nav-link dropdown-toggle" id="filter-ordering" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $item['filter_panel']['ordering'][$item['filter_values']['ordering']]; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="filter-ordering">
                    <?php foreach($item['filter_panel']['ordering'] as $value => $name){ ?>
                        <?php $url_params = $item['url_params']; $url_params['ordering'] = $value; ?>
                        <a class="dropdown-item" href="<?php echo href_to($ctype['name'], $item['slug'].'.html?'.http_build_query($url_params)); ?>">
                            <?php echo $name; ?>
                            <?php if($item['filter_values']['ordering'] == $value){ ?>
                                <input type="hidden" name="ordering" value="<?php echo $value; ?>">
                                <i class="check">&larr;</i>
                            <?php } ?>
                        </a>
                    <?php } ?>
                </div>
            </li>
            <?php if($item['filter_panel']['types']){ ?>
                <li class="nav-item dropdown<?php echo !isset($item['filter_selected']['types']) ?'': ' active'; ?>">
                    <a href="#" class="nav-link dropdown-toggle" id="filter-types" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $item['filter_panel']['types'][$item['filter_values']['types']]; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="filter-types">
                        <?php foreach($item['filter_panel']['types'] as $value => $name){ ?>
                            <?php $url_params = $item['url_params']; $url_params['types'] = $value; ?>
                            <a class="dropdown-item" href="<?php echo href_to($ctype['name'], $item['slug'].'.html?'.http_build_query($url_params)); ?>">
                                <?php echo $name; ?>
                                <?php if($item['filter_values']['types'] == $value){ ?>
                                    <input type="hidden" name="types" value="<?php echo $value; ?>">
                                    <i class="check">&larr;</i>
                                <?php } ?>
                            </a>
                        <?php } ?>
                    </div>
                </li>
            <?php } ?>

            <li  class="nav-item dropdown<?php echo !isset($item['filter_selected']['orientation']) ?'': ' active'; ?>">
                <a href="#" class="nav-link dropdown-toggle" id="filter-orientation" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $item['filter_panel']['orientation'][$item['filter_values']['orientation']]; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="filter-orientation">
                    <?php foreach($item['filter_panel']['orientation'] as $value => $name){ ?>
                        <?php $url_params = $item['url_params']; $url_params['orientation'] = $value; ?>
                        <a class="dropdown-item" href="<?php echo href_to($ctype['name'], $item['slug'].'.html?'.http_build_query($url_params)); ?>">
                            <?php echo $name; ?>
                            <?php if($item['filter_values']['orientation'] == $value){ ?>
                                <input type="hidden" name="orientation" value="<?php echo $value; ?>">
                                <i class="check">&larr;</i>
                            <?php } ?>
                        </a>
                    <?php } ?>
                </div>
            </li>
            <li class="nav-item dropdown<?php if($item['filter_values']['width'] || $item['filter_values']['height']){ ?> active<?php } ?>">
                <a href="#" class="nav-link dropdown-toggle" id="filter-size" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if($item['filter_values']['width'] || $item['filter_values']['height']){ ?>
                        <span class="box_menu"><?php echo LANG_PHOTOS_MORE_THAN; ?> <?php html($item['filter_values']['width']); ?> x <?php html($item['filter_values']['height']); ?></span>
                    <?php } else { ?>
                        <?php echo LANG_PHOTOS_SIZE; ?>
                    <?php } ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="filter-size">
                    <div class="size_search_params p-3">
                        <fieldset>
                            <legend class="font-size-lg"><?php echo LANG_PHOTOS_MORE_THAN; ?></legend>
                            <div class="field">
                                <label for="birth_date"><?php echo LANG_PHOTOS_SIZE_W; ?></label>
                                <input type="text" name="width" value="<?php html($item['filter_values']['width']); ?>" placeholder="px" class="form-control">
                            </div>
                            <div class="field mt-3">
                                <label for="birth_date"><?php echo LANG_PHOTOS_SIZE_H; ?></label>
                                <input type="text" name="height" value="<?php html($item['filter_values']['height']); ?>" placeholder="px" class="form-control">
                            </div>
                        </fieldset>
                        <div class="buttons mt-3">
                            <input type="submit" class="button btn btn-secondary" value="<?php echo LANG_FIND; ?>">
                        </div>
                    </div>
                </div>
            </li>
            <?php if($item['filter_selected']) { ?>
            <li class="nav-item">
                <a title="<?php echo LANG_PHOTOS_CLEAR_FILTER; ?>" class="nav-link clear_filter" href="<?php echo href_to($ctype['name'], $item['slug'].'.html'); ?>">
                    <i class="fa fa-close"></i>
                </a>
            </li>
            <?php } ?>
        </ul>
        </div>
    </form>
</div>

<div class="content_item <?php echo $ctype['name']; ?>_item">

    <?php foreach($fields as $name=>$field){ ?>

        <?php if (!$field['is_in_item'] || $field['is_system']) { continue; } ?>
        <?php if ((empty($item[$field['name']]) || empty($field['html'])) && $item[$field['name']] !== '0') { continue; } ?>
        <?php if ($field['groups_read'] && !$user->isInGroups($field['groups_read'])) { continue; } ?>

        <div class="field mb-3 echo $field['type']; ?> f_<?php echo $field['name']; ?> <?php echo $field['options']['wrap_type']; ?>_field" <?php if($field['options']['wrap_width']){ ?> style="width: <?php echo $field['options']['wrap_width']; ?>;"<?php } ?>>
            <?php if ($field['options']['label_in_item'] != 'none'){ ?>
                <div class="title_<?php echo $field['options']['label_in_item']; ?>"><?php html($field['title']); ?>: </div>
            <?php } ?>
            <div class="value"><?php echo $field['html']; ?></div>
        </div>

    <?php } ?>

    <?php if ($props && array_filter((array)$props_values)) { ?>
        <?php
            $props_fields = $this->controller->getPropsFields($props);
            $props_fieldsets = cmsForm::mapFieldsToFieldsets($props);
        ?>
        <div class="content_item_props <?php echo $ctype['name']; ?>_item_props">
            <table class="table table-bordered table-sm">
                <tbody>
                    <?php foreach($props_fieldsets as $fieldset){ ?>
                        <?php if ($fieldset['title']){ ?>
                            <tr>
                                <td class="table-active" colspan="2"><?php html($fieldset['title']); ?></td>
                            </tr>
                        <?php } ?>
                        <?php if ($fieldset['fields']){ ?>
                            <?php foreach($fieldset['fields'] as $prop){ ?>
                                <?php if (isset($props_values[$prop['id']])) { ?>
                                <?php $prop_field = $props_fields[$prop['id']]; ?>
                                    <tr>
                                        <td class="title"><?php html($prop['title']); ?></td>
                                        <td class="value">
                                            <?php echo $prop_field->setItem($item)->parse($props_values[$prop['id']]); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>

    <?php
        $hooks_html = cmsEventsManager::hookAll("content_{$ctype['name']}_item_html", $item);
        if ($hooks_html) { echo html_each($hooks_html); }
    ?>

    <?php if ($ctype['item_append_html']){ ?>
        <div class="append_html"><?php echo $ctype['item_append_html']; ?></div>
    <?php } ?>

    <div class="info_bar">
        <?php if (!empty($item['rating_widget'])){ ?>
            <div class="bar_item bi_rating">
                <?php echo $item['rating_widget']; ?>
            </div>
        <?php } ?>
        <div class="bar_item bi_share">
            <div class="share">
                <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                <script src="//yastatic.net/share2/share.js"></script>
                <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,gplus,twitter,lj,tumblr,viber,whatsapp,skype,telegram" data-size="s"></div>
            </div>
        </div>
        <?php if (!$item['is_approved']){ ?>
            <div class="bar_item bi_not_approved">
                <i class="fa fa-exclamation-triangle"></i> 
                <?php echo LANG_CONTENT_NOT_APPROVED; ?>
            </div>
        <?php } ?>
    </div>

</div>