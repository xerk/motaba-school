<template>
	<div class="page-content browse container-fluid">
		<div class="mx-auto flex w-full p-4 bg-white rounded-lg shadow-xl">
			<table id="dataTable" class="table">
				<thead>
					<tr>
						<th>Full Name</th>
						<th>Username</th>
						<th>Phone</th>
						<th>Gender</th>
						<th>Status</th>
						<th>Stage & Class</th>
						<th class="">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr class="users-table-row">
						<td class="users-table-data">
							<img
								src="https://old.schoolver.com/storage/users/February2019/ljDltV8u7FHevt82msBW.png"
								class="avatar"
								alt="Admin avatar"
								width="32px"
							/>
							Ahmed Mamdouh
						</td>
						<td class="users-table-data">XerK</td>
						<td class="users-table-data">201111981716</td>
						<td class="users-table-data">Male</td>
						<td class="users-table-data">New</td>
						<td class="users-table-data">1/3 ع</td>
						<td>
							<button type="submit" class="btn btn-primary">
								Edit
							</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script>
	export default {};
</script>

<style>
</style>
