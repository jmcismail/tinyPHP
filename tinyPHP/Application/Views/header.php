<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Site Header
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
ob_start();
ob_implicit_flush(0);
$cookie = new \tinyPHP\Classes\Libraries\Cookies;
?>
<!doctype html>
<html>
<head>
	<title><?php if(isset($this->title)) { foreach($this->title as $title) { echo $title . ' - ' . SITE_TITLE; } } else { echo SITE_TITLE; } ?></title>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<link rel="stylesheet" href="<?=BASE_URL;?>static/css/bootstrap.css" />
	<link rel="stylesheet" href="<?=BASE_URL;?>static/css/bootstrap-responsive.css" />
	
	<style type="text/css">

      /* Sticky footer styles
      -------------------------------------------------- */

      html,
      body {
        height: 100%;
        /* The html and body elements cannot have any padding or margin. */
      }

      /* Wrapper for page content to push down footer */
      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it's height */
        margin: 0 auto -60px;
      }

      /* Set the fixed height of the footer here */
      #push,
      #footer {
        height: 60px;
      }
      #footer {
        background-color: #f5f5f5;
      }

      /* Lastly, apply responsive CSS fixes as necessary */
      @media (max-width: 767px) {
        #footer {
          margin-left: -20px;
          margin-right: -20px;
          padding-left: 20px;
          padding-right: 20px;
        }
      }



      /* Custom page CSS
      -------------------------------------------------- */
      /* Not required for template or sticky footer method. */

      .container {
        width: auto;
        max-width: 680px;
      }
      .container .credit {
        margin: 20px 0;
      }

    </style>
</head>
<body>
	
	<div id="wrap">
	<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?=BASE_URL;?>"><?=SITE_TITLE;?></a>
          <div class="nav-collapse collapse">
            <ul class="nav">
          	<?php if($cookie->isUserLoggedIn()) { ?>
				<li<?=ae('access_dashboard');?>><a href="<?=BASE_URL;?>"><?=_t( 'Home' );?></a></li>
				<li<?=ae('access_help_page');?>><a href="<?=BASE_URL;?>help/"><?=_t( 'Help' );?></a></li>
				<li<?=ae('access_dashboard');?>><a href="<?=BASE_URL;?>dashboard"><?=_t( 'Dashboard' );?></a></li>
				<li<?=ae('manage_permissions');?>><a href="<?=BASE_URL;?>permission/"><?=_t( 'Permissions' );?></a></li>
				<li<?=ae('manage_roles');?>><a href="<?=BASE_URL;?>role/"><?=_t( 'Roles' );?></a></li>
				<li<?=ae('manage_users');?>><a href="<?=BASE_URL;?>user/"><?=_t( 'Users' );?></a></li>
				<li><a href="<?=BASE_URL;?>dashboard/logout/"><?=_t( 'Logout' );?></a></li>
			<?php } else { ?>
				<li><a href="<?=BASE_URL;?>login/"><?=_t( 'Login' );?></a></li>
			<?php } ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
    	<div id="main">
	
	