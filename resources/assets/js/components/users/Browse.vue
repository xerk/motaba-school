<template>
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12 col-md-offset-4">
                <input type="text" placeholder='Search the docs (Press "/" to focus)' class="users-button-search">
                <div class="users-icon-search">
                    <svg class="" width="20px" height="20px" ><path class="search-color" d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path></svg>
                </div>
                <select name="" id="" class="users-select-box">
                    <option value="1">Role</option>
                </select>
                <select name="" id="" class="users-select-box">
                    <option value="1">Gender</option>
                </select>
                <select name="" id="" class="users-select-box">
                    <option value="1">Job</option>
                </select>
                <select name="" id="" class="users-select-box">
                    <option value="1">Status</option>
                </select>
            </div>
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Username</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th>Stage & Class</th>
                                        <th class="actions text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="users-table-row">
                                        <td class="users-table-data"><img src="https://kame-ouda.com/storage/users/February2019/ljDltV8u7FHevt82msBW.png" class="avatar" alt="Admin avatar" width="32px"> Ahmed Mamdouh</td>
                                        <td class="users-table-data">XerK</td>
                                        <td class="users-table-data">201111981716</td>
                                        <td class="users-table-data">Male</td>
                                        <td class="users-table-data">New</td>
                                        <td class="users-table-data">1/3 ع</td>
                                        <td><button type="submit" class="btn btn-primary">Edit</button></td>
                                    </tr>
                                </tbody>
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

    }

</script>

<style>
    .users-button-search {
        width: 672px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -1px rgba(0, 0, 0, .06) !important;
        padding-left: 3rem !important;
        padding-right: 1rem !important;
        padding-top: 14px;
        padding-bottom: 14px;
        line-height: 1.5 !important;
        display: block !important;
        border-width: 1px !important;
        border-radius: .5rem !important;
        border-color: transparent !important;
        background-color: #fff !important;
        border: 0 solid #e2e8f0;
        box-sizing: inherit;
        color: #718096;
        font-size: 16px;
        height: 50px;
    }
    .users-select-box {
        width: 200px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -1px rgba(0, 0, 0, .06) !important;
        padding-left: 1.5rem !important;
        padding-right: 1rem !important;
        line-height: 1.5 !important;
        border-width: 1px !important;
        border-radius: .5rem !important;
        border-color: transparent !important;
        background-color: #fff !important;
        border: 0 solid #e2e8f0;
        box-sizing: inherit;
        color: #718096;
        font-size: 16px;
        height: 50px;
        margin-top: 10px;
        margin-right: 10px;
    }
    .users-icon-search {
        position: absolute;
        top: 16px;
        left: 30px;
    }
    .search-color {
        fill: #718096;
    }
    .users-table-row {
        cursor: pointer;
    }
    .users-table-row:hover {
        background-color: #f3f3f3;
    }
    .users-table-data {
        vertical-align: middle !important;
        color: #718096;
    }
</style>
