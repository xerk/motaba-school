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
	$editor = Editor::inst( $db, 'results')
	->fields(
		Field::inst( 'results.user_id' ),
		Field::inst( 'results.sup_subject_id' ),
		Field::inst( 'results.exam_id' )
			->options( Options::inst()
					->table( 'exams' )
					->value( 'id' )
					->label( 'name' )
				)
				->validator( 'Validate::dbValues' ),
		Field::inst( 'results.exam1' ),
		Field::inst( 'users.name' ),
		Field::inst( 'users.last_name' ),
		Field::inst( 'users.gender' ),


		Field::inst( 'results.created_at' )->set( Field::SET_EDIT ),
		Field::inst( 'results.updated_at' )->set( Field::SET_EDIT )
		
	);	
	$editor->on( 'preEdit', function ( $editor, $values ) {
		$editor
		->field( 'results.created_at' )
		->setValue( date('Y-m-d H:i:s') );
    } );
    $editor->on( 'preEdit', function ( $editor, $id, $values ) {
        $editor
            ->field( 'results.updated_at' )
            ->setValue( date('Y-m-d H:i:s') );
    } );
    $editor->leftJoin( 'users', 'users.id', '=', 'results.user_id' );
	$editor->where( 'users.stage_id', $_GET['stage'] );
	$editor->where( 'users.class_id', $_GET['class'] );
	$editor->where( 'results.sup_subject_id', $_GET['subject'] );
	$editor->where( 'results.exam_id', $_GET['exam'] );
	if ($_GET['classroom'] != 0) {

		$editor->where( 'users.classroom_id', $_GET['classroom'] );
	}
	$editor->process( $_POST );
	$editor->json();