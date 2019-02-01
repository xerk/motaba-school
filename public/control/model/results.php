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
		Field::inst( 'users.stage_id' ),
		Field::inst( 'users.class_id' ),
		Field::inst( 'users.classroom_id' ),
        Field::inst( 'users.id' )
            ->options( Options::inst()
                ->table( 'secret_numbers' )
                ->value( 'user_id' )
                ->label( 'secret_number' )
			)
			->validator( 'Validate::dbValues' )
			->options( Options::inst()
                ->table( 'results' )
				->value( 'id' )
			)
			->validator( 'Validate::dbValues' ),
		Field::inst( 'secret_numbers.secret_number' ),
		Field::inst( 'results.exam_id' )->set( Field::SET_EDIT )
			->options( Options::inst()
                ->table( 'exams' )
                ->value( 'id' )
                ->label( 'name' )
			)
			->validator( 'Validate::dbValues' ),
		Field::inst( 'exams.name' ),
		Field::inst( 'results.exam1' ),
		Field::inst( 'results.sup_subject_id' )->set( Field::SET_EDIT )
			->options( Options::inst()
                ->table( 'sup_subjects' )
                ->value( 'id' )
			)
			->validator( 'Validate::dbValues' ),
		Field::inst( 'sup_subjects.degree' ),			
		Field::inst( 'sup_subjects.type_exam_id' )
			->options( Options::inst()
                ->table( 'type_exams' )
                ->value( 'id' )
			)
			->validator( 'Validate::dbValues' ),		
		Field::inst( 'type_exams.name' ),	
		Field::inst( 'sup_subjects.subject_id' )
			->options( Options::inst()
                ->table( 'subjects' )
				->value( 'id' )
				->label( 'name' )
			)
			->validator( 'Validate::dbValues' ),	
		Field::inst( 'subjects.name' ),
		Field::inst( 'subjects.class_edu_id' ),


		Field::inst( 'results.created_at' )->set( Field::SET_EDIT ),
		Field::inst( 'results.updated_at' )->set( Field::SET_EDIT )
		
	)	
	->on( 'preEdit', function ( $editor, $values ) {
		$editor
		->field( 'results.exam_id' )
		->setValue( $_GET['exam'] );
	} )
	->on( 'preEdit', function ( $editor, $values ) {
		$editor
		->field( 'results.sup_subject_id' )
		->setValue( $_GET['subject'] );
	} )
	->on( 'preEdit', function ( $editor, $values ) {
		$editor
		->field( 'results.created_at' )
		->setValue( date('Y-m-d H:i:s') );
    } )
    ->on( 'preEdit', function ( $editor, $id, $values ) {
        $editor
            ->field( 'results.updated_at' )
            ->setValue( date('Y-m-d H:i:s') );
    } )
    ->leftJoin( 'secret_numbers', 'users.id', '=', 'secret_numbers.user_id' ) 
    ->leftJoin( 'results', 'users.id', '=', 'results.user_id' ) 
    ->leftJoin( 'exams', 'exams.id', '=', 'results.exam_id' ) 
    ->leftJoin( 'sup_subjects', 'sup_subjects.id', '=', 'results.sup_subject_id' ) 
    ->leftJoin( 'type_exams', 'type_exams.id', '=', 'sup_subjects.type_exam_id' ) 
    ->leftJoin( 'subjects', 'subjects.id', '=', 'sup_subjects.subject_id' ) 
	->where( 'users.stage_id', $_GET['stage'] )
	->where( 'users.class_id', $_GET['class'] )
	->where( 'users.classroom_id', $_GET['classroom'] )
	->process( $_POST )
	->json();