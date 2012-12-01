<?php namespace tinyPHP\Classes\Libraries;
/**
 *
 * Messages Library
 *  
 * PHP 5
 *
 * tinyPHP(tm) : Simple & Lightweight MVC Framework (http://tinyphp.us/)
 * Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 * @link http://tinyphp.us/ tinyPHP(tm) Project
 * @since tinyPHP(tm) v 0.1
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');

class Messages {
	
	public function __construct() {}
	
	public static function notice($num) {
		$msg[1] = _t('Your message has been sent and someone will contact you as soon as possible.');
		$msg[2] = _t('Sorry, all fields must be filled in before you can submit the form.');
		$msg[3] = _t('Sorry, your topic could not be posted. Please try again.');
		$msg[4] = _t('You forgot to choose a message to delete. Go back and try again.');
		$msg[5] = _t('Sorry, your reply could not be updated.');
		$msg[6] = _t('Message successfully sent!');
		$msg[7] = _t('Error, couldn\'t send PM. Maybe wrong user.');
		$msg[8] = _t('Message successfully deleted!');
		$msg[9] = _t('Error, couldn\'t delete PM!');
		$msg[10] = _t('Your new member has been added and was sent an email with new account details.');
		$msg[11] = _t('Sorry, the new user could not be added. Please try again.');
		$msg[12] = _t('Your news posting has been deleted. Go back to your the main news page.');
		$msg[13] = _t('You forgot to choose a news posting to delete.  Go back to the main news page and try again.');
		$msg[15] = _t('The user has been updated successfully.');
		$msg[16] = _t('The user was not updated, please try again.');
		$msg[17] = _t('News item updated successfully.');
		$msg[18] = _t('An error occurred. Please check your post and try again.');
		$msg[19] = _t('The file you are trying to upload is not a .zip file. Please try again.');
		$msg[20] = _t('Your plugin was uploaded and installed properly.');
		$msg[21] = _t('There was a problem uploading your plugin. Please try again or check the plugin package.');
		$msg[22] = _t('The re-install was successful.');
		$msg[23] = _t('There was an error with the re-install. It is better that you download the full version and overwrite the files on your server manually.');
		$msg[24] = _t('Your system was upgraded to the latest version.');
		$msg[25] = _t('There was an error upgrading to the latest version. It is better that you download the full version and overwrite the files on your server manually.');
		$msg[26] = _t('Sorry, your user type was not added. Please try again.');
		$msg[27] = _t('There was an error uploading the file, please try again!');
		$msg[28] = _t('File name is not valid or the file was more than ' . $max_file_size . ' bytes. Go back to try again.');
		$msg[29] = _t('You profile was updated successfully.');
		$msg[30] = _t('Your profile could not be updated. Please try again.');
		$msg[31] = _t('Your password has been updated.');
		$msg[32] = _t('Sorry, your password cannot be blank.');
		$msg[33] = _t('The project has been added.');
		$msg[34] = _t('Project name, description, type, and email must be filled out before submitting the form.');
		$msg[35] = _t('Your project has been updated.');
		$msg[36] = _t('Your project was unable to be updated. Please try again.');
		$msg[37] = _t('Your username or password was entered incorreclty. Please go back and try again.');
	}

}
