<?php

/*
 * Example PHP implementation used for the index.html example
 */

// DataTables PHP library
include( "../php/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;
	
// Build our Editor instance and process the data coming from _POST
	Editor::inst( $db, 'class_edus')
	->fields(
		Field::inst( 'class_edus.name' ),
		Field::inst( 'class_edus.expenses_cost' )->validator( 'Validate::numeric' )
		
	)	
	->process( $_POST )
	->json();