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
        Field::inst( 'users.id' )
            ->options( Options::inst()
                ->table( 'add_salaries' )
                ->value( 'user_id' )
                ->label( 'cost' )
			)
			->validator( 'Validate::dbValues' ),
		Field::inst( 'add_salaries.cost' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'add_salaries.absent_day' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'add_salaries.may_grant' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'add_salaries.prev_year_bonus' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'add_salaries.share_employer' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'add_salaries.variable_wages' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'add_salaries.bonus' )
			->validator( 'Validate::numeric' ),
		
		Field::inst( 'add_salaries.created_at' )->set( Field::SET_EDIT ),
		Field::inst( 'add_salaries.updated_at' )->set( Field::SET_EDIT )
	)	
	->on( 'preEdit', function ( $editor, $values ) {

		$editor
			->field( 'add_salaries.created_at' )
			->setValue( date('Y-m-d H:i:s') );
	} )
	->on( 'preEdit', function ( $editor, $id, $values ) {
		$editor
			->field( 'add_salaries.updated_at' )
			->setValue( date('Y-m-d H:i:s') );
	} )
    ->leftJoin( 'add_salaries', 'users.id', '=', 'add_salaries.user_id' ) 
	->where( 'users.job', 0 )
	->process( $_POST )
	->json();