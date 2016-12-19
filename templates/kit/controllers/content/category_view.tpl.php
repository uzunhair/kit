<?php

    $list_header = empty($ctype['labels']['list']) ? $ctype['title'] : $ctype['labels']['list'];
    $page_header = isset($category['title']) ? $category['title'] : $list_header;
    $rss_query = isset($category['id']) ? "?category={$category['id']}" : '';

    $base_url = $ctype['name'];
    $base_ds_url = href_to_rel($ctype['name']) . '-%s' . (isset($category['slug']) ? '/'.$category['slug'] : '');

    if (!$is_frontpage){
		$seo_title = false;
		if (!empty($ctype['seo_title'])){ $seo_title = $ctype['seo_title']; }
		if (!empty($category['seo_title'])){ $seo_title = $category['seo_title']; }
		if (!$seo_title) { $seo_title = $page_header; }
        if (!empty($current_dataset['title'])){ $seo_title .= ' · '.$current_dataset['title']; }
        $this->setPageTitle($seo_title);
    }

    if (!empty($ctype['seo_keys'])){ $this->setPageKeywords($ctype['seo_keys']); }
    if (!empty($ctype['seo_desc'])){ $this->setPageDescription($ctype['seo_desc']); }
    if (!empty($category['seo_keys'])){ $this->setPageKeywords($category['seo_keys']); }
    if (!empty($category['seo_desc'])){ $this->setPageDescription($category['seo_desc']); }
    if (!empty($current_dataset['seo_keys'])){ $this->setPageKeywords($current_dataset['seo_keys']); }
    if (!empty($current_dataset['seo_desc'])){ $this->setPageDescription($current_dataset['seo_desc']); }

    if ($ctype['options']['list_on'] && !$request->isInternal() && !$is_frontpage){
        $this->addBreadcrumb($list_header, href_to($base_url));
    }

    if (isset($category['path']) && $category['path']){
        foreach($category['path'] as $c){
            $this->addBreadcrumb($c['title'], href_to($base_url, $c['slug']));
        }
    }

    if (cmsUser::isAllowed($ctype['name'], 'add')) {

        if (!$category['id'] || $user->isInGroups($category['allow_add'])){

            $href = href_to($ctype['name'], 'add', isset($category['path']) ? $category['id'] : '');

            $this->addToolButton(array(
                'class' => 'add',
                'title' => sprintf(LANG_CONTENT_ADD_ITEM, $ctype['labels']['create']),
                'href'  => $href
            ));

        }

    }

    if ($ctype['is_cats']){
        if (cmsUser::isAllowed($ctype['name'], 'add_cat')) {
            $this->addToolButton(array(
                'class' => 'folder_add',
                'title' => LANG_ADD_CATEGORY,
                'href'  => href_to($ctype['name'], 'addcat', $category['id'])
            ));
        }

        if ($category['id']){

            if (cmsUser::isAllowed($ctype['name'], 'edit_cat')) {
                $this->addToolButton(array(
                    'class' => 'folder_edit',
                    'title' => LANG_EDIT_CATEGORY,
                    'href'  => href_to($ctype['name'], 'editcat', $category['id'])
                ));
            }
            if (cmsUser::isAllowed($ctype['name'], 'delete_cat')) {
                $this->addToolButton(array(
                    'class' => 'folder_delete',
                    'title' => LANG_DELETE_CATEGORY,
                    'href'  => href_to($ctype['name'], 'delcat', $category['id']),
                    'onclick' => "if(!confirm('".LANG_DELETE_CATEGORY_CONFIRM."')){ return false; }"
                ));
            }

        }
    }

    if (cmsUser::isAdmin()){
        $this->addToolButton(array(
            'class' => 'page_gear',
            'title' => sprintf(LANG_CONTENT_TYPE_SETTINGS, mb_strtolower($ctype['title'])),
            'href'  => href_to('admin', 'ctypes', array('edit', $ctype['id']))
        ));
    }

?>

<?php if ($page_header && !$request->isInternal() && !$is_frontpage) { ?>
    <div class="media mb-1">
        <div class="media-body">
            <h1><?php echo $page_header; ?></h1>
        </div>
        <?php if (!empty($ctype['options']['is_rss']) && $this->controller->isControllerEnabled('rss')) { ?>
            <div class="media-right media-middle">
                <a href="<?php echo href_to('rss', 'feed', $ctype['name']) . $rss_query; ?>"><i class="fa fa-rss"></i></a>
            </div>
        <?php } ?>
    </div>
<?php } ?>

<?php if ($datasets && !$is_hide_items){ ?>
    <div class="content_datasets <?php if (!empty($current_dataset['description'])){ echo ' mb-0';} else { echo 'mb-1';} ?>">
        <ul class="nav nav-tabs">
            <?php $ds_counter = 0; ?>
            <?php foreach($datasets as $set){ ?>
                <?php $ds_selected = ($dataset == $set['name'] || (!$dataset && $ds_counter==0)); ?>
                <li class="nav-item">
                    <?php if ($ds_counter > 0) { $ds_url = sprintf(rel_to_href($base_ds_url), $set['name']); } ?>
                    <?php if ($ds_counter == 0) { $ds_url = href_to($base_url, isset($category['slug']) ? $category['slug'] : ''); } ?>
                    <?php if ($ds_selected){ ?>
                        <a class="nav-link active" href="<?php echo $ds_url; ?>"><?php echo $set['title']; ?></a>
                    <?php } else { ?>
                        <a class="nav-link" href="<?php echo $ds_url; ?>"><?php echo $set['title']; ?></a>
                    <?php } ?>
                </li>
                <?php $ds_counter++; ?>
            <?php } ?>
        </ul>
    </div>
    <?php if (!empty($current_dataset['description'])){ ?>
    <div class="content_datasets_description mb-1 p-1">
        <?php echo $current_dataset['description']; ?>
    </div>
    <?php } ?>
<?php } ?>

<?php if (!empty($category['description'])){?>
    <div class="category_description mb-1"><?php echo $category['description']; ?></div>
<?php } ?>

<?php if ($subcats && $ctype['is_cats'] && !empty($ctype['options']['is_show_cats'])){ ?>
    <div class="gui-panel content_categories<?php if (count($subcats)>8){ ?> categories_small<?php } ?> mb-1">
        <ul class="nav nav nav-inline <?php echo $ctype['name'];?>_icon">
            <?php foreach($subcats as $c){ ?>
                <li class="nav-item <?php echo str_replace('/', '-', $c['slug']);?>">
                    <a class="nav-link" href="<?php echo href_to($base_url . ($dataset ? '-'.$dataset : ''), $c['slug']); ?>"><i class="fa fa-folder-o"></i> <?php echo $c['title']; ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>

<?php echo $items_list_html; ?>