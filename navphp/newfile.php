<?php
$dir = @$_REQUEST['dir'];
$ajax=@$_REQUEST['ajax'];
$file=@$_REQUEST['file'];
$change = @$_REQUEST['change'];

include_once("config.php");
include_once("functions.php");
$reply=0;

authenticate();	//user login
if($GLOBALS['rdonly']) die("|0|Warning: Working in read-only mode!|");
chdir($dir);

if(strpos($change, "/tmp") === 0) {
      if (dcac_set_def_rdacl('.apps.navphp.common') < 0)
         nice_die('dcac_set_def_rdacl (dcac init)');
      if (dcac_set_def_wracl('.apps.navphp.common') < 0)
         nice_die('dcac_set_def_wracl (dcac init)');
      if (dcac_set_def_exacl('.apps.navphp.common') < 0)
         nice_die('dcac_set_def_exacl (dcac init)');
}

if(file_exists($change)) $msg="Folder or file '$change' already exists!";
  elseif($f=fopen($change,"w")) {fclose($f); $msg="New file '$change' created"; $reply=1; chmod($change,0777);}
  else $msg="Error: Can't create new file '$change'!";

if($ajax)
	{expired();
	print"|$reply|$msg|";
	if($reply) filestatus($change)."|";
	}

?> 
