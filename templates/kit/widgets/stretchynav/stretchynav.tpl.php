<?php
    $this->addMainJS($this->getTplFilePath('addons/tether/tether.min.js', false));

    if ($nav_posture == false) {
        $this->addMainJS($this->getJavascriptFileName('jquery'));
        $this->addMainJS($this->getTplFilePath('addons/stretchynav/main.js', false));
    }
    
    if (!isset($this->menus[$widget->options['menu']])) {
        $menu = $this->loadMenus($widget->options['menu']);
        if (!$menu){ return; }
        $this->setMenuItems($widget->options['menu'], $menu);
    }

    $menu = $this->menus[$widget->options['menu']];

    $sn_margin = array();
    if (!empty($top)) {
        $sn_margin[] = 'margin-top:'.$top.';';
    }
    if (!empty($bottom)) {
        $sn_margin[] = 'margin-bottom:'.$bottom.';';
    }
    if (!empty($left)) {
        $sn_margin[] = 'margin-left:'.$left.';';
    }
    if (!empty($right)) {
        $sn_margin[] = 'margin-right:'.$right.';';
    }
    $style = implode(' ', $sn_margin);

    $sn_id = 'cd-stretchy-nav-'.$widget->id;

    $tooltip = ' data-toggle="tooltip" data-placement="'.$tooltip.'" ';
?>
<style>
    .cd-stretchy-nav-<?php echo $widget->id; ?> {
        <?php echo $style; ?>
    }
</style>
<nav class="<?php echo $position.' '. $direction. ' '; echo $sn_id; echo !$nav_posture ? ' stretchy-nav-js ':' nav-is-visible trigger-is-hidden '; ?>cd-stretchy-nav">
    <?php if (!$nav_posture) { ?>
        <a class="cd-nav-trigger" href="#">
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
                $fa_icon = 'fa-file-text-o';
                $link_class = $item['options']['class'];
                if ($widget->options['menu'] == 'toolbar') {
                    if ($link_class == 'add') {
                        $fa_icon = 'fa-file-text-o';
                    } else if ($link_class == 'edit') {
                        $fa_icon = 'fa-pencil /';
                    } else if (strstr($link_class, 'delete')) {
                        $fa_icon = 'fa-trash';
                    } else if (($link_class == 'page_gear') || ($link_class == 'settings') || (strrpos($link_class, '_edit'))) {
                        $fa_icon = 'fa-cogs';
                    } else if (strstr($link_class, 'user_add')) {
                        $fa_icon = 'fa-user-plus';
                    } else if (strrpos($link_class, '_add')) {
                        $fa_icon = 'fa-folder-o';
                    } else if ($link_class == 'images') {
                        $fa_icon = 'fa-picture-o';
                    } else if ($link_class == 'save') {
                        $fa_icon = 'fa-floppy-o';
                    } else if ($link_class == 'cancel') {
                        $fa_icon = 'fa-ban';
                    }
                }

                $item_icon = $fa_icon;

                if (!empty($item['options']['class'])) {
                    if(stristr($item['options']['class'], '/') == true) {
                        $item_class = explode('/', $item['options']['class']);
                        $item_icon = $item_class[0];
                        unset($item_class[0]);
                        $css_classes[] = implode(' ', $item_class);
                    } else {
                        $css_classes[] = $item['options']['class'];
                    }
                }

                $css_classes[] = $text_color;

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
                    <a <?php if ($css_classes) { ?>class="<?php echo implode(' ', $css_classes); ?>"<?php } ?>
                       title="<?php echo html($item['title']); ?>" <?php echo $data_attr; ?> <?php echo $tooltip; ?>
                       href="<?php echo !empty($item['url']) ? htmlspecialchars($item['url']) : 'javascript:void(0)'; ?>"
                       <?php if ($onclick) { ?>onclick="<?php echo $onclick; ?>"<?php } ?>
                       <?php if ($target) { ?>target="<?php echo $target; ?>"<?php } ?>>
                        <?php if (!empty($item_icon)) { ?>
                            <i class="fa fa-fw <?php echo $item_icon; ?>"></i>
                        <?php } unset($item_icon) ?>
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