<ul class="list-group">
	<?php if ($total) { ?>
		<?php foreach($items as $item) { ?>
            <?php
                $url = $mode == 'childs' ?
                        href_to($child_ctype['name'], $item['slug'].'.html') :
                        href_to($ctype['name'], $item['slug'].'.html');
            ?>
			<li data-id="<?php echo $item['id']; ?>" class="list-group-item">
                <div class="media-body">
                    <div class="title">
                        <a href="<?php echo $url; ?>" target="_blank"><?php html($item['title']); ?></a>
                    </div>
                    <div class="details">
                        <span class="user mr-2">
                            <a href="<?php echo href_to('users', $item['user']['id']); ?>"><i class="fa fa-user"></i> <?php html($item['user']['nickname']); ?></a>
                        </span>
                        <span class="date"><i class="fa fa-calendar"></i> <?php echo html_date_time($item['date_pub']); ?></span>
                    </div>
                </div>
                <div class="add ml-3 d-flex align-items-center">
                    <input type="button" class="button btn btn-secondary" value="<?php if ($mode == 'unbind') { ?>X<?php } else { ?>+<?php } ?>">
                </div>
			</li>
		<?php } ?>
	<?php } ?>
</ul>