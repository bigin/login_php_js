<?php
try
{
	$db = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DATABASE.';charset=utf8', MYSQL_USER, MYSQL_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (Exception $e)
{
	echo $e->getMessage();
}
