<?php
	$counter = 1;
?>

<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
	<?php 
	  	if (strstr($row, "field-thumbnail")) {
	  		$counter++;
	  		$classes_array[$id] .= $counter % 2 == 0 ? " rightfocus" : " leftfocus";
	  	}
  	?>
  <div <?php if ($classes_array[$id]) { print 'class="' . $classes_array[$id] .'"';  } ?>>
    <?php print $row; ?>
  </div>
<?php endforeach; ?>