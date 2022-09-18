<?php

$data_file = file_get_contents('../admin/app-data.json');
$dd = json_decode($data_file);

define( '_DB_NAME_', 'invisibl_creativecash_S01' );

define( '_COLOR_PRIMARY_', $dd->primary_color );
define( '_COLOR_GRADIENT_END_', $dd->gradient_color_end);