<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('login', array('as' => 'auth.form', 'uses' => 'AuthController@getLogin'));
Route::post('login', array('as' => 'login.auth', 'uses' => 'AuthController@login'));
Route::get('logout', array('uses' => 'AuthController@logout'));

Route::group(array('before' => 'auth'), function(){
	
	Route::get('/', array('as' => 'dashboard', 'uses' => 'DashboardController@showDashboard'));
	//Route::get('import', array('as' => 'import', 'uses' => 'DashboardController@importData'));
	//Route::get('change', array('as' => 'change', 'uses' => 'DashboardController@changeCase'));
	
	// Project Management Routing
	Route::resource('project','ProjectsController');
	Route::resource('program','ProgramsController');
	Route::resource('kelas','CoursesController');
	Route::resource('kegiatan','ActivitiesController');
	Route::resource('voucher','VouchersController');
	Route::resource('promo','PromotionsController');
	Route::resource('diskon', 'DiscountsController');
	Route::resource('charge','ChargesController');
	Route::resource('handbook', 'HandbooksController');
		Route::put('handbook/{id}/opname', 'HandbooksController@opname');
	Route::resource('studi', 'SubjectsController');

	// Data Management Routing
	Route::resource('cabang','LocationsController');
	Route::resource('ruangan','RoomsController');
	Route::resource('jam', 'HoursController');
	Route::resource('sekolah','SchoolsController');
	Route::resource('user','UsersController');
	Route::resource('klasifikasi','ClassificationsController');
	Route::resource('aset', 'EntitiesController');
		Route::put('aset/{id}/opname', 'EntitiesController@opname');
	Route::resource('mitra', 'PartnersController');

	// Students Management Routing
	Route::resource('pendaftaran','RegistrationsController');
		Route::put('pendaftaran/{id}/biaya', 'RegistrationsController@purchaseCost');
	Route::resource('siswa', 'StudentsController');
		Route::get('siswa/{id}/raport', 'StudentsController@report');
	Route::resource('perpindahan', 'MovementsController');
		Route::put('perpindahan/{id}/bayar','MovementsController@payment');
	Route::resource('keluar', 'ResignsController');
		Route::put('keluar/{id}/denda', 'ResignsController@earnFines');
		Route::put('keluar/{id}/retur', 'ResignsController@giveReturnment');
	Route::resource('pengambilan', 'RetrievalsController');
	Route::resource('nomorpokok', 'IssuesController');
	Route::resource('penempatan', 'PlacementsController');

	// Academic Management Routing
	Route::resource('jadwal', 'SchedulesController');
	Route::resource('presensi', 'PresencesController', array('only' => array('index','show','store','edit','update','destroy')));
		Route::get('presensi/create/{course_id}', 'PresencesController@create');
		Route::get('presensi/filter/{date}', 'PresencesController@filter');
	Route::resource('quiz', 'QuizzesController', array('only' => array('index','store','show','edit','update','destroy')));
		Route::get('quiz/create/{course_id}', 'QuizzesController@create');
	Route::resource('nilai', 'PointsController', array('only' => array('index','store','show','edit','update','destroy')));
		Route::get('nilai/create/{activity_id}', 'PointsController@create');
	Route::resource('partisipasi', 'ParticipationsController');
	Route::resource('penguasaan', 'MasteriesController');
		Route::get('penguasaan/create/{course_id}','MasteriesController@create');

	// Finance Management Routing
	Route::resource('receivable','ReceivablesController');
		Route::put('receivable/{id}/cash', 'ReceivablesController@makeCash');
	Route::resource('reduction','ReductionsController');
	Route::resource('angsuran','InstallmentsController');
		Route::put('angsuran/{id}/bayar', 'InstallmentsController@purchase');
		Route::get('angsuran/filter/{month}/{year}','InstallmentsController@filter');
	Route::resource('penerimaan', 'EarningsController', array('only' => array('index','show','store','destroy')));
		Route::get('penerimaan/filter/{month}/{year}','EarningsController@filter');
		Route::get('penerimaan/{issue}/create','EarningsController@create');
	Route::resource('pengeluaran', 'SpendingsController');
	Route::resource('denda', 'PunishmentsController', array('only' => array('index','create','store','destroy')));
		Route::get('denda/filter/{month}/{year}', 'PunishmentsController@filter');
		Route::put('denda/{id}/bayar', 'PunishmentsController@purchase');
		Route::put('denda/{id}/batal', 'PunishmentsController@unPurchase');
	Route::resource('pengembalian', 'ReturnmentsController');

	// Employee Management Routing
	Route::resource('karyawan', 'EmployeesController');
	Route::resource('mengajar', 'TeachesController', array('only' => array('index','show','edit','update','destroy')));
		Route::get('mengajar/filter/{date}', 'TeachesController@filter');
	Route::resource('payroll', 'PayrollsController', array('only' => array('index','show','store','destroy')));
		Route::get('payroll/filter/{month}/{year}', 'PayrollsController@filter');
		Route::get('payroll/create/{id}/{month}/{year}', 'PayrollsController@create');
		Route::put('payroll/cairkan/{id}', 'PayrollsController@withdraw');
	Route::resource('income', 'IncomesController');
		Route::get('income/filter/{month}/{year}', 'IncomesController@filter');
	Route::resource('deduction', 'DeductionsController');
		Route::get('deduction/filter/{month}/{year}', 'DeductionsController@filter');

	// AJAX Call Routing
	Route::get('loadcities/{state_id}', 'AjaxesController@loadCities');
	Route::get('loadschools/{name}', 'AjaxesController@loadSchools');
	Route::get('loadprojects','AjaxesController@loadProjects');
	Route::get('loadlocations', 'AjaxesController@loadLocations');
	Route::get('loadcourses/{generation_id}', 'AjaxesController@loadCourses');
	Route::get('suggestissue/{course_id}','AjaxesController@suggestIssue');
	Route::get('loadstudents/{course}','AjaxesController@loadStudents');
	Route::get('hardfilterstudents/{name}','AjaxesController@hardFilterStudents');
	Route::get('softfilterstudents/{name}','AjaxesController@softFilterStudents');
	Route::get('loadfatherjobs/{job}', 'AjaxesController@filterFatherOccupation');
	Route::get('loadmotherjobs/{job}', 'AjaxesController@filterMotherOccupation');
	Route::get('filterhandbookbyissue/{issue}', 'AjaxesController@filterHandbookByIssue');
	Route::get('loadearnables/{issue}', 'AjaxesController@loadEarnables');
	Route::get('loadreductions/{what}', 'AjaxesController@loadReductions');
	Route::get('suggestemployee/{name}', 'AjaxesController@suggestEmployees');

	// Setup Routing
	Route::get('pengaturan', 'SetupsController@index');
	Route::put('changeproject','SetupsController@changeProject');
	Route::put('changelocation','SetupsController@changeLocation');
	Route::put('normalizeissue','SetupsController@normalizeIssue');


	// Report Management Routing
	Route::get('laporan','ReportsController@index');

		// Students Per Generation
		Route::get('laporan/siswa-per-tingkatan','ReportsController@studentPerGeneration');
		Route::get('laporan/siswa-per-tingkatan/filter/{generation}','ReportsController@studentPerGenerationFilter');

		// Students Per Course
		Route::get('laporan/siswa-per-kelas','ReportsController@studentPerCourse');
		Route::get('laporan/siswa-per-kelas/filter/{course}','ReportsController@studentPerCourseFilter');

		// Students Per School
		Route::get('laporan/siswa-per-sekolah','ReportsController@studentPerSchool');
		Route::get('laporan/siswa-per-sekolah/filter/{school}','ReportsController@studentPerSchoolFilter');

		// Students Per Program
		Route::get('laporan/siswa-per-program','ReportsController@studentPerProgram');
		Route::get('laporan/siswa-per-program/filter/{program}','ReportsController@studentPerProgramFilter');

		// Registrations
		Route::get('laporan/siswa-masuk','ReportsController@registrations');
		Route::get('laporan/siswa-masuk/filter/{classification}','ReportsController@registrationsFilter');

		// Resigns
		Route::get('laporan/siswa-keluar','ReportsController@resigns');
		Route::get('laporan/siswa-keluar/filter/{classification}','ReportsController@resignsFilter');

		// Estimations
		Route::get('laporan/estimasi','ReportsController@estimations');
		Route::get('laporan/estimasi/filter/{month}/{year}','ReportsController@estimationsFilter');

		// Earnings
		Route::get('laporan/penerimaan','ReportsController@earnings');
		Route::get('laporan/penerimaan/filter/{month}/{year}','ReportsController@earningsFilter');

		// Lates
		Route::get('laporan/menunggak','ReportsController@lates');
		Route::get('laporan/menunggak/filter/{month}/{year}','ReportsController@latesFilter');

		// Reductions
		Route::get('laporan/pemotongan','ReportsController@reductions');
		Route::get('laporan/pemotongan/filter/{types}/{id}','ReportsController@reductionsFilter');


		// Recap Generation Periodically
		Route::get('laporan/rekap-tingkat','ReportsController@recapGeneration');

		// Recap Course Periodically
		Route::get('laporan/rekap-kelas','ReportsController@recapCourse');

		// Recap School Periodically
		Route::get('laporan/rekap-sekolah-periodik', 'ReportsController@recapSchoolPeriodic');

		// Recap School Generationally
		Route::get('laporan/rekap-sekolah-tingkat', 'ReportsController@recapSchoolGeneration');

		// Recap Active Periodic
		Route::get('laporan/rekap-sirkulasi-periodik', 'ReportsController@recapCirculationPeriodic');

		// Recap Active Generation
		Route::get('laporan/rekap-sirkulasi-tingkat', 'ReportsController@recapCirculationGeneration');

		// Recap Reduction Periodic
		Route::get('laporan/rekap-potongan-periodik', 'ReportsController@recapActivePeriodic');

		// Recap Reduction Generation
		Route::get('laporan/rekap-potongan-tingkat', 'ReportsController@recapActiveGeneration');
});