<ul class="nav flex-column">

    <?php $last_level = 0; ?>

    <?php foreach($menu as $id=>$item){ ?>

        <?php for ($i=0; $i<($last_level - $item['level']); $i++) { ?>
            </li></ul>
        <?php } ?>

        <?php if ($item['level'] <= $last_level) { ?>
            </li>
        <?php } ?>

        <?php

            $is_active = in_array($id, $active_ids);

            $css_classes = array();
            if ($item['childs_count'] > 0) { $css_classes[] = 'dropdown'; }
            if ($item['level'] ==1 ) { $css_classes[] = 'nav-item';}

            $onclick = isset($item['options']['onclick']) ? $item['options']['onclick'] : false;
            $onclick = isset($item['options']['confirm']) ? "return confirm('{$item['options']['confirm']}')" : $onclick;

            $target = isset($item['options']['target']) ? $item['options']['target'] : false;
            $data_attr = '';
            if (!empty($item['data'])) {
                foreach ($item['data'] as $key=>$val) {
                    $data_attr .= 'data-'.$key.'="'.$val.'" ';
                }
            }

            $css_classes_link = array();
            if ($is_active) { $css_classes_link[] = 'active'; }
            if ($item['level'] == 1) { $css_classes_link[] = 'nav-link';}
            if ($item['level'] > 1) {$css_classes_link[] = 'dropdown-item';}

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

        ?>

        <li <?php if ($css_classes) { ?>class="<?php echo implode(' ', $css_classes); ?>"<?php } ?>>
            <?php if ($item['disabled']) { ?>
                <span class="item disabled"><?php html($item['title']); ?></span>
            <?php } else { ?>
                <a <?php if (!empty($item['title'])) { ?>title="<?php echo html($item['title']); ?>"<?php } ?>
                   <?php if ($css_classes_link) { ?>class="<?php echo implode(' ', $css_classes_link); ?>"<?php } ?> <?php echo $data_attr; ?>
                   href="<?php echo !empty($item['url']) ? htmlspecialchars($item['url']) : 'javascript:void(0)'; ?>"
                   <?php if ($onclick) { ?>onclick="<?php echo $onclick; ?>"<?php } ?>
                   <?php if ($target) { ?>target="<?php echo $target; ?>"<?php } ?>>

                    <?php if (!empty($item_icon)) { ?>
                        <i class="fa pr-1 <?php echo $item_icon; ?>"></i>
                    <?php } unset($item_icon) ?>

                    <span class="wrap">
                        <?php if (!empty($item['title'])) { html($item['title']); } ?>
                        <?php if (isset($item['counter']) && $item['counter']){ ?>
                            <span class="counter"><?php html($item['counter']); ?></span>
                        <?php } ?>
                    </span>
                </a>
            <?php } ?>

            <?php if ($item['childs_count'] > 0) { ?><ul class="dropdown-menu"><?php } ?>

        <?php $last_level = $item['level']; ?>

    <?php } ?>

    <?php for ($i=0; $i<$last_level; $i++) { ?>
        </li></ul>
    <?php } ?>

