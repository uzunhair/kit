<?php $index = 0; ?>
<?php $index_tab = 0; ?>
<div id="comments_widget" class="tabs-menu mt-3">

    <a name="comments"></a>

    <ul class="nav nav-tabs mb-3" role="tablist">
        <?php foreach ($comment_systems as $comment_system) { ?>
            <?php
                if ($comment_system['name']=='icms') {
                    $tab_fa = '<i class="fa fa-commenting-o"></i>';
                } elseif ($comment_system['name']=='vk') {
                    $tab_fa = '<i class="fa fa-vk"></i>';
                }
            ?>
            <li class="nav-item">
                <a class="nav-link<?php if(!$index_tab){ ?> active<?php } ?>" data-toggle="tab" href="#tabs-<?php echo $comment_system['name']; ?>" title="<?php echo $comment_system['title']; ?>" role="tab">
                    <?php echo $tab_fa; unset($tab_fa); ?>
                    <span class="hidden-xs-down">
                        <?php echo $comment_system['title']; ?>
                    </span>
                </a>
            </li>
            <?php $index_tab++; ?>
        <?php } ?>
    </ul>
    <div class="tab-content">
    <?php foreach ($comment_systems as $comment_system) { ?>
        <div id="tabs-<?php echo $comment_system['name']; ?>" class="tab-pane fade<?php if(!$index){ ?> show active<?php } ?>" role="tabpanel">
            <?php echo $comment_system['html']; ?>
        </div>
        <?php $index++; ?>
    <?php } ?>
    </div>

</div>
<script type="text/javascript">
    $(function (){
        initTabs('#comments_widget');
    });
</script>