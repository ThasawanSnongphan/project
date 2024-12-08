<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\CostTypeController;
use App\Http\Controllers\ExpenseBadgetController;
use App\Http\Controllers\ProCharecController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UniPlanController;
use App\Http\Controllers\BadgetTypeController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\ProjectIntegratController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StrategicController;
use App\Http\Controllers\SFAController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\TacticsController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\KPIMainController;
use App\Http\Controllers\CountKPIProject;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\WordController;

Route::get('/gen-word', [WordController::class, 'createWordDoc']); //แบบไม่ db
Route::get('/gen-word-db/{$id}', [WordController::class, 'createWordDocFromDB']); //db

Route::get('/generate-pdf', [PDFController::class, 'generatePDF']); //แบบไม่ db
Route::get('/generate-pdf-db', [PDFController::class, 'db_gen']); //db

Route::get('/', [NewsController::class,'index']);
Auth::routes();
Route::get('/login', [AuthController::class,'login']);
Route::post('loginPost',[AuthController::class,'loginPost']);
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate(); // ล้าง session
    request()->session()->regenerateToken(); // ป้องกัน CSRF attacks
    return redirect('/'); // เปลี่ยนเส้นทางกลับไปหน้าแรก
});

Route::get('/countKPI', [CountKPIProject::class,'index']);
Route::post('/countKPIInsert',[CountKPIProject::class,'insert']);
Route::get('countKPIdelete/{id}',[CountKPIProject::class,'delete'])->name('countKPI.delete');
Route::get('countKPIedit/{id}',[CountKPIProject::class,'edit'])->name('countKPI.edit');
Route::post('countKPIupdate/{id}',[CountKPIProject::class,'update'])->name('countKPI.update');

Route::get('/project', [ProjectController::class,'index']);
Route::get('/projectcreate', [ProjectController::class,'create']);
Route::post('/projectSave', [ProjectController::class,'save']);
Route::post('/projectSend', [ProjectController::class,'send']);
Route::get('projectdelete/{id}',[ProjectController::class,'delete'])->name('project.delete');
Route::get('projectedit/{id}',[ProjectController::class,'edit'])->name('project.edit');
Route::post('projectupdate/{id}',[ProjectController::class,'update'])->name('project.update');
Route::get('projectreport/{id}',[ProjectController::class,'report'])->name('project.report');
Route::post('departmentPass/{id}', [ProjectController::class,'departmentPass'])->name('departmentPass');
Route::post('/departmentEdit', [ProjectController::class,'departmentEdit']);

Route::get('projectPDF/{id}',[PDFController::class,'db_gen'])->name('project.PDF');
Route::get('projectWord/{id}',[WordController::class,'createWordDocFromDB'])->name('project.Word');


Route::get('create',[NewsController::class,'create']);
Route::post('insert',[NewsController::class,'insert']);
Route::get('ndelete/{id}',[NewsController::class,'delete'])->name('news.delete');
Route::get('nedit/{id}',[NewsController::class,'edit'])->name('news.edit');
Route::post('nupdate/{id}',[NewsController::class,'update'])->name('news.update');

Route::get('users', [UserController::class,'index']);
Route::get('uCreate',[UserController::class,'create']);
Route::post('uInsert', [UserController::class, 'insert']);
Route::get('uDelete/{id}',[UserController::class,'delete'])->name('users.delete');
Route::get('uedit/{id}',[UserController::class,'edit'])->name('users.edit');
Route::post('uupdate/{id}',[UserController::class,'update'])->name('users.update');

Route::get('year',[YearController::class,'index']);
Route::get('yCreate',[YearController::class,'create']);
Route::post('yInsert',[YearController::class,'insert']);
Route::get('yDelete/{id}',[YearController::class,'delete'])->name('years.delete');
Route::get('edit/{id}',[YearController::class,'edit'])->name('years.edit');
Route::post('update/{id}',[YearController::class,'update'])->name('years.update');

Route::get('Expense',[ExpenseBadgetController::class,'index']);
Route::get('ExCreate',[ExpenseBadgetController::class,'create']);
Route::post('ExInsert',[ExpenseBadgetController::class,'insert']);
Route::get('exDelete/{expID}',[ExpenseBadgetController::class,'delete'])->name('ex.delete');
Route::get('exedit/{expID}',[ExpenseBadgetController::class,'edit'])->name('ex.edit');
Route::post('exupdate/{expID}',[ExpenseBadgetController::class,'update'])->name('ex.update');

Route::get('cost_type',[CostTypeController::class,'index']);
Route::get('costCreate',[CostTypeController::class,'create']);
Route::post('costInsert',[CostTypeController::class,'insert']);
Route::get('costDelete/{id}',[CostTypeController::class,'delete'])->name('costs.delete');
Route::get('costedit/{id}',[CostTypeController::class,'edit'])->name('costs.edit');
Route::post('costupdate/{id}',[CostTypeController::class,'update'])->name('costs.update');

Route::get('proChar',[ProCharecController::class,'index']);
Route::get('prochaCreate',[ProCharecController::class,'create']);
Route::post('prochaInsert',[ProCharecController::class,'insert']);
Route::get('proDelete/{id}',[ProCharecController::class,'delete'])->name('pro.delete');
Route::get('proedit/{id}',[ProCharecController::class,'edit'])->name('pro.edit');
Route::post('proupdate/{id}',[ProCharecController::class,'update'])->name('pro.update');

