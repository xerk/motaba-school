<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, user-scalable=no">
	<title>Editor example - Excel like AutoFill feature</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.17/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.6/css/select.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/autofill/2.3.0/css/autoFill.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="../css/editor.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="resources/syntax/shCore.css">
	<link rel="stylesheet" type="text/css" href="resources/demo.css">
	<style type="text/css" class="init">
	
	</style>
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.17/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.2.6/js/dataTables.select.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/autofill/2.3.0/js/dataTables.autoFill.min.js"></script>
	<script type="text/javascript" language="javascript" src="../js/dataTables.editor.min.js"></script>
	<script type="text/javascript" language="javascript" src="resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="resources/demo.js"></script>
	<script type="text/javascript" language="javascript" src="resources/editor-demo.js"></script>
	<script type="text/javascript" language="javascript" class="init">
	


var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {
	editor = new $.fn.dataTable.Editor( {
		ajax: "php/staff.php",
		table: "#example",
		fields: [ {
				label: "First name:",
				name: "first_name"
			}, {
				label: "Last name:",
				name: "last_name"
			}, {
				label: "Position:",
				name: "position"
			}, {
				label: "Office:",
				name: "office"
			}, {
				label: "Extension:",
				name: "extn"
			}, {
				label: "Start date:",
				name: "start_date",
				type: "datetime"
			}, {
				label: "Salary:",
				name: "salary"
			}
		]
	} );

	var table = $('#example').DataTable( {
		dom: "Bfrtip",
		ajax: "php/staff.php",
		columns: [
			{ data: "first_name" },
			{ data: "last_name" },
			{ data: "position" },
			{ data: "office" },
			{ data: "start_date" },
			{ data: "salary", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) }
		],
		autoFill: {
			editor:  editor
		},
		select: {
			style:    'os',
			selector: 'td:first-child',
			blurable: true
		},
		buttons: [
			{ extend: "create", editor: editor },
			{ extend: "edit",   editor: editor },
			{ extend: "remove", editor: editor }
		]
	} );
} );



	</script>
