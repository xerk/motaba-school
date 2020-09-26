<template>
	<div class="page-content browse container-fluid">
		<div class="lecture-select-box">
			<router-link
				@click.native="next"
				class="btn btn-sm btn-primary pull-right edit"
				style="padding: 5px 10px"
				tag="a"
				:to="{
					path: '/admin/salary_reports',
					query: { month: month + 1 },
				}"
				:title="trans('table.Next')"
			>
				<span class="hidden-xs hidden-sm"></span>
				<i class="voyager-double-right"></i>
			</router-link>
			<router-link
				@click.native="prev"
				class="btn btn-sm btn-primary pull-right edit"
				style="padding: 5px 10px"
				:title="trans('table.Prev')"
				tag="a"
				:to="{
					path: '/admin/salary_reports',
					query: { month: month - 1 },
				}"
			>
				<span class="hidden-xs hidden-sm"></span>
				<i class="voyager-double-left"></i>
			</router-link>
			<button class="btn btn-sm disabled" style="padding: 4px 15px">
				{{
					new Date()
						| moment("add", month + " months", "(MM) MMMM - YYYY")
				}}
			</button>
		</div>
		<div class="content-header" style="display: none">
			<div class="row">
				<div class="col-sm-4 col-print-4 pull-left">
					<img
						src="https://old.schoolver.com/images/logo/PNG-24.png"
						alt="Logo"
						style="width: 100px"
						class="img-responsive"
					/>
				</div>
				<div class="col-sm-4 col-print-4 text-center">
					<h3>
						كشف رواتب الموظفين لشهر
						{{
							new Date()
								| moment("add", month + " months", "MM - YYYY")
						}}
					</h3>
				</div>
				<div class="col-sm-4 col-print-4" style="font-size: 18px">
					<ul class="list-unstyled text-center pull-right">
						<li>الأزهر الشريف</li>
						<li>منطقة الجيزه الأزهريه</li>
						<li>معهد كامل عودة الأزهري الخاص</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="content-footer" style="display: none">
			<!-- <div class="row">
            <div class="col-sm-4 col-print-4 text-center" style="font-size: 18px">
                <ul class="list-unstyled">
                    <li>عميد المعهد</li>
                    <li>أ/سعيد عيسي</li>
                </ul>
            </div>
            <div class="col-sm-4 col-print-4 text-center" style="font-size: 18px">
                <ul class="list-unstyled">
                    <li>المدير المالي</li>
                    <li>أ/خالد إبراهيم</li>
                </ul>
            </div>
            <div class='col-sm-4 col-print-4 text-center' style="font-size: 18px">
                <ul class="list-unstyled">
                    <li>شئون العاملين</li>
                    <li>أ/عبير السيد</li>
                </ul>
            </div>
        </div> -->
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-bordered">
					<div class="panel-body">
						<div class="table-responsive">
							<table
								class="table table-hover dataTable no-footer display nowrap"
								id="users-table"
							>
								<thead>
									<tr>
										<th></th>
										<th>أسم الموظف</th>
										<th>الأسم الاخير</th>
										<th>أجر اساسى</th>
										<th>منحة مايو</th>
										<th>اجور متغيرة</th>
										<th>علاوات اعوام سابقة</th>
										<th>علاوة</th>
										<th>حصة صاحب العمل</th>
										<th>جملة المستحق</th>
										<th>حصة العامل</th>
										<th>سلفيات</th>
										<th>غياب</th>
										<th>تأخيرات</th>
										<th>جملة المستقطع</th>
										<th>الصافى</th>
										<th>التوقيع</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				month: 0,
			};
		},
		mounted() {
			this.fetch();
		},
		methods: {
			fetch() {
				var month = this.month;
				$(function () {
					var t = $("#users-table").DataTable({
						dom: "Bfrtip",
						buttons: [
							{
								extend: "print",
								text:
									'<i class="fa fa-print" aria-hidden="true"></i> طباعة',
								exportOptions: {
									columns: ":visible",
								},
								customize: function (win) {
									$(win.document.body).css("font-size", "11px");
									$(win.document.body)
										.find("div")
										.first()
										.prepend(
											$(".content-header")
												.clone()
												.css("display", "inline")
										);

									$(win.document.body)
										.find("div")
										.last()
										.prepend(
											$(".content-footer")
												.clone()
												.css("display", "inline")
										);

									$(win.document.body)
										.find("h1")
										.css("display", "none");
									$(win.document.body)
										.find("th")
										.addClass("compact")
										.css("text-align", "right");
									$(win.document.body)
										.find("td")
										.addClass("compact")
										.css("text-align", "right");
									$(win.document.body)
										.find("table")
										.addClass("compact")
										.css("direction", "rtl");
									$(wim.document + "table")
										.find("div")
										.addClass("compact");
								},
							},
							{
								extend: "copy",
								text:
									'<i class="fa fa-clone" aria-hidden="true"></i> نسخ',
								exportOptions: {
									columns: ":visible",
								},
							},
							{
								extend: "excel",
								text:
									'<i class="fa fa-table" aria-hidden="true"></i> أكسيل',
								exportOptions: {
									columns: ":visible",
								},
							},
							{
								extend: "colvis",
								text:
									'<i class="fa fa-check-square" aria-hidden="true"></i> أختيار العمود',
							},
						],
						columnDefs: [
							{
								visible: false,
								targets: 0,
							},
						],
						processing: false,
						serverSide: false,
						ajax: `https://old.schoolver.com/admin/get-salary?month=${month}`,
						columns: [
							{ data: length, defaultContent: "" },
							{ data: "name", name: "name" },
							{ data: "last_name", name: "last_name" },
							{ data: "add_salary.cost", name: "add_salary.cost" },
							{
								data: "add_salary.may_grant",
								name: "add_salary.may_grant",
							},
							{
								data: "add_salary.variable_wages",
								name: "add_salary.variable_wages",
							},
							{
								data: "add_salary.prev_year_bonus",
								name: "add_salary.prev_year_bonus",
							},
							{ data: "add_salary.bonus", name: "add_salary.bonus" },
							{
								data: "add_salary.share_employer",
								name: "add_salary.share_employer",
							},
							{ data: length },
							{
								data: "add_salary.share_employee",
								name: "add_salary.share_employee",
							},
							{ data: "sum_discount", name: "sum_discount" },
							{
								data: "count_absent",
								name: "count_absent",
								render: function (val, type, row) {
									return row.add_salary.absent_day * val;
								},
							},
							{
								data: "count_late",
								name: "count_late",
								render: function (val, type, row) {
									return row.add_salary.late_day * val;
								},
							},
							{ data: length },
							{ data: length },
							{ defaultContent: "" },
						],
						columnDefs: [
							{
								// The `data` parameter refers to the data for the cell (defined by the
								// `data` option, which defaults to the column being worked with, in
								// this case `data: 0`.
								render: function (data, type, row) {
									if (row.last_name == null) {
										return row.name;
									} else {
										return row.name + " " + row.last_name;
									}
								},
								targets: 1,
							},
							{
								// The `data` parameter refers to the data for the cell (defined by the
								// `data` option, which defaults to the column being worked with, in
								// this case `data: 0`.
								render: function (data, type, row) {
									return (
										+row.add_salary.cost +
										+row.add_salary.may_grant +
										+row.add_salary.variable_wages +
										+row.add_salary.prev_year_bonus +
										+row.add_salary.share_employer +
										+row.add_salary.bonus
									);
								},
								targets: 9,
							},
							{
								// The `data` parameter refers to the data for the cell (defined by the
								// `data` option, which defaults to the column being worked with, in
								// this case `data: 0`.
								render: function (data, type, row) {
									return (
										+row.sum_discount +
										+row.count_late * row.add_salary.late_day +
										+row.count_absent *
											row.add_salary.absent_day
									);
								},
								targets: 14,
							},
							{
								// The `data` parameter refers to the data for the cell (defined by the
								// `data` option, which defaults to the column being worked with, in
								// this case `data: 0`.
								render: function (data, type, row) {
									return (
										+row.add_salary.cost +
										+row.add_salary.may_grant +
										+row.add_salary.variable_wages +
										+row.add_salary.prev_year_bonus +
										+row.add_salary.share_employer +
										+row.add_salary.share_employee +
										+row.add_salary.bonus -
										(+row.sum_discount +
											+row.count_absent *
												+row.add_salary.absent_day +
											+row.count_late *
												+row.add_salary.late_day)
									);
								},
								targets: 15,
							},

							{ visible: false, targets: [2] },
						],
					});
					t.on("order.dt search.dt", function () {
						t.column(0, { search: "applied", order: "applied" })
							.nodes()
							.each(function (cell, i) {
								cell.innerHTML = i + 1;
								t.cell(cell).invalidate("dom");
							});
					}).draw();
				});
			},
			next() {
				this.month++;
				$("#users-table").DataTable().destroy();
				this.fetch();
			},
			prev() {
				this.month--;
				$("#users-table").DataTable().destroy();
				this.fetch();
			},
		},
	};
</script>
<style lang="postcss">
@media print {
	* {
		font-size: 14px;
	}
	table {
		border: 2px solid #000;
		padding: 20px;
	}
	.col-print-1 {
		width: 8%;
		float: left;
	}
	.col-print-2 {
		width: 16%;
		float: left;
	}
	.col-print-3 {
		width: 25%;
		float: left;
	}
	.col-print-4 {
		width: 33%;
		float: left;
	}
	.col-print-5 {
		width: 42%;
		float: left;
	}
	.col-print-6 {
		width: 50%;
		float: left;
	}
	.col-print-7 {
		width: 58%;
		float: left;
	}
	.col-print-8 {
		width: 66%;
		float: left;
	}
	.col-print-9 {
		width: 75%;
		float: left;
	}
	.col-print-10 {
		width: 83%;
		float: left;
	}
	.col-print-11 {
		width: 92%;
		float: left;
	}
	.col-print-12 {
		width: 100%;
		float: left;
	}
}
</style>
