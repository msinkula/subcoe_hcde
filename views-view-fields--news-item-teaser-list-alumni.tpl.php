<?php

$title = ($fields['field_short_title']) ? strip_tags($fields['field_short_title']->content) : $row->node_title;
$title = html_entity_decode($title, ENT_QUOTES);

$type = "alumni/profiles";

$link = ($row->field_field_url) ? 
	"<a href=\"" . $row->field_field_url[0]['rendered']['#markup'] . "\">$title</a>" : 
	l($title, $type.'/'.hcde_title2url($row->node_title));

?>
<div style="clear: both; margin: 20px 0;">
	<?php if ($fields['field_thumbnail'] || $fields['field_image']): ?>
		<div class="field-thumbnail">
			<?php if ($fields['field_thumbnail']): ?>
				<?php echo $fields['field_thumbnail']->content; ?>
			<?php else: ?>
				<?php echo $fields['field_image']->content; ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<span style="font-size: smaller; font-style: italic;">
		<em><?php echo $fields['created']->content; ?></em>
	</span>
	<br />
	<strong>
		<?php echo $link; ?>.
	</strong>
	<?php if ($fields['field_url']): ?>
		<img src="/files/icon_external_site.gif">
	<?php endif; ?>
	<br />
	<?php echo strip_tags($fields['field_blurb']->content); ?>
	<?php if (!$fields['field_url']): ?>
		<?php echo l("Read more", $type.'/'.hcde_title2url($row->node_title)); ?>.
	<?php endif; ?>
</div>