Route::get('status',[StatusController::class,'index']);
Route::get('statusCreate',[StatusController::class,'create']);
Route::post('statusInsert',[StatusController::class,'insert']);
Route::get('statusDelete/{id}',[StatusController::class,'delete'])->name('status.delete');
Route::get('statusEdit/{id}',[StatusController::class,'edit'])->name('status.edit');
Route::post('statusUpdate/{id}',[StatusController::class,'update'])->name('status.update');

Route::get('plan',[UniPlanController::class,'index']);
Route::get('planCreate',[UniPlanController::class,'create']);
Route::post('planInsert',[UniPlanController::class,'insert']);
Route::get('planDelete/{id}',[UniPlanController::class,'delete'])->name('plan.delete');
Route::get('planEdit/{id}',[UniPlanController::class,'edit'])->name('plan.edit');
Route::post('planUpdate/{id}',[UniPlanController::class,'update'])->name('plan.update');

Route::get('BadgetType',[BadgetTypeController::class,'index']);
Route::post('BadgetTypeInsert',[BadgetTypeController::class,'insert']);
Route::get('BadegetTypeDelete/{id}',[BadgetTypeController::class,'delete'])->name('badgetType.delete');
Route::get('BadgetTypeEdit/{id}',[BadgetTypeController::class,'edit'])->name('badgetType.edit');
Route::post('BadgetTypeUpdate/{id}',[BadgetTypeController::class,'update'])->name('badgetType.update');

Route::get('projectType',[ProjectTypeController::class,'index']);
Route::post('projectTypeInsert',[ProjectTypeController::class,'insert']);
Route::get('projectTypeDelete/{id}',[ProjectTypeController::class,'delete'])->name('projectType.delete');
Route::get('projectTypeEdit/{id}',[ProjectTypeController::class,'edit'])->name('projectType.edit');
Route::post('projectTypeUpdate/{id}',[ProjectTypeController::class,'update'])->name('projectType.update');

Route::get('projectIntegrat',[ProjectIntegratController::class,'index']);
Route::post('projectIntegratInsert',[ProjectIntegratController::class,'insert']);
Route::get('projectIntegratDelete/{id}',[ProjectIntegratController::class,'delete'])->name('projectIntegrat.delete');
Route::get('projectIntegratEdit/{id}',[ProjectIntegratController::class,'edit'])->name('projectIntegrat.edit');
Route::post('projectIntegratUpdate/{id}',[ProjectIntegratController::class,'update'])->name('projectIntegrat.update');

Route::get('target',[TargetController::class,'index']);
Route::post('targetInsert',[TargetController::class,'insert']);
Route::get('targetDelete/{id}',[TargetController::class,'delete'])->name('target.delete');
Route::get('targetEdit/{id}',[TargetController::class,'edit'])->name('target.edit');
Route::post('targetUpdate/{id}',[TargetController::class,'update'])->name('target.update');

Route::get('strategic',[StrategicController::class,'index']);
Route::post('strategicInsert',[StrategicController::class,'insert']);
Route::get('strategicDelete/{id}',[StrategicController::class,'delete'])->name('strategic.delete');
Route::get('strategicEdit/{id}',[StrategicController::class,'edit'])->name('strategic.edit');
Route::post('strategicUpdate/{id}',[StrategicController::class,'update'])->name('strategic.update');

Route::get('SFA',[SFAController::class,'index']);
Route::post('SFAInsert',[SFAController::class,'insert']);
Route::get('SFADelete/{id}',[SFAController::class,'delete'])->name('SFA.delete');
Route::get('SFAEdit/{id}',[SFAController::class,'edit'])->name('SFA.edit');
Route::post('SFAUpdate/{id}',[SFAController::class,'update'])->name('SFA.update');

Route::get('goal',[GoalController::class,'index']);
Route::post('goalInsert',[GoalController::class,'insert']);
Route::get('goalDelete/{id}',[GoalController::class,'delete'])->name('goal.delete');
Route::get('goalEdit/{id}',[GoalController::class,'edit'])->name('goal.edit');
Route::post('goalUpdate/{id}',[GoalController::class,'update'])->name('goal.update');

Route::get('tactics',[TacticsController::class,'index']);
Route::post('tacticsInsert',[TacticsController::class,'insert']);
Route::get('tacticsDelete/{id}',[TacticsController::class,'delete'])->name('tactics.delete');
Route::get('tacticsEdit/{id}',[TacticsController::class,'edit'])->name('tactics.edit');
Route::post('tacticsUpdate/{id}',[TacticsController::class,'update'])->name('tactics.update');

Route::get('KPIMain',[KPIMainController::class,'index']);
Route::post('KPIMainInsert',[KPIMainController::class,'insert']);
Route::get('KPIMainDelete/{id}',[KPIMainController::class,'delete'])->name('KPIMain.delete');
Route::get('KPIMainsEdit/{id}',[KPIMainController::class,'edit'])->name('KPIMain.edit');
Route::post('KPIMainUpdate/{id}',[KPIMainController::class,'update'])->name('KPIMain.update');

Route::get('fund',[FundController::class,'index']);
Route::post('fundInsert',[FundController::class,'insert']);
Route::get('fundDelete/{id}',[FundController::class,'delete'])->name('fund.delete');
Route::get('fundEdit/{id}',[FundController::class,'edit'])->name('fund.edit');
Route::post('fundUpdate/{id}',[FundController::class,'update'])->name('fund.update');

//Route::get('/home', [HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('admin');
Route::get('/dashboard', [AuthController::class, 'someFunction']);

