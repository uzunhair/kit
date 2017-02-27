<div id="content_bind_form" data-filter-url="<?php echo href_to($ctype['name'], 'bind_list', array($child_ctype['name'], $item['id'])); ?>?selected=<?php echo $selected_ids; ?>" data-mode="<?php echo $mode; ?>">

    <div class="find gui-panel">
        <div class="field row">
            <div class="col-6">
			    <?php echo html_select('item-find-field', $filter_fields, '', array('id'=>'item-find-field')); ?>
            </div>
            <div class="col-6">
                <?php echo html_input('text', 'item-find-input', '', array('id'=>'item-find-input', 'placeholder' => LANG_CONTENT_BIND_ITEM_FIND_HINT)); ?>
            </div>
        </div>
        <div class="loading-icon" style="display: none"></div>
    </div>

	<div class="filter-tabs my-3">
		<ul class="pills-menu nav nav-pills">
			<li class="active nav-item">
				<a href="#own" data-mode="own" class="nav-link active"><?php echo LANG_CONTENT_OWN_ITEMS; ?></a>
			</li>
			<li class="nav-item">
				<a href="#all" data-mode="all" class="nav-link"><?php echo LANG_ALL; ?></a>
			</li>
		</ul>
	</div>

	<div class="result-pane">
		<div class="loading"></div>
	</div>

	<div class="buttons mt-3">
        <?php $button_title = $input_action == 'bind' ? ($mode == 'unbind' ? LANG_CONTENT_UNBIND_ITEMS : LANG_CONTENT_BIND_ITEMS) : LANG_SELECT; ?>
		<input type="submit" name="submit" class="button-submit btn btn-secondary" value="<?php echo $button_title; ?>" data-title="<?php echo $button_title; ?>">
	</div>

    <form action="<?php echo href_to($ctype['name'], $mode == 'unbind' ? 'unbind' : 'bind', $child_ctype['name']); ?>" method="post" style="display:none">
        <input type="hidden" class="item_id" name="id" value="<?php echo $item['id']; ?>">
        <input type="hidden" class="selected_ids" name="selected_ids" value="<?php echo $item['id']; ?>">
    </form>

</div>

<?php if ($mode == 'childs' || $mode == 'unbind') { ?>
    <?php $this->insertJS('templates/kit/js/content-bind.js'); ?>
    <script>icms.contentBind.start();</script>
<?php } ?>
