<div class="widget<?php if ($widget['class_wrap']) { ?> <?php echo ltrim($widget['class_wrap'], '.');  } ?>">

    <?php if ($widget['title'] && $is_titles){ ?>
        <div class="title d-flex align-items-center <?php if ($widget['class_title']) { ?> <?php echo ltrim($widget['class_title'], '.');  } ?>">
            <span class="mr-auto"><?php echo $widget['title']; ?></span>
            <?php if (!empty($widget['links'])) { ?>
                <div class="links font-size-base">
                    <?php $links = string_parse_list($widget['links']); ?>
                    <?php foreach($links as $link){ ?>
                        <a href="<?php echo (mb_strpos($link['value'], 'http://')===0) ? $link['value'] : href_to($link['value']); ?>"><?php echo $link['id']; ?></a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <div class="body<?php if ($widget['class']) { ?> <?php echo ltrim($widget['class'], '.');  } ?>">
        <?php echo $widget['body']; ?>
    </div>

</div>
