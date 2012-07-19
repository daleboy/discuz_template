<?php

/**
 * DiscuzX Convert
 *
 * $Id: threadtypes.php 15719 2010-08-25 23:51:36Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'threadtypes';
$table_target = $db_target->tablepre.'forum_threadtype';

$limit = 1000;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source WHERE typeid>'$start' ORDER BY typeid LIMIT $limit");
while ($threadtype = $db_source->fetch_array($query)) {

	$nextid = $threadtype['typeid'];

	$threadtype  = daddslashes($threadtype, 1);

	$data = implode_field_value($threadtype, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("����ת�����ݱ� ".$table_source." typeid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>