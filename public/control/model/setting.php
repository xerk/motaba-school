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
	Editor::inst( $db, 'users')
	->fields(
		Field::inst( 'users.name' ),
		Field::inst( 'users.last_name' ),
		Field::inst( 'users.gender' ),
		Field::inst( 'users.classroom_id' )
			->options( Options::inst()
                ->table( 'class_rooms' )
                ->value( 'id' )
                ->label( 'name' )
			),
		Field::inst( 'class_rooms.name' ),
		Field::inst( 'users.class_id' ),
        Field::inst( 'users.id' )
            ->options( Options::inst()
                ->table( 'setting_numbers' )
                ->value( 'user_id' )
                ->label( 'setting_number' )
			)
			->validator( 'Validate::dbValues' ),
		Field::inst( 'setting_numbers.setting_number' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'setting_numbers.created_at' )->set( Field::SET_EDIT ),
		Field::inst( 'setting_numbers.updated_at' )->set( Field::SET_EDIT )
		
	)	
	->on( 'preEdit', function ( $editor, $values ) {
			// $editor->field( 'setting_numbers.created_at' )->getFormatter(function ( $val, $data )  {
			// 		global $val;
			// 		return $val;
			// 		var_dump($val);
			// 	});
				$editor
				->field( 'setting_numbers.created_at' )
				->setValue( date('Y-m-d H:i:s') );
    } )
    ->on( 'preEdit', function ( $editor, $id, $values ) {
        $editor
            ->field( 'setting_numbers.updated_at' )
            ->setValue( date('Y-m-d H:i:s') );
    } )
    ->leftJoin( 'setting_numbers', 'users.id', '=', 'setting_numbers.user_id' ) 
    ->leftJoin( 'class_rooms', 'users.classroom_id', '=', 'class_rooms.id' ) 
	->where( 'users.class_id', $_GET['class'] )
	// ->where( 'users.GroupID', 10 )
	->process( $_POST )
	->json();