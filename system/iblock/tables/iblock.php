<?php
/**
* Infoblock: Tables
* Just tables. You can edit it like excel.
* Usage:
* {iblock:tables?show=%id} - shows table with this id
*   headers=1 - first row as header
*/

$defaults = array(
	'show' => 1,
	'headers' => 0,
);
$args = array_merge($defaults, $args);

$this->load->model('tables');
$table = $this->tables_model->read($args['show']);

if ($table['status'] == 0){
	return;
}

$table['content'] = json_decode($table['content'], true);
$table['headers'] = $args['headers'] ? array_shift($table['content']) : array();
