<template>
	<div class="page-content browse container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-bordered">
					<div class="panel-body">
						<h3 class="timetable-header text-center">
							<span v-if="classEdu != ''">{{
								classRoomName.class_edu.name
							}}</span>
							-
							<span v-if="classRoom != ''">{{
								classRoomName.name
							}}</span>
						</h3>
						<div class="content-header" style="display: none">
							<div class="row">
								<div
									class="col-print-4 pull-left"
									style="padding-left: 10px"
								>
									<img
										src="https://old.schoolver.com/images/logo/PNG-24.png"
										alt="Logo"
										style="width: 75px"
										class="img-responsive"
									/>
								</div>
								<div class="col-print-4 text-center">
									<h3 class="text-center">
										<span v-if="classEdu != ''">{{
											classRoomName.class_edu.name
										}}</span>
										-
										<span v-if="classRoom != ''">{{
											classRoomName.name
										}}</span>
									</h3>
								</div>
								<div
									class="col-print-4"
									style="padding-right: 10px"
								>
									<ul
										class="list-unstyled timetable-list text-center pull-right"
									>
										<li>الأزهر الشريف</li>
										<li>منطقة الجيزه الأزهريه</li>
										<li>معهد كامل عودة الأزهري الخاص</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="content-footer" style="display: none">
							<div class="row">
								<div
									class="col-print-6 text-center timetable-font-size"
									style="padding-left: 10px"
								>
									<ul class="list-unstyled">
										<li>عميد المعهد</li>
										<li>أ/سعيد عيسي</li>
									</ul>
								</div>
								<div
									class="col-print-6 text-center timetable-font-size"
									style="padding-right: 10px"
								>
									<ul class="list-unstyled">
										<li>شئون الطلبة</li>
										<li>
											أ/جيهان عبد الحميد&nbsp; أ/عطيلت عز
											الرجال
										</li>
									</ul>
								</div>
							</div>
							<span
								style="
									position: fixed;
									bottom: 0;
									font-size: 12px;
									padding: 3px;
									font-weight: 400;
								"
								><img
									src="https://old.schoolver.com/images/logo/motawer-black.png"
									alt="Logo"
									style="
										width: 32px;
										display: inline;
										margin-right: 5px;
									"
									class="img-responsive"
								/>
								Powered by MOTAWER</span
							>
						</div>
						<hr />
						<table
							dir="auto"
							class="table dataTable timetable-table"
							id="users-table"
						>
							<thead class="timetable-thead">
								<tr class="timetable-tr">
									<th>الحصة / اليوم</th>
									<th>الأولى</th>
									<th>الثانية</th>
									<th>الثالثة</th>
									<th>الرابعة</th>
									<th>الخامسة</th>
									<th>السادسة</th>
									<th>السابعة</th>
									<th>الثامنة</th>
								</tr>
							</thead>
							<tbody class="timetable-tbody">
								<tr>
									<td>الأحد</td>
									<td
										v-for="(item, key) in timetableSun"
										:key="key"
										@click="openModal(item)"
										v-html="
											item.subject
												? item.subject.name
												: '<span></span>'
										"
									></td>
								</tr>
								<tr>
									<td>الإثنين</td>
									<td
										v-for="(item, key) in timetableMon"
										:key="key"
										@click="openModal(item)"
										v-html="
											item.subject
												? item.subject.name
												: '<span></span>'
										"
									></td>
								</tr>
								<tr>
									<td>الثلاثاء</td>
									<td
										v-for="(item, key) in timetableTues"
										:key="key"
										@click="openModal(item)"
										v-html="
											item.subject
												? item.subject.name
												: '<span></span>'
										"
									></td>
								</tr>
								<tr>
									<td>الأربعاء</td>
									<td
										v-for="(item, key) in timetableWedens"
										:key="key"
										@click="openModal(item)"
										v-html="
											item.subject
												? item.subject.name
												: '<span></span>'
										"
									></td>
								</tr>
								<tr>
									<td>الخميس</td>
									<td
										v-for="(item, key) in timetableThurs"
										:key="key"
										@click="openModal(item)"
										v-html="
											item.subject
												? item.subject.name
												: '<span></span>'
										"
									></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<fab @parsist="parsist"></fab>
		<modal-timetable
			:selectRow="selectRow"
			:subjects="subjects"
			@confirm="editOption"
			v-if="modal"
			@close="modal = false"
		></modal-timetable>
	</div>
