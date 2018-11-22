<?php

/*
===================================================
== Manage Absent Workers Page
== You Can Add | Edit | Delect Members From Here
===================================================
*/

ob_start(); // Output Buffering Start
session_start();
if (isset($_SESSION['Username'])) {
    $pageTitle = 'رقم الجلوس';
    include 'ini.php';
    if ($_SESSION['GroupID'] <= 6) { // If GroupID not equal 1 to 7 i will be not admin
        $role = groupID("1", "6");
        if ($role) {
		$classid = isset($_GET['class']) && is_numeric($_GET['class']) ? intval($_GET['class']) : 0;
			?>
<?php if (isset($_GET['class']) && $_GET['class']) { ?>
<div class="content-wrapper" dir="<?php echo lang('dir') ?>">
	<div class="page-title">
			<div>
				<h1><?php echo lang('sitting_number') ?></h1>
				<ul class="breadcrumb side">
					<li><i class="fa fa-home fa-lg"></i></li>
					<li>Tables</li>
					<li class="active"><a href="#"><?php echo $pageTitle ?></a></li>
				</ul>
			</div>
			<div><a class="btn btn-primary btn-flat" href="classes.php?do=Add"><i class="fa fa-lg fa-plus"></i></a><a class="btn btn-info btn-flat" href="<?php header("refresh: classes.php")?>"><i class="fa fa-lg fa-refresh"></i></a></div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<table id="example" class="table table-hover text-center table-bordered display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th></th>
								<th><?php echo lang('name') ?></th>
								<th><?php echo lang('name') ?></th>
								<th><?php echo lang('gender') ?></th>
								<th><?php echo lang('croom') ?></th>
								<th><?php echo lang('sitting_number') ?></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php } else { 
			header('Location: ../error.php'); // will insert page not fount
			exit();
	 	}	?>
<?php 

        include $tpl . 'footer.php';
        } else {
            header('Location: ../index.php'); // will insert page not fount
            exit();
        }
    } else {
        header('Location: ../index.php'); // will insert page not fount
        exit();
    }
} else {
    header('Location: ../index.php'); // will insert page not fount
    exit();
}   $id =1;
    ob_end_flush();
?>
<script type="text/javascript" language="javascript" class="init">	
	var editor; // use a global for the submit and return data rendering in the examples
	
	$(document).ready(function() {

		editor = new $.fn.dataTable.Editor( {
			ajax: 
			{
				url: "examples/php/users.php?class=<?php echo $classid ?>",
				type: "POST",
			},
			table: "#example",
			fields: [ {
					label: "First name:",
					name: "users.First_Name"
				}, {
					label: "Last name:",
					name: "users.Last_Name"
				}, {
					label: "Sitting Number:",
					name: "users.Sitting_Number"
				}
			]
		} );

		var table = $('#example').DataTable( {
			dom: "Bfrtip",
			"order": [[3 , 'asc'],[1 , 'asc'],[2 , 'asc']],
			"pageLength": 300,
			ajax: 
			{
				url: "examples/php/users.php",
				type: "GET",
				data: { 
					"class": <?php echo $classid ?>
				},
			},
			ajaxUrl: "examples/php/users.php",
			columns: [
				{
					data: null,
					defaultContent: '',
					className: 'select-checkbox',
					orderable: false
				},
				{ data: "users.First_Name" },
				{ data: "users.Last_Name" },
				{ data: "users.Sex" ,
				"render": function (val, type, row) {
                    return val == 1 ? "<?php echo lang('male') ?>" : "<?php echo lang('female') ?>";}
			},
				{ data: "classrooms.Name" },
				{ data: "users.Sitting_Number" }
			],
			autoFill: {
				columns: [5],
				editor:  editor
			},
			keys: {
				columns: [5],
				editor:  editor,
			},
			select: {
				style:    'os',
				selector: 'td:first-child',
				blurable: true
			},
			"columnDefs": [
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                "render": function ( data, type, row ) {
                    return row.users.First_Name +' '+ row.users.Last_Name;
                },
                "targets": 1
            },
			
            { "visible": false,  "targets": [ 2 ] }
        ]
		} );
	} );
</script>