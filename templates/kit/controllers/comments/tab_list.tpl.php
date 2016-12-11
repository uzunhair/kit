<?php $index = 0; ?>
<div id="comments_widget" class="tabs-menu">

    <a name="comments"></a>

    <ul class="nav nav-tabs tabbed mb-1">
        <?php foreach ($comment_systems as $comment_system) { ?>
            <?php
                if ($comment_system['name']=='icms') {
                    $tab_fa = '<i class="fa fa-commenting-o"></i>';
                } elseif ($comment_system['name']=='vk') {
                    $tab_fa = '<i class="fa fa-vk"></i>';
                }
            ?>
            <li class="nav-item">
                <a class="nav-link" href="#tab-<?php echo $comment_system['name']; ?>" title="<?php echo $comment_system['title']; ?>">
                    <?php echo $tab_fa; unset($tab_fa); ?>
                    <span class="hidden-xs-down">
                        <?php echo $comment_system['title']; ?>
                    </span>
                </a>
            </li>
        <?php } ?>
    </ul>
    <?php foreach ($comment_systems as $comment_system) { ?>
        <div id="tab-<?php echo $comment_system['name']; ?>" class="tab position-r" <?php if($index){ ?>style="display: none;"<?php } ?>>
            <?php echo $comment_system['html']; ?>
        </div>
        <?php $index++; ?>
    <?php } ?>

</div>
<script type="text/javascript">
    $(function (){
        initTabs('#comments_widget');
    });
</script>