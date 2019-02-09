<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
$namespacePrefixOwnaer = 'ConfigSchool\\';
Route::get('school-configs', $namespacePrefixOwnaer.'SchoolConfigController@getDataConfig');
Route::post('school-configs/add', $namespacePrefixOwnaer.'SchoolConfigController@store');

Route::get('year-configs', $namespacePrefixOwnaer.'SchoolYearController@getYearConfig');
Route::post('year-configs/add', $namespacePrefixOwnaer.'SchoolYearController@store');
Route::delete('year-configs/{id}', $namespacePrefixOwnaer.'SchoolYearController@destroy');
Route::delete('semster-configs/{id}', $namespacePrefixOwnaer.'SchoolYearController@destroySemster');

// Route::get('system-configs', $namespacePrefixOwnaer.'StageEduController@getSystemConfig');
Route::post('system-configs/add', $namespacePrefixOwnaer.'StageEduController@store');
Route::post('system-configs-update', $namespacePrefixOwnaer.'StageEduController@update');
Route::post('system-configs-update-class', $namespacePrefixOwnaer.'StageEduController@updateClass');
Route::post('system-configs-update-class-room', $namespacePrefixOwnaer.'StageEduController@updateClassRoom');
Route::delete('system-configs/{id}', $namespacePrefixOwnaer.'StageEduController@destroy');
Route::delete('class-configs/{id}', $namespacePrefixOwnaer.'StageEduController@destroyClass');
Route::delete('class-room-configs/{id}', $namespacePrefixOwnaer.'StageEduController@destroyClassRoom');

Route::get('attendance', 'AttendanceController@getStudents');
Route::post('attendance', 'AttendanceController@update');
Route::post('attendance-post', 'AttendanceController@store');

Route::get('eattendance', 'EAttendanceController@getEmployees');
Route::post('eattendance', 'EAttendanceController@update');
Route::post('eattendance-post', 'EAttendanceController@store');

Route::delete('attention/{id}', 'AttentionController@destroy');

Route::get('results', 'ResultController@getResults');

Route::get('employee', 'EmployeeSalaryController@getEmployees');
Route::get('employee-details', 'EmployeeSalaryController@getEmployeeDetails');
Route::get('salary-emp', 'EmployeeSalaryController@salaryEmp');
Route::post('salary-update', 'EmployeeSalaryController@update');
Route::post('make-payment', 'EmployeeSalaryController@store');
Route::delete('make-payment/{id}', 'EmployeeSalaryController@destroy');


Route::get('add-expeneses', 'AddExpenseController@getAddExpenses');

Route::get('expeneses', 'ExpenseController@getExpenses');
Route::get('management-exp', 'ExpenseController@studentExpenses');
Route::post('expeneses', 'ExpenseController@store');
Route::post('expeneses-update', 'ExpenseController@update');
Route::delete('expeneses/{id}', 'ExpenseController@destroy');

Route::get('link-teachers', 'LinkTeacherController@getTeachers');
Route::get('link-teacher', 'LinkTeacherController@getTeacher');
Route::post('link-teacher', 'LinkTeacherController@store');
Route::post('link-teacher-update', 'LinkTeacherController@update');
Route::delete('link-teacher/{id}', 'LinkTeacherController@destroy');

Route::get('single-student-report', 'SingleStudentReportController@getStudent');
Route::get('single-student-report/show', 'SingleStudentReportController@show');

Route::get('single-emp-report', 'SingleEmpReportController@getStudent');
Route::get('single-emp-report/show', 'SingleEmpReportController@show');
Route::get('single-emp-report/salaryshow', 'SingleEmpReportController@getEmployeeDetails');

Route::get('supplier-pay', 'SupplierController@getSupplier');
Route::get('supplier-pay/show', 'SupplierController@getStorage');
Route::post('supplier-pay', 'SupplierController@store');
Route::post('supplier-pay/show', 'SupplierController@storeShow');
Route::delete('supplier-pay/{id}', 'SupplierController@destroy');
Route::delete('supplier-pay-show/{id}', 'SupplierController@destroyShow');


Route::post('sms-attendance', 'SmsMisrController@storeAttendance');
Route::post('sms-eattendance', 'SmsMisrController@storeEAttendance');

Route::get('report-users', 'ReportUsersController@index');