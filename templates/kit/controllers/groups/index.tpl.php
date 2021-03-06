<?php

    $base_url = $this->controller->name;
    $base_ds_url = href_to_rel($this->controller->name) . '/index/%s';

    $this->setPageTitle(LANG_GROUPS);
    $this->addBreadcrumb(LANG_GROUPS, href_to($base_url));

    if (cmsUser::isAllowed('groups', 'add')) {
        $this->addToolButton(array(
            'class' => 'add',
            'title' => LANG_GROUPS_ADD,
            'href'  => $this->href_to('add'),
        ));
    }

    if (cmsUser::isAdmin()){
        $this->addToolButton(array(
            'class' => 'page_gear',
            'title' => LANG_GROUPS_SETTINGS,
            'href'  => href_to('admin', 'controllers', array('edit', 'groups'))
        ));
    }

?>

<h1><?php echo LANG_GROUPS; ?></h1>

<?php if (sizeof($datasets)>1){ ?>
    <div class="content_datasets mb-3">
        <ul class="nav nav-tabs">
            <?php $ds_counter = 0; ?>
            <?php foreach($datasets as $set){ ?>
                <?php $ds_selected = ($dataset_name == $set['name'] || (!$dataset_name && $ds_counter==0)); ?>
                <li class="nav-item">

                    <?php if ($ds_counter > 0) { $ds_url = sprintf(rel_to_href($base_ds_url), $set['name']); } ?>
                    <?php if ($ds_counter == 0) { $ds_url = href_to($base_url); } ?>

                    <?php if ($ds_selected){ ?>
                        <div class="nav-link active"><?php echo $set['title']; ?></div>
                    <?php } else { ?>
                        <a class="nav-link" href="<?php echo $ds_url; ?>"><?php echo $set['title']; ?></a>
                    <?php } ?>

                </li>
                <?php $ds_counter++; ?>
            <?php } ?>
        </ul>
    </div>
<?php } ?>

<?php echo $groups_list_html;