</template>
<script>
	import Fab from "./fab/Fab";
	import ModalTimetable from "./modal/ModalTimetable";
	export default {
		components: {
			Fab,
			ModalTimetable,
		},
		props: ["link"],
		data() {
			return {
				modal: false,
				selectRow: {},
				subjects: [],
				get: {
					apiURL: "timetables",
				},
				post: {
					apiURL: "timetables",
				},
				postTwo: {
					apiURL: "timetables-update",
				},
				timetables: [],
				classRoomName: {
					name: "",
					class_edu: { name: "" },
				},
				stageEdu: localStorage.stageEdu,
				classEdu: localStorage.classEdu,
				classRoom: localStorage.classRoom,
			};
		},
		mounted() {
			this.fetch();
			setTimeout(() => {
				this.dataTables();
			}, 1000);
		},
		computed: {
			timetablesSort() {
				return _.orderBy(this.timetables, "order", "asc");
			},
			timetableSun() {
				return this.timetablesSort.filter((item) => {
					return item.day_name == 2;
				});
			},
			timetableMon() {
				return this.timetablesSort.filter((item) => {
					return item.day_name == 3;
				});
			},
			timetableTues() {
				return this.timetablesSort.filter((item) => {
					return item.day_name == 4;
				});
			},
			timetableWedens() {
				return this.timetablesSort.filter((item) => {
					return item.day_name == 5;
				});
			},
			timetableThurs() {
				return this.timetablesSort.filter((item) => {
					return item.day_name == 6;
				});
			},
		},
		methods: {
			openModal(item) {
				this.modal = true;
				this.selectRow = item;
			},
			editOption(value) {
				this.modal = false;
				let index = this.timetables.indexOf(value);
				this.$store
					.dispatch("submitForm", {
						post: this.postTwo,
						id: value.id,
						subject: value.subject_id,
					})
					.then((response) => {
						this.$toast.success({
							title: response.data,
						});
						this.fetch();
					});
				this.selectRow = null;
			},
			parsist(stageEdu, classEdu, classRoom) {
				this.stageEdu = stageEdu;
				this.classEdu = classEdu;
				this.classRoom = classRoom;
				this.fetch();
			},
			fetch() {
				this.$store
					.dispatch("retriveUser", {
						get: this.get,
						classEdu: this.classEdu,
						classRoom: this.classRoom,
					})
					.then((response) => {
						this.timetables = response.data.timetables;
						this.classRoomName = response.data.classRoom;
						this.subjects = response.data.subjects;
					});
			},
			dataTables() {
				$(function () {
					$("#users-table").DataTable({
						dom: "Bfrtip",
						buttons: [
							{
								extend: "print",
								autoPrint: false,
								text:
									'<i class="fa fa-print" aria-hidden="true"></i> طباعة',
								customize: function (win) {
									$(win.document.body).css("font-size", "11px");
									$(win.document.body)
										.find("div")
										.first()
										.prepend(
											$(".content-header").clone().css({
												display: "block",
											})
										);

									$(win.document.body)
										.find("div")
										.last()
										.prepend(
											$(".content-footer").clone().css({
												display: "block",
												"margin-top": "20px",
											})
										);

									$(win.document.body)
										.find("h1")
										.css("display", "none");
									$(win.document.body)
										.find("table")
										.addClass("timetable-table")
										.css("direction", "rtl");
									$(win.document.body).find("th").css({
										"text-align": "center",
										height: "50px",
										border: "2px solid #000",
										"vertical-align": "middle",
										"text-align": "center",
									});
									$(win.document.body)
										.find("tbody tr")
										.css("height", "90px");
									$(win.document.body).find("td").css({
										"text-align": "center",
										"vertical-align": "middle",
										border: "1px solid #EAEAEA",
									});
									$(win.document.body)
										.find("td:first-child")
										.css({
											width: "200px",
											"font-weight": "600",
										});
								},
							},
						],
						searching: false,
						paging: false,
						ordering: false,
						serverSide: false,
					});
				});
			},
		},
	};
</script>

<style>
.lecture-select-box {
	/* width: 300px; */
	margin-bottom: 5px;
	float: right;
}
.attend-button {
	margin-bottom: 5px;
	float: left;
}
.fade-enter-active,
.fade-leave-active {
	transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
	opacity: 0;
}
.list-item {
	display: inline-block;
	margin-right: 3px;
}
.list-enter-active,
.list-leave-active {
	transition: all 0.5s;
}
.list-enter, .list-leave-to /* .list-leave-active below version 2.1.8 */ {
	opacity: 0;
	transform: translateY(30px);
}

.img-avatar {
	width: 35px;
	margin-right: 5px;
	box-shadow: 0 2px 10px rgba(0, 0, 0, 0.16);
	border-radius: 100%;
}
.timetable-table .timetable-thead th {
	height: 50px;
	border: 1px solid #eee;
	vertical-align: middle;
	text-align: center;
}

.timetable-table .timetable-tbody tr {
	height: 100px;
}

.timetable-table .timetable-tbody tr td {
	text-align: center;
	vertical-align: middle !important;
	border: 1px solid #eaeaea;
}

.timetable-table .timetable-tbody tr td:first-child {
	width: 200px;
	color: #fff;
	font-weight: 600;
	background-color: #22a7f0;
}

.timetable-table .timetable-tbody tr td:not(:first-child):hover {
	background-color: #06689e;
	cursor: pointer;
	color: #fff;
	font-weight: 400;
}

.timetable-table .timetable-tbody tr td:not(:first-child):active {
	background-color: #064377;
	cursor: pointer;
	color: #fff;
	font-weight: 400;
}

.timetable-table .timetable-tbody tr td:not(:first-child):focus {
	background-color: #064377;
	cursor: pointer;
	color: #fff;
	font-weight: 400;
}

@media print {
	.timetable-font-size {
		font-size: 14px;
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
