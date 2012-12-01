<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Error View
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

<table width="100%" height="100%">
	<tr>
		<td align="center" valign="middle">
		<h1><?php echo _t( '404 Error' ); ?></h1>
		<?php echo _t( 'It appears that the page you are looking for is no longer available.' ); ?><br/>
		<?php echo _t( 'Use the navigation bar above to navigate to a different page.' ); ?>
		</td>
	</tr>
</table>