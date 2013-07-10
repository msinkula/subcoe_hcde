<?php

function subcoe_hcde_form_system_theme_settings_alter(&$form, $form_state) {

	// first try to save managed_files permanently
	// these will have to be killed manually until
	// Drupal fixes their broken managed_file system
	// see below for issue url
	$background_image_fid = theme_get_setting('background_image_fid');
	if ($background_image_fid) {
		$file = file_load($background_image_fid);
		if ($file) {
			if ($file->status != FILE_STATUS_PERMANENT) {
				$file->status = FILE_STATUS_PERMANENT;
				file_save($file);
			}
		}
	}
	

  /*
   * Create the form using Forms API: http://api.drupal.org/api/6
   */

  	unset($form['theme_settings']);
  	unset($form['favicon']);

	$form['background_image_fid'] = array(
		'#type' => 'managed_file',
		'#title' => t('Background Image'),
		'#default_value' => $background_image_fid,
		'#upload_location' => 'public://images/backgrounds'
	);
	
	// Currently broken
	// see: http://drupal.org/node/1862892
	//$form['#submit'][] = 'subcoe_hcde_theme_settings_submit';

}

function subcoe_hcde_theme_settings_submit($form, &$form_state) {

	drupal_set_message(print_r($form));

	$new_fid = $form['background_image_fid']['#value'];
	$old_fid = theme_get_setting('background_image_fid');

	if ($new_fid == 0) {
		// delete old file because we are removing it
		$file = file_load($old_fid);
		if ($file)
			file_delete($file);
	} else {
		// delete the old file if there is a new one to save
		if ($new_fid != 0 && $new_fid != $old_fid) {
			$file = file_load($old_fid);
			if ($file)
				file_delete($file);
		}
		$file = file_load($new_fid);
		if ($file) {
			if ($file->status != FILE_STATUS_PERMANENT) {
				$file->status = FILE_STATUS_PERMANENT;
				file_save($file);
			}
		}
	}
}


?>