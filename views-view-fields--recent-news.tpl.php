<?php

$title = ($row->field_field_short_title) ? 
		$row->field_field_short_title[0]['rendered']['#markup'] :
		$row->node_title;

$alumni = strip_tags($fields['field_alumni_profiles']->content) == 'Alumni Profile';
$cap    = strip_tags($fields['field_cap_news']->content) == 'CAP News Item';

$type = ($alumni) ? "alumni/profiles" : (($cap) ? "cap/news" : "news");

$link = ($row->field_field_url) ? 
	"<a href=\"" . $row->field_field_url[0]['rendered']['#markup'] . "\">$title</a>" : 
	l($title, $type.'/'.hcde_title2url($row->node_title));
?>
<p>
	<strong>&gt;&gt;
	<?php echo $link; ?>.
	<?php if ($row->field_field_url): ?>
		<img src="/files/icon_external_site.gif">
	<?php endif; ?>
	</strong>
	<?php echo $row->field_field_blurb[0]['rendered']['#markup']; ?>
</p>