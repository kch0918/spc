<div class="latest-news swiper-container">
	<ul class="swiper-wrapper">
		<?php while($content = $list->hasNext()):?>
		<li class="swiper-slide">
			<div class="kboard-list-thumbnail">
				<a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>">
				<?php if($content->getThumbnail(571, 262)):?><img src="<?php echo $content->getThumbnail(571, 262)?>" alt="<?php echo esc_attr($content->title)?>"><?php else:?><i class="icon-picture"></i><?php endif?>
				</a>
			</div>
			<div class="kboard-latest-title">
				<a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>">
					<div class="kboard-thumbnail-cut-strings">
						<?php echo $content->title?>
					</div>
				</a>
				<?php if($content->option->{'description'}):?>
				<p><?php echo $content->option->{'description'}?></p>
				<?php endif?>
			</div>
			<div class="kboard-latest-date"><?php echo $content->getDate()?></div>
		</li>
		<?php endwhile?>
	</ul>
</div>