<?php
// Version
define('VERSION', '2.3.0.2');

// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

require_once(DIR_SYSTEM . 'library/v2pagecache.php');           //V2PAGECACHE
$pagecache = new V2PageCache();                                 //V2PAGECACHE
if ($pagecache->ServeFromCache()) {                             //V2PAGECACHE
    // exit here if we served this page from the cache          //V2PAGECACHE
    return;                                                     //V2PAGECACHE
}                                                               //V2PAGECACHE
// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}

// VirtualQMOD
require_once('./vqmod/vqmod.php');
VQMod::bootup();

// VQMODDED Startup
require_once(VQMod::modCheck(DIR_SYSTEM . 'startup.php'));

start('catalog');
if ($pagecache->OkToCache()) {                                  //V2PAGECACHE
    $pagecache->CachePage();                                    //V2PAGECACHE
}                                                               //V2PAGECACHE
