<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('vendor.frontend.layout.layout');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    $namespacePrefixOwnaer = 'ConfigSchool\\';
    Route::get('school_configs', $namespacePrefixOwnaer.'SchoolConfigController@index')->name('school.configs.index')->middleware('admin.user');
    Route::get('year_configs', $namespacePrefixOwnaer.'SchoolYearController@index')->name('year.configs.index')->middleware('admin.user');
    Route::get('system_configs', $namespacePrefixOwnaer.'StageEduController@index')->name('system.configs.index')->middleware('admin.user');
    Route::get('attendances', 'AttendanceController@index')->name('school.attendances')->middleware('admin.user');
    Route::get('eattendances', 'EAttendanceController@index')->name('school.eattendances')->middleware('admin.user');
    Route::get('attentions', 'AttentionController@index')->name('school.attentions.index')->middleware('admin.user');
    Route::get('employee_salaries', 'EmployeeSalaryController@index')->name('school.employee_salaries.index')->middleware('admin.user');
    Route::get('expenses', 'ExpenseController@index')->name('school.expenses.index')->middleware('admin.user');
    Route::get('add_expenses', 'AddExpenseController@index')->name('school.add_expenses.index')->middleware('admin.user');
    Route::get('link_teachers', 'LinkTeacherController@index')->name('school.link_teacher.index')->middleware('admin.user');
    Route::get('single_student_reports', 'SingleStudentReportController@index')->name('school.single.student.report.index')->middleware('admin.user');
    Route::get('single_emp_reports', 'SingleEmpReportController@index')->name('school.single.emp.report.index')->middleware('admin.user');
    Route::get('suppliers/{supplier}/pay', 'SupplierController@pay')->name('voyager.suppliers.pay')->middleware('admin.user');
    Route::post('suppliers/{supplier}/pay', 'SupplierController@store')->name('voyager.suppliers.pay.store')->middleware('admin.user');

    Route::resource('users-2', 'UsersController')->middleware('admin.user');
    Route::resource('setting_numbers', 'SettingNumberController')->middleware('admin.user');
    Route::resource('secret_numbers', 'SecretNumberController')->middleware('admin.user');
    Route::resource('committees', 'CommitteeController')->middleware('admin.user');
    Route::resource('results', 'ResultController')->middleware('admin.user');
    Route::resource('add_salaries', 'AddSalaryController')->middleware('admin.user');

    Route::get('get-students', 'DatatablesController@anyData')->middleware('admin.user');
    Route::get('student_reports', 'DatatablesController@getIndex')->name('reprots.student.index')->middleware('admin.user');
    Route::get('parent_reports', 'DatatablesController@getIndexParent')->name('reprots.parent.index')->middleware('admin.user');
    Route::get('class_list_reports', 'DatatablesController@getIndexClassList')->name('reprots.class.list.index')->middleware('admin.user');
    Route::get('get-student-absent', 'AbsentReportController@anyData')->middleware('admin.user');
    Route::get('absent_students', 'AbsentReportController@getIndex')->name('reprots.absent.student.index')->middleware('admin.user');
    Route::get('get-employee-absent', 'AbsentReportController@anyDataEmp')->middleware('admin.user');
    Route::get('absent_employees', 'AbsentReportController@getIndexEmp')->name('reprots.absent.emp.index')->middleware('admin.user');
    Route::get('get-gender', 'GenderReportController@anyData')->middleware('admin.user');
    Route::get('gender_reports', 'GenderReportController@getIndex')->name('reprots.gender.index')->middleware('admin.user');
    Route::get('get-new-status', 'NewStatusReportController@anyData')->middleware('admin.user');
    Route::get('new_status_reports', 'NewStatusReportController@getIndex')->name('reprots.new.status.index')->middleware('admin.user');
    Route::get('get-newcomer', 'NewcomerReportController@anyData')->middleware('admin.user');
    Route::get('newcomer_reports', 'NewcomerReportController@getIndex')->name('reprots.newcomer.index')->middleware('admin.user');
    Route::get('get-transported', 'TransportedReportController@anyData')->middleware('admin.user');
    Route::get('transported_reports', 'TransportedReportController@getIndex')->name('reprots.transported.index')->middleware('admin.user');
    Route::get('get-transfer', 'TransferReportController@anyData')->middleware('admin.user');
    Route::get('transfer_reports', 'TransferReportController@getIndex')->name('reprots.transfer.index')->middleware('admin.user');
    Route::get('get-failure', 'FailureReportController@anyData')->middleware('admin.user');
    Route::get('failure_reports', 'FailureReportController@getIndex')->name('reprots.failure.index')->middleware('admin.user');
    Route::get('get-blind', 'BlindReportController@anyData')->middleware('admin.user');
    Route::get('blind_reports', 'BlindReportController@getIndex')->name('reprots.blind.index')->middleware('admin.user');
    Route::get('get-doctrine', 'DoctrineReportController@anyData')->middleware('admin.user');
    Route::get('doctrine_reports', 'DoctrineReportController@getIndex')->name('reprots.doctrine.index')->middleware('admin.user');
    Route::get('get-salary', 'SalaryReportController@anyData')->middleware('admin.user');
    Route::get('salary_reports', 'SalaryReportController@getIndex')->name('reprots.salary.index')->middleware('admin.user');
    Route::get('get-employee', 'EmpReportController@anyData')->middleware('admin.user');
    Route::get('employee_reports', 'EmpReportController@getIndex')->name('reprots.employee.index')->middleware('admin.user');

    Route::get('/{vue_capture?}', function () {
        return view('vendor.voyager.attentions.attentions');
      })->where('vue_capture', '[\/\w\.-]*')->middleware('admin.user');

    });
    $namespacePrefixOwnaer = 'ConfigSchool\\';
    Route::get('api/system-configs', $namespacePrefixOwnaer.'StageEduController@getSystemConfig')->middleware('admin.user');
    Route::get('api/attention', 'AttentionController@getStudents')->middleware('admin.user');
    Route::post('api/attention-post', 'AttentionController@store')->middleware('admin.user');
    Route::post('api/attention', 'AttentionController@update')->middleware('admin.user');


