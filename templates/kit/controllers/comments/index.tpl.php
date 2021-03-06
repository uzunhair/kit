<?php

    $base_url = $this->controller->name;

    $this->setPageTitle($dataset ? LANG_COMMENTS . ' - ' . $dataset['title'] : LANG_COMMENTS);
    $this->addBreadcrumb(LANG_COMMENTS, href_to($base_url));

?>

<h1><?php echo LANG_COMMENTS; ?></h1>

<?php if (sizeof($datasets)>1){ ?>
    <div class="content_datasets">
        <ul class="nav nav-tabs mb-3">
            <?php $ds_counter = 0; ?>
            <?php foreach($datasets as $set){ ?>
                <?php $ds_selected = ($dataset_name == $set['name'] || (!$dataset_name && $ds_counter==0)); ?>
                <li class="nav-item<?php if ($ds_selected){ ?> active<?php } ?>">

                    <?php if ($ds_counter > 0) { $ds_url = href_to($base_url, 'index', $set['name']); } ?>
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

<?php echo $items_list_html; ?>