</head>
<body class="dt-example">
	<div class="container">
		<section>
			<h1>Editor example <span>Excel like AutoFill feature</span></h1>
			<div class="info">
				<p>The ability to click and drag to fill cells with data in Excel is exceptionally useful when you wish to update multiple items with similar information. <a href=
				"https://datatables.net/extensions/autofill">AutoFill</a> provides this ability in DataTables and its <a href=
				"//datatables.net/reference/option/autoFill.editor"><code class="option" title="AutoFill initialisation option">autoFill.editor</code></a> option can be used to
				bind it to your Editor instance.</p>
				<p>Editor's multi-row editing ability results in fast and efficient updating of data. AutoFill can also be extended with plug-ins should you wish to provide your
				own data fill methods.</p>
			</div>
			<div class="demo-html"></div>
			<table id="example" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>First name</th>
						<th>Last name</th>
						<th>Position</th>
						<th>Office</th>
						<th width="18%">Start date</th>
						<th>Salary</th>
					</tr>
				</thead>
			</table>
			<ul class="tabs">
				<li class="active">Javascript</li>
				<li>HTML</li>
				<li>CSS</li>
				<li>Ajax</li>
				<li>Server-side script</li>
			</ul>
			<div class="tabs">
				<div class="js">
					<p>The Javascript shown below is used to initialise the table shown in this example:</p><code class="multiline language-js">var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {
	editor = new $.fn.dataTable.Editor( {
		ajax: &quot;../php/staff.php&quot;,
		table: &quot;#example&quot;,
		fields: [ {
				label: &quot;First name:&quot;,
				name: &quot;first_name&quot;
			}, {
				label: &quot;Last name:&quot;,
				name: &quot;last_name&quot;
			}, {
				label: &quot;Position:&quot;,
				name: &quot;position&quot;
			}, {
				label: &quot;Office:&quot;,
				name: &quot;office&quot;
			}, {
				label: &quot;Extension:&quot;,
				name: &quot;extn&quot;
			}, {
				label: &quot;Start date:&quot;,
				name: &quot;start_date&quot;,
				type: &quot;datetime&quot;
			}, {
				label: &quot;Salary:&quot;,
				name: &quot;salary&quot;
			}
		]
	} );

	var table = $('#example').DataTable( {
		dom: &quot;Bfrtip&quot;,
		ajax: &quot;../php/staff.php&quot;,
		columns: [
			{ data: &quot;first_name&quot; },
			{ data: &quot;last_name&quot; },
			{ data: &quot;position&quot; },
			{ data: &quot;office&quot; },
			{ data: &quot;start_date&quot; },
			{ data: &quot;salary&quot;, render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) }
		],
		autoFill: {
			editor:  editor
		},
		select: {
			style:    'os',
			selector: 'td:first-child',
			blurable: true
		},
		buttons: [
			{ extend: &quot;create&quot;, editor: editor },
			{ extend: &quot;edit&quot;,   editor: editor },
			{ extend: &quot;remove&quot;, editor: editor }
		]
	} );
} );</code>
					<p>In addition to the above code, the following Javascript library files are loaded for use in this example:</p>
					<ul>
						<li>
							<a href="https://code.jquery.com/jquery-3.3.1.js">https://code.jquery.com/jquery-3.3.1.js</a>
						</li>
						<li>
							<a href="https://cdn.datatables.net/1.10.17/js/jquery.dataTables.min.js">https://cdn.datatables.net/1.10.17/js/jquery.dataTables.min.js</a>
						</li>
						<li>
							<a href=
							"https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js">https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js</a>
						</li>
						<li>
							<a href="https://cdn.datatables.net/select/1.2.6/js/dataTables.select.min.js">https://cdn.datatables.net/select/1.2.6/js/dataTables.select.min.js</a>
						</li>
						<li>
							<a href=
							"https://cdn.datatables.net/autofill/2.3.0/js/dataTables.autoFill.min.js">https://cdn.datatables.net/autofill/2.3.0/js/dataTables.autoFill.min.js</a>
						</li>
						<li>
							<a href="../../js/dataTables.editor.min.js">../../js/dataTables.editor.min.js</a>
						</li>
					</ul>
				</div>
				<div class="table">
					<p>The HTML shown below is the raw HTML table element, before it has been enhanced by DataTables:</p>
				</div>
				<div class="css">
					<div>
						<p>This example uses a little bit of additional CSS beyond what is loaded from the library files (below), in order to correctly display the table. The
						additional CSS used is shown below:</p><code class="multiline language-css"></code>
					</div>
					<p>The following CSS library files are loaded for use in this example to provide the styling of the table:</p>
					<ul>
						<li>
							<a href="https://cdn.datatables.net/1.10.17/css/jquery.dataTables.min.css">https://cdn.datatables.net/1.10.17/css/jquery.dataTables.min.css</a>
						</li>
						<li>
							<a href=
							"https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css</a>
						</li>
						<li>
							<a href=
							"https://cdn.datatables.net/select/1.2.6/css/select.dataTables.min.css">https://cdn.datatables.net/select/1.2.6/css/select.dataTables.min.css</a>
						</li>
						<li>
							<a href=
							"https://cdn.datatables.net/autofill/2.3.0/css/autoFill.dataTables.min.css">https://cdn.datatables.net/autofill/2.3.0/css/autoFill.dataTables.min.css</a>
						</li>
						<li>
							<a href="../../css/editor.dataTables.min.css">../../css/editor.dataTables.min.css</a>
						</li>
					</ul>
				</div>
				<div class="ajax">
					<p>This table loads data by Ajax. The latest data that has been loaded is shown below. This data will update automatically as any additional data is
					loaded.</p>
				</div>
				<div class="php">
					<p>The script used to perform the server-side processing for this table is shown below. Please note that this is just an example script using PHP. Server-side
					processing scripts can be written in any language, using <a href="//datatables.net/manual/server-side">the protocol described in the DataTables
					documentation</a>.</p>
				</div>
			</div>
		</section>
	</div>
	<section>
		<div class="footer">
			<div class="gradient"></div>
			<div class="liner">
				<h2>Other examples</h2>
				<div class="toc">
					<div class="toc-group">
						<h3><a href="../simple/index.html">Simple initialisation</a></h3>
						<ul class="toc">
							<li>
								<a href="../simple/simple.html">Basic initialisation</a>
							</li>
							<li>
								<a href="../simple/multiRow.html">Multi-row editing</a>
							</li>
							<li>
								<a href="../simple/fieldTypes.html">Field types</a>
							</li>
							<li>
								<a href="../simple/fieldDefaults.html">Setting defaults</a>
							</li>
							<li>
								<a href="../simple/noAjax.html">Local table editing</a>
							</li>
							<li>
								<a href="../simple/i18n.html">Internationalisation</a>
							</li>
							<li>
								<a href="../simple/inTableControls.html">In table form controls</a>
							</li>
							<li>
								<a href="../simple/server-side-processing.html">Server-side processing</a>
							</li>
							<li>
								<a href="../simple/template.html">Custom form layout / templates (tags)</a>
							</li>
							<li>
								<a href="../simple/template-attribute.html">Custom form layout / templates (attributes)</a>
							</li>
							<li>
								<a href="../simple/join.html">Join tables - working with multiple SQL tables</a>
							</li>
						</ul>
					</div>
					<div class="toc-group">
						<h3><a href="../advanced/index.html">Advanced initialisation</a></h3>
						<ul class="toc">
							<li>
								<a href="../advanced/formOnlyData.html">Data shown only in the form</a>
							</li>
							<li>
								<a href="../advanced/tableOnlyData.html">Data shown in table only</a>
							</li>
							<li>
								<a href="../advanced/multiItem.html">Multi-item editing (rows, columns, cells)</a>
							</li>
							<li>
								<a href="../advanced/REST.html">REST interface</a>
							</li>
							<li>
								<a href="../advanced/deepObjects.html">Complex (nested) JSON data source</a>
							</li>
							<li>
								<a href="../advanced/localstorage.html">Ajax override - using localStorage for the data source</a>
							</li>
							<li>
								<a href="../advanced/jsonId.html">Row ID source specification</a>
							</li>
							<li>
								<a href="../advanced/compoundKey.html">Compound database primary key</a>
							</li>
							<li>
								<a href="../advanced/htmlTable.html">DOM sourced table</a>
							</li>
							<li>
								<a href="../advanced/joinSelf.html">Join tables - self referencing join</a>
							</li>
							<li>
								<a href="../advanced/joinLinkTable.html">Join tables - link table</a>
							</li>
							<li>
								<a href="../advanced/joinArray.html">Join tables - one-to-many join</a>
							</li>
							<li>
								<a href="../advanced/upload.html">File upload</a>
							</li>
							<li>
								<a href="../advanced/upload-many.html">File upload (many)</a>
							</li>
						</ul>
					</div>
					<div class="toc-group">
						<h3><a href="./index.html">DataTables extensions</a></h3>
						<ul class="toc active">
							<li>
								<a href="./keyTable.html">Excel like keyboard navigation</a>
							</li>
							<li class="active">
								<a href="./autoFill.html">Excel like AutoFill feature</a>
							</li>
							<li>
								<a href="./excel.html">AutoFill and KeyTable together</a>
							</li>
							<li>
								<a href="./exportButtons.html">Export buttons</a>
							</li>
							<li>
								<a href="./responsive.html">Responsive table extension</a>
							</li>
							<li>
								<a href="./rowReorder.html">Row reordering</a>
							</li>
						</ul>
					</div>
					<div class="toc-group">
						<h3><a href="../dates/index.html">Dates and time</a></h3>
						<ul class="toc">
							<li>
								<a href="../dates/dates.html">Date picker</a>
							</li>
							<li>
								<a href="../dates/formatting.html">Formatted dates</a>
							</li>
							<li>
								<a href="../dates/datetime.html">Date and time input</a>
							</li>
							<li>
								<a href="../dates/time.html">Time inputs</a>
							</li>
							<li>
								<a href="../dates/time-increment.html">Time increment options</a>
							</li>
							<li>
								<a href="../dates/options-min-max.html">Options - min and max dates</a>
							</li>
							<li>
								<a href="../dates/options-week-numbers.html">Options - week numbers</a>
							</li>
							<li>
								<a href="../dates/options-disable-days.html">Options - disable days</a>
							</li>
							<li>
								<a href="../dates/i18n.html">Internationalisation</a>
							</li>
							<li>
								<a href="../dates/jqueryui.html">jQuery UI DatePicker</a>
							</li>
							<li>
								<a href="../dates/jqueryui-formatting.html">jQuery UI DatePicker with custom formatting</a>
							</li>
							<li>
								<a href="../dates/html5.html">HTML5 date input</a>
							</li>
						</ul>
					</div>
					<div class="toc-group">
						<h3><a href="../inline-editing/index.html">Inline editing</a></h3>
						<ul class="toc">
							<li>
								<a href="../inline-editing/simple.html">Simple inline editing</a>
							</li>
							<li>
								<a href="../inline-editing/tabControl.html">Tab between columns</a>
							</li>
							<li>
								<a href="../inline-editing/options.html">Editing options - submit on blur</a>
							</li>
							<li>
								<a href="../inline-editing/submitData.html">Editing options - submit full row data</a>
							</li>
							<li>
								<a href="../inline-editing/submitButton.html">Inline editing with a submit button</a>
							</li>
							<li>
								<a href="../inline-editing/editIcon.html">Edit icon</a>
							</li>
							<li>
								<a href="../inline-editing/join.html">Joined tables</a>
							</li>
							<li>
								<a href="../inline-editing/responsive.html">Responsive integration</a>
							</li>
							<li>
								<a href="../inline-editing/columns.html">Selected columns only</a>
							</li>
							<li>
								<a href="../inline-editing/fixedcolumns.html">FixedColumns integration</a>
							</li>
							<li>
								<a href="../inline-editing/serverSide.html">Server-side processing</a>
							</li>
						</ul>
					</div>
					<div class="toc-group">
						<h3><a href="../bubble-editing/index.html">Bubble editing</a></h3>
						<ul class="toc">
							<li>
								<a href="../bubble-editing/simple.html">Simple bubble editing</a>
							</li>
							<li>
								<a href="../bubble-editing/grouped.html">Multiple fields in a bubble</a>
							</li>
							<li>
								<a href="../bubble-editing/options.html">Form control and display options</a>
							</li>
							<li>
								<a href="../bubble-editing/defaultOptions.html">Default control and display options</a>
							</li>
							<li>
								<a href="../bubble-editing/inTableControls.html">Bubble editing with in table row controls</a>
							</li>
						</ul>
					</div>
					<div class="toc-group">
						<h3><a href="../api/index.html">API</a></h3>
						<ul class="toc">
							<li>
								<a href="../api/confirmClose.html">Events - unsaved changes close confirmation</a>
							</li>
							<li>
								<a href="../api/dependentFields.html">Dependent fields</a>
							</li>
							<li>
								<a href="../api/clientValidation.html">Client-side validation</a>
							</li>
							<li>
								<a href="../api/triggerButton.html">Customised control buttons</a>
							</li>
							<li>
								<a href="../api/backNext.html">Previous / next editing buttons</a>
							</li>
							<li>
								<a href="../api/cancelButton.html">Cancel button</a>
							</li>
							<li>
								<a href="../api/checkbox.html">Always shown checkbox</a>
							</li>
							<li>
								<a href="../api/softDelete.html">Soft delete</a>
							</li>
							<li>
								<a href="../api/duplicateButton.html">Duplicate button</a>
							</li>
							<li>
								<a href="../api/removeMessage.html">Custom delete / remove message</a>
							</li>
						</ul>
					</div>
					<div class="toc-group">
						<h3><a href="../standalone/index.html">Standalone</a></h3>
						<ul class="toc">
							<li>
								<a href="../standalone/simple.html">Simple standalone editing</a>
							</li>
							<li>
								<a href="../standalone/bubble.html">Bubble editing</a>
							</li>
							<li>
								<a href="../standalone/inline.html">Inline editing</a>
							</li>
							<li>
								<a href="../standalone/collection.html">Standalone collection editor</a>
							</li>
						</ul>
					</div>
					<div class="toc-group">
						<h3><a href="../styling/index.html">Styling</a></h3>
						<ul class="toc">
							<li>
								<a href="../styling/bootstrap.html">Bootstrap 3</a>
							</li>
							<li>
								<a href="../styling/bootstrap4.html">Bootstrap 4</a>
							</li>
							<li>
								<a href="../styling/foundation.html">Foundation</a>
							</li>
							<li>
								<a href="../styling/semanticui.html">Semantic UI</a>
							</li>
							<li>
								<a href="../styling/jqueryui.html">jQuery UI</a>
							</li>
							<li>
								<a href="../styling/fieldDisplay.html">Field display styling options</a>
							</li>
							<li>
								<a href="../styling/columns.html">Multi-column layout</a>
							</li>
							<li>
								<a href="../styling/large.html">Large window layout</a>
							</li>
							<li>
								<a href="../styling/stackedInputs.html">Stacked inputs</a>
							</li>
							<li>
								<a href="../styling/envelope.html">Envelope display controller</a>
							</li>
							<li>
								<a href="../styling/envelopeInTable.html">Envelope display with in table controls</a>
							</li>
							<li>
								<a href="../styling/template.html">Custom form layout / templates</a>
							</li>
						</ul>
					</div>
					<div class="toc-group">
						<h3><a href="../plug-ins/index.html">Plug-ins</a></h3>
						<ul class="toc">
							<li>
								<a href="../plug-ins/fieldPlugin.html">Custom field type plug-ins</a>
							</li>
							<li>
								<a href="../plug-ins/displayController.html">Custom display controller</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="epilogue">
					<p>Please refer to the <a href="http://www.datatables.net">DataTables documentation</a> for full information about its API properties and methods.<br>
					Additionally, there are a wide range of <a href="http://www.datatables.net/extensions">extensions</a> and <a href=
					"http://www.datatables.net/plug-ins">plug-ins</a> which extend the capabilities of DataTables.</p>
					<p class="copyright">DataTables designed and created by <a href="http://www.sprymedia.co.uk">SpryMedia Ltd</a> © 2007-2018<br>
					DataTables is licensed under the <a href="http://www.datatables.net/mit">MIT license</a>.</p>
				</div>
			</div>
		</div>
	</section>
</body>
</html>