Auth::routes();


Route::group(['as' => 'frontend.'], function () {

    Route::get('locale/{locale}', function ($locale) {

        if (in_array($locale, \Config::get('app.locales'))) {
            Session::put('locale', $locale);
          }
          return redirect()->back();

        // this link will add session of language when they click to change langauge

    })->name('locale');

    Route::get('/setting', 'SettingAccountController@index')->name('setting')->middleware('user');

    Route::get('/@{username}', 'ProfileAccountController@index')->name('profile')->middleware('auth');

    Route::get('/attentions/@{username}', 'AttentionAccountController@index')->name('attentions')->middleware('auth');
    Route::get('/attentions/@{username}/{id}', 'AttentionAccountController@index')->name('attention.show')->middleware('auth');

    Route::get('/', 'LandingPageController@index')->name('home');

    Route::get('/news', 'NewsController@index')->name('news');
    Route::get('/news/{slug}', 'NewsController@categoryIndex')->name('news.category');
    Route::get('/news/{slug}/{id}', 'NewsController@show')->name('news.category.blog');

    Route::get('/blogs', 'LandingPageController@index')->name('blogs');

    Route::get('/p/{slug}', 'PagesController@show')->name('about');

    Route::get('/contact', 'ContactController@index')->name('contact');
    Route::post('/contact', 'ContactController@store')->name('contact.store');

    Route::get('/gallery', 'LandingPageController@index')->name('gallery');

});


// SMS API
Route::get('api/sms-misr', 'SmsMisrController@smsApi')->middleware('admin.user');


// Localization
Route::get('/js/lang.js', function () {
    $strings = Cache::remember('lang.js', 0.01, function () {
        $lang = Auth::user()->settings;
        $files   = glob(resource_path('lang/' . $lang['locale'] . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');
