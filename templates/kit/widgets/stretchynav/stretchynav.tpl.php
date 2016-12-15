
<?php $this->addMainJS("templates/{$this->name}/addons/tether/tether.min.js"); ?>
<?php $this->addJS("templates/{$this->name}/addons/navigation/main.js"); ?>



<?php

//echo $menu_id;
//echo $today;
//?>


<nav class="cd-stretchy-nav">
    <a class="cd-nav-trigger" href="#0">
        <span aria-hidden="true"></span>
    </a>
    <ul>
        <?php foreach ($menu as $id => $item) { ?>

            <?php if ($item['level'] == 1) { ?>

                <?php

                $link_class = $item['options']['class'];

                if ($link_class == 'add') {
                   $fa_icon = 'fa fa-file-text-o';
                }
                else if ($link_class == 'edit') {
                    $fa_icon = 'fa fa-pencil';
                }
                else if (strstr($link_class, 'delete')) {
                    $fa_icon = 'fa fa-trash';
                }
                else if (($link_class == 'page_gear') || ($link_class == 'settings') || (strrpos($link_class, '_edit'))) {
                    $fa_icon = 'fa fa-cogs';
                }
                else if (strrpos($link_class, '_add')) {
                    $fa_icon = 'fa fa-folder-o';
                }
                else if ($link_class == 'images') {
                    $fa_icon = 'fa fa-picture-o';
                }
                else if ($link_class == 'save') {
                    $fa_icon = 'fa fa-floppy-o';
                }
                else if ($link_class == 'cancel') {
                    $fa_icon = 'fa fa-ban';
                }

                unset($link_class);

                $css_classes = array();

                if (!empty($item['options']['class'])) {
                    $css_classes[] = $item['options']['class'];
                }

                $onclick = isset($item['options']['onclick']) ? $item['options']['onclick'] : false;
                $onclick = isset($item['options']['confirm']) ? "return confirm('{$item['options']['confirm']}')" : $onclick;

                $target = isset($item['options']['target']) ? $item['options']['target'] : false;
                $data_attr = '';
                if (!empty($item['data'])) {
                    foreach ($item['data'] as $key => $val) {
                        $data_attr .= 'data-' . $key . '="' . $val . '" ';
                    }
                }
                ?>

                <li <?php if ($css_classes) { ?>class="<?php echo implode(' ', $css_classes); ?>"<?php } ?>>
                    <a data-toggle="tooltip" data-placement="left"
                       title="<?php echo html($item['title']); ?>" <?php echo $data_attr; ?>
                       href="<?php echo !empty($item['url']) ? htmlspecialchars($item['url']) : 'javascript:void(0)'; ?>"
                       <?php if ($onclick) { ?>onclick="<?php echo $onclick; ?>"<?php } ?>
                       <?php if ($target) { ?>target="<?php echo $target; ?>"<?php } ?>>
                        <i class="fa <?php echo $fa_icon; ?>">
                            <?php if (isset($item['counter']) && $item['counter']) { ?>
                                <span class="counter"><?php html($item['counter']); ?></span>
                            <?php } ?>
                        </i>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>
    <span aria-hidden="true" class="stretchy-nav-bg <?php echo $bg_color; ?>"></span>
</nav>

