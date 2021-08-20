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
// */
//use Illuminate\Support\Facades\Artisan;
//Route::get('/', function () {
//    Artisan::call('storage:link');
//  });

//Route::get('/clear-cache', function() {
//    $output = [];
//    \Artisan::call('cache:clear', $output);
//    dd($output);
//});


//Route::get('/clear-cache', function() {
//   shell_exec('composer update');
//   return 'updated';
//});

//jobs
Route::get('/','JobController@index');
Route::middleware(['auth'])->group(function() {
    Route::get('/jobs/create','JobController@create')->name('job.create');
    Route::post('/jobs/create','JobController@store')->name('job.store');
    Route::get('/jobs/{id}/edit','JobController@edit')->name('job.edit');
    Route::post('/jobs/{id}/edit','JobController@update')->name('job.update');
    Route::get('/jobs/my-job','JobController@myjob')->name('my.job');
    Route::get('/jobs/recommended','JobController@getRecommendedJobs')->name('my.job.recommended');
});

Route::get('/jobs/applications','JobController@applicant')->name('applicant');
Route::get('/jobs/alljobs','JobController@allJobs')->name('alljobs');
Route::get('/jobs/vue/search','JobController@searchJobsByVue')->name('vuesearch');



//Auth::routes();
Auth::routes(['verify' => true]);



	

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/jobs/{id}/{job}','JobController@show')->name('jobs.show');
//company
Route::get('/company/{id}/{company}','CompanyController@index')->name('company.index');
Route::get('company/create','CompanyController@create')->name('company.view');
Route::post('company/create','CompanyController@store')->name('company.store');


Route::post('company/coverphoto','CompanyController@coverPhoto')->name('cover.photo');

Route::post('company/logo','CompanyController@companyLogo')->name('company.logo');



//user profile
Route::get('user/profile','UserController@index')->name('user.profile');
Route::post('user/profile/create','UserController@store')->name('profile.create');

Route::post('user/coverletter','UserController@coverletter')->name('cover.letter');

Route::post('user/resume','UserController@resume')->name('resume');
Route::post('user/avatar','UserController@avatar')->name('avatar');

Route::get('{user}/applied-jobs','UserController@jobsApplied')->name('jobs.applied');

// Authenticated users can see the list of users and the job they applied for.
// User (seeker) profile update settings..

Route::view('employer/register','auth.employer-register')->name('employer.register');

Route::post('employer/register','EmployerRegisterController@employerRegister')->name('emp.register');


Route::middleware(['auth'])->group(function() {
    
Route::get('settings/{user}','UserController@settings')->name('my.settings');
Route::post('settings/reset-pass','UserController@changePassword');
Route::post('settings/reset-email','UserController@changeEmail');


//employer view

Route::get('employer/my-jobs','JobController@myJobs')->name('job.my');

Route::get('employer/my-user','UserController@userAppliedJobs')->name('myjobs.applied');
Route::get('employer/my-user/profile/{user}/job/{job}','UserController@userProfile')->name('myjobs.user_profile');

Route::post('/applications/{id}','JobController@apply')->name('apply');

});


//save and unsave job
Route::post('/save/{id}','FavouriteController@saveJob');

Route::post('/unsave/{id}','FavouriteController@unSaveJob');

//category
Route::get('/category/{id}/jobs','CategoryController@index')->name('category.index');

//company
Route::get('/companies','CompanyController@company')->name('company');


//admin
Route::get('/dashboard','DashboardController@index')->middleware('admin');
Route::get('/dashboard/create','DashboardController@create')->middleware('admin');
Route::post('/dashboard/create','DashboardController@store')->name('post.store')->middleware('admin');
Route::post('/dashboard/destroy','DashboardController@destroy')->name('post.delete')->middleware('admin');

Route::get('/dashboard/{id}/edit','DashboardController@edit')->name('post.edit')->middleware('admin');
Route::post('/dashboard/{id}/update','DashboardController@update')->name('post.update')->middleware('admin');

Route::get('/dashboard/trash','DashboardController@trash')->middleware('admin');

Route::get('/dashboard/{id}/trash','DashboardController@restore')->name('post.restore')->middleware('admin');

Route::get('/dashboard/{id}/toggle','DashboardController@toggle')->name('post.toggle')->middleware('admin');
Route::get('/posts/{id}/{slug}','DashboardController@show')->name('post.show');

Route::get('/dashboard/jobs','DashboardController@getAllJobs')->middleware('admin');
Route::get('/dashboard/{id}/jobs','DashboardController@changeJobStatus')->name('job.status')->middleware('admin');
Route::get('/dashboard/users/{job}','DashboardController@usersApplied')->name('users.applied')->middleware('admin');
Route::get('/dashboard/jobs/pdf','DashboardController@generatePDF')->name('pdf.generate')->middleware('admin');

//testimonial
Route::get('testimonial','TestimonialController@index')->middleware('admin');

Route::get('testimonial/create','TestimonialController@create')->middleware('admin');
Route::post('testimonial/create','TestimonialController@store')->name('testimonial.store')->middleware('admin');

//email
Route::post('/job/mail','EmailController@send')->name('mail');

// Github authentication
Route::get('{provider}/auth','SocialController@auth')->name('social.auth');
Route::get('/{provider}/redirect','SocialController@auth_callback')->name('social.callback');


// Route for chat

Route::get('/chat','ChatController@chat')->middleware('auth');
Route::post('jobs/chat/broadcast','ChatController@broadcast')->middleware('auth');
Route::post('jobs/chat/private-message','ChatController@broadcastPrivate')->middleware('auth');


Route::post('jobs/saveToSession','ChatController@saveToSession');
Route::post('jobs/getSessionMessages','ChatController@getSessionMessages');
Route::post('jobs/deleteSession','ChatController@deleteSession');


Route::get('check',function(){
    return session()->get('chat');
});

//vue roter

// Route::get('vue/{any}', function () {
//     return view('vue');
//   })->where('any', '.*');