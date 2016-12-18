<?php $this->addMainJS("templates/{$this->name}/addons/tether/tether.min.js"); ?>
<?php if ($nav_posture == false) { ?>
    <?php $this->addJS("templates/{$this->name}/addons/navigation/main.js"); ?>
<?php } ?>
<?php
if (!isset($this->menus[$widget->options['menu']])) {
    $menu = $this->loadMenus($widget->options['menu']);
    if (!$menu){ return; }
    $this->setMenuItems($widget->options['menu'], $menu);
}

$menu = $this->menus[$widget->options['menu']];
?>
<nav class="cd-stretchy-nav <?php echo $position; ?>" <?php if (($tooltip_pos=='left') || ($tooltip_pos=='right')){ ?>style="top:<?php echo $off_top; ?>%"<?php } ?>>
    <?php if ($nav_posture == false) { ?>
        <a class="cd-nav-trigger" href="#0">
            <span aria-hidden="true" class="<?php echo $trigger_color; ?>"></span>
        </a>
    <?php } ?>
    <ul>
        <?php if ($nav_posture == false) { ?>
            <?php $stretchy_count = 0; $margin_next = 0; $margin_last = 0; ?>
            <?php foreach ($menu as $id => $item) { ?>
                <?php if ($item['level'] == 1) { ?>
                    <?php $stretchy_count++; ?>
                <?php } ?>
            <?php } ?>

            <?php
                if($stretchy_count%2 !== 0) {
                    $stretchy_count++;
                    $margin_last++;
                }
            ?>
        <?php }?>
        <?php foreach ($menu as $id => $item) { ?>
            <?php if ($item['level'] == 1) { ?>
                <?php
                $css_classes = array();
                $fa_icon = 'fa fa-file-text-o';
                $link_class = $item['options']['class'];
                if ($widget->options['menu'] == 'toolbar') {
                    if ($link_class == 'add') {
                        $fa_icon = 'fa fa-file-text-o';
                    } else if ($link_class == 'edit') {
                        $fa_icon = 'fa fa-pencil';
                    } else if (strstr($link_class, 'delete')) {
                        $fa_icon = 'fa fa-trash';
                    } else if (($link_class == 'page_gear') || ($link_class == 'settings') || (strrpos($link_class, '_edit'))) {
                        $fa_icon = 'fa fa-cogs';
                    } else if (strstr($link_class, 'user_add')) {
                        $fa_icon = 'fa fa-user-plus';
                    } else if (strrpos($link_class, '_add')) {
                        $fa_icon = 'fa fa-folder-o';
                    } else if ($link_class == 'images') {
                        $fa_icon = 'fa fa-picture-o';
                    } else if ($link_class == 'save') {
                        $fa_icon = 'fa fa-floppy-o';
                    } else if ($link_class == 'cancel') {
                        $fa_icon = 'fa fa-ban';
                    }
                } else {
                    if(stristr($link_class, 'fa-')) {
                        $fa_icon = '';
                    }
                }

                if (!empty($item['options']['class'])) {
                    $css_classes[] = $item['options']['class'];
                }
                $css_classes[] = $text_color;
                $css_classes[] = $fa_icon;

                $onclick = isset($item['options']['onclick']) ? $item['options']['onclick'] : false;
                $onclick = isset($item['options']['confirm']) ? "return confirm('{$item['options']['confirm']}')" : $onclick;

                $target = isset($item['options']['target']) ? $item['options']['target'] : false;
                $data_attr = '';
                if (!empty($item['data'])) {
                    foreach ($item['data'] as $key => $val) {
                        $data_attr .= 'data-' . $key . '="' . $val . '" ';
                    }
                }
                $nav_item = '';
                if ($nav_posture == false) {
                    $margin_next++;
                    $margin_last++;

                    if (($stretchy_count / $margin_last == 1) || ($stretchy_count - 1 == 1)) {
                        if ($stretchy_count - $margin_next == 1) {
                            $nav_item = 'stretchy-li';
                        }
                    }

                    if ($margin_next > 1) {
                        if ($stretchy_count / $margin_next == 2) {
                            $nav_item = 'stretchy-li';
                        }
                    }
                }
                ?>

                <li <?php if ($nav_item); { ?>class="<?php echo $nav_item; ?>"<?php } ?>>
                    <a <?php if ($css_classes) { ?>class="<?php echo implode(' ', $css_classes); ?>"<?php } ?> data-toggle="tooltip" data-placement="<?php echo $tooltip_pos; ?>"
                       title="<?php echo html($item['title']); ?>" <?php echo $data_attr; ?>
                       href="<?php echo !empty($item['url']) ? htmlspecialchars($item['url']) : 'javascript:void(0)'; ?>"
                       <?php if ($onclick) { ?>onclick="<?php echo $onclick; ?>"<?php } ?>
                       <?php if ($target) { ?>target="<?php echo $target; ?>"<?php } ?>>
                            <?php if (isset($item['counter']) && $item['counter']) { ?>
                                <span class="counter"><?php html($item['counter']); ?></span>
                            <?php } ?>
                    </a>
                </li>
                <?php unset($nav_item); ?>
            <?php } ?>
        <?php } ?>
    </ul>
    <span aria-hidden="true" class="stretchy-nav-bg <?php echo $bg_color.' '.$border;?>"></span>
</nav>
