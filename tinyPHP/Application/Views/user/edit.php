<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * User Edit View
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
?>

<h1><?=_t( 'User: Edit' );?></h1>

<?php foreach($this->user as $key => $value) { ?>
<form method="post" action="<?=BASE_URL;?>user/editSave/<?=$value['userID'];?>">
	<label><?=_t( 'Login' );?></label><input type="text" name="login" value="<?=$value['login'];?>" required/><br />
	<label><?=_t( 'First Name' );?></label><input type="text" name="fname" value="<?=$value['fname'];?>" required/><br />
	<label><?=_t( 'Last Name' );?></label><input type="text" name="lname" value="<?=$value['lname'];?>" required/><br />
	<label><?=_t( 'Password' );?></label><input type="password" name="password" /><br />
	<input type="hidden" name="userID" value="<?=$value['userID'];?>" required/>
	<label>&nbsp;</label><input class="btn" type="submit" />
</form>
<?php } ?>