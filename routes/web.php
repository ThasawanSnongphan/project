<?php

use App\Http\Controllers\PDFAllResultsController;
use App\Http\Controllers\PDFClosedController;
use App\Http\Controllers\PDFPlanController;
use App\Http\Controllers\PDFProjectController;
use App\Http\Controllers\WordProjectController;
use App\Http\Controllers\WordQ4Controller;
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
use App\Http\Controllers\ProjectEvalutionController;

use App\Http\Controllers\QuarterReportController;

use App\Http\Controllers\Strategic2LevelController;
use App\Http\Controllers\SFA2LevelController;
use App\Http\Controllers\KPIMain2LevelController;
use App\Http\Controllers\Tactics2LevelController;

use App\Http\Controllers\Strategic1LevelController;
use App\Http\Controllers\Target1LevelController;

use App\Http\Controllers\StrategicController;
use App\Http\Controllers\SFAController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\TacticsController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\KPIMainController;
use App\Http\Controllers\CountKPIProject;
use App\Http\Controllers\PlanningAnalyst;
use App\Http\Controllers\Department_Head;
use App\Http\Controllers\SupplyAnalystController;
use App\Http\Controllers\Executive;
use App\Http\Controllers\ExcelAllResultsController;
use App\Http\Controllers\WordClosedController;

//PDF
Route::get('/pdfClosed/{id}', [PDFClosedController::class, 'pdf_gen']);
Route::get('/pdfPlan', [PDFPlanController::class, 'pdf_gen']);
// Route::get('/pdfQ4', [PDFQ4Controller::class, 'pdf_gen']);
Route::get('/pdfAllResults', [PDFAllResultsController::class, 'pdf_gen']);

//Word
// Route::get('/gen-word-db/{id}', [WordController::class, 'word_gen']);
// Route::get('/gen-word-Q4', [WordQ4Controller::class, 'word_gen']);
Route::get('/wordClosed/{id}', [WordClosedController::class, 'word_gen']);

//Excel
Route::get('/excelAllResults', [ExcelAllResultsController::class, 'exportExcel']);



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

Route::get('/SupplyAnalystProject', [SupplyAnalystController::class,'index']);

Route::get('/ExecutiveProjectlist', [Executive::class,'index']);
Route::get('/ExecutiveProjectDenied', [Executive::class,'projectDenied']);
Route::get('ExecutiveProjectDetail/{id}',[Executive::class,'report'])->name('Executive.detail');
Route::post('ExecutivePass/{id}', [Executive::class,'ExecutivePass'])->name('ExecutivePass');
Route::post('/ExecutiveEdit/{id}', [Executive::class,'ExecutiveEdit'])->name('ExecutiveEdit');
Route::post('/ExecutiveDenied/{id}', [Executive::class,'ExecutiveDenied'])->name('ExecutiveDenied');

Route::get('/PlanningAnalystProject', [PlanningAnalyst::class,'index']);
Route::get('/PlanningAnalystProjectOutPlan', [PlanningAnalyst::class,'projectOutPlan']);
Route::get('/PlanningAnalystProjectCancel', [PlanningAnalyst::class,'projectCancel']);
Route::get('PlanningAnalystProjectDetail/{id}',[PlanningAnalyst::class,'report'])->name('PlanningAnalyst.detail');
Route::post('planningPass/{id}', [PlanningAnalyst::class,'planningPass'])->name('planningPass');
Route::post('/planningEdit/{id}', [PlanningAnalyst::class,'planningEdit'])->name('planningEdit');

Route::get('/DepartmentHeadProject', [Department_Head::class,'index']);
Route::get('DepartmentHeadProjectDetail/{id}',[Department_Head::class,'report'])->name('Department.detail');
Route::post('departmentPass/{id}', [Department_Head::class,'departmentPass'])->name('departmentPass');
Route::post('/departmentEdit/{id}', [Department_Head::class,'departmentEdit'])->name('departmentEdit');

Route::get('/project', [ProjectController::class,'index']);
Route::any('/projectcreate1', [ProjectController::class,'create1']);

Route::post('/projectgoal3LV', [ProjectController::class,'goal3LV']);
Route::post('/projecttactics3LV', [ProjectController::class,'tactics3LV']);
Route::post('/projectKPIMain3LV', [ProjectController::class,'KPIMain3LV']);
Route::post('/projectcount_target3LV', [ProjectController::class,'count_target_KPIMain3LV']);

Route::post('/projecttactics2LV', [ProjectController::class,'tactics2LV']);
Route::post('/projectKPIMain2LV', [ProjectController::class,'KPIMain2LV']);
Route::post('/projectcount_target2LV', [ProjectController::class,'count_target_KPIMain2LV']);

Route::post('/projectcostType', [ProjectController::class,'costType']);

Route::any('/projectcreate2', [ProjectController::class,'create2']);
// Route::any('/projectcreate2/{id}', [ProjectController::class,'create2']);
Route::post('/projectSave1', [ProjectController::class,'save1']);
Route::post('/projectSave2', [ProjectController::class,'save2']);
Route::post('/projectSend1', [ProjectController::class,'send1']);
Route::post('/projectSend2', [ProjectController::class,'send2']);
Route::get('projectdelete/{id}',[ProjectController::class,'delete'])->name('project.delete');
// Route::get('projectedit1/{id}',[ProjectController::class,'edit1'])->name('project.edit1');
Route::any('projectedit/{id}',[ProjectController::class,'edit1'])->name('project.edit1');
Route::post('projectsaveUpdate1/{id}',[ProjectController::class,'saveUpdate1']);
Route::post('projectsendUpdate1/{id}',[ProjectController::class,'sendUpdate1']);
Route::post('projectSaveUpdate2/{id}',[ProjectController::class,'saveUpdate2']);
Route::post('projectSendUpdate2/{id}',[ProjectController::class,'sendUpdate2']);
Route::any('projectedit2/{id}',[ProjectController::class,'edit2']);

Route::post('projectupdate2/{id}',[ProjectController::class,'update'])->name('project.update');
Route::get('projectreport/{id}',[ProjectController::class,'report'])->name('project.report');

Route::any('projectEvaluation/{id}',[ProjectEvalutionController::class,'evaluation'])->name('project.evaluation');
Route::post('projectSaveEvaluation/{id}',[ProjectEvalutionController::class,'save']);
Route::post('fileEvaluation/{id}',[ProjectEvalutionController::class,'savefile']);
Route::any('EditEvaluation/{id}',[ProjectEvalutionController::class,'edit'])->name('edit.evaluation');
Route::any('UpdateEvaluation/{id}',[ProjectEvalutionController::class,'update']);
Route::any('SendEvaluation/{id}',[ProjectEvalutionController::class,'send']);


Route::get('reportQuarter/{id}{quarter}', [QuarterReportController::class, 'reportQuarter'])->name('report.quarter');
// Route::get('quarter2/{id}', [QuarterReportController::class,'quarter2'])->name('quarter2.report');
Route::post('saveReportQuarter/{id}{quarter}', [QuarterReportController::class,'saveReportQuarter'])->name('reportQuarter.save');

//Report
Route::get('projectPDF/{id}',[PDFProjectController::class,'db_gen'])->name('project.PDF');
Route::get('projectWord/{id}',[WordProjectController::class,'word_gen'])->name('project.Word');


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

//Strategic2Level
Route::get('strategic2LV',[Strategic2LevelController::class,'index']);
Route::post('strategic2LVInsert',[Strategic2LevelController::class,'insert']);
Route::get('strategic2LVEdit/{id}',[Strategic2LevelController::class,'edit'])->name('strategic2LV.edit');
Route::post('strategic2LVUpdate/{id}',[Strategic2LevelController::class,'update'])->name('strategic2LV.update');
Route::get('strategic2LVDelete/{id}',[Strategic2LevelController::class,'delete'])->name('strategic2LV.delete');
//SFA2Level
Route::get('SFA2LV',[SFA2LevelController::class,'index']);
Route::post('SFA2LVInsert',[SFA2LevelController::class,'insert']);
Route::get('SFA2LVEdit/{id}',[SFA2LevelController::class,'edit'])->name('SFA2LV.edit');
Route::post('SFA2LVUpdate/{id}',[SFA2LevelController::class,'update'])->name('SFA2LV.update');
Route::get('SFA2LVDelete/{id}',[SFA2LevelController::class,'delete'])->name('SFA2LV.delete');
//KPIMain2Level
Route::get('KPIMain2LV',[KPIMain2LevelController::class,'index']);
Route::post('KPIMain2LVInsert',[KPIMain2LevelController::class,'insert']);
Route::get('KPIMain2LVEdit/{id}',[KPIMain2LevelController::class,'edit'])->name('KPIMain2LV.edit');
Route::post('KPIMain2LVUpdate/{id}',[KPIMain2LevelController::class,'update'])->name('KPIMain2LV.update');
Route::get('KPIMain2LVDelete/{id}',[KPIMain2LevelController::class,'delete'])->name('KPIMain2LV.delete');
//KPIMain2Level
Route::get('tactic2LV',[Tactics2LevelController::class,'index']);
Route::post('tactic2LVInsert',[Tactics2LevelController::class,'insert']);
Route::get('tactic2LVEdit/{id}',[Tactics2LevelController::class,'edit'])->name('tactic2LV.edit');
Route::post('tactic2LVUpdate/{id}',[Tactics2LevelController::class,'update'])->name('tactic2LV.update');
Route::get('tactic2LVDelete/{id}',[Tactics2LevelController::class,'delete'])->name('tactic2LV.delete');

Route::get('strategic1LV',[Strategic1LevelController::class,'index']);
Route::post('strategic1LVInsert',[Strategic1LevelController::class,'insert']);
Route::get('strategic1LVEdit/{id}',[Strategic1LevelController::class,'edit'])->name('strategic1LV.edit');
Route::post('strategic1LVUpdate/{id}',[Strategic1LevelController::class,'update'])->name('strategic1LV.update');
Route::get('strategic1LVDelete/{id}',[Strategic1LevelController::class,'delete'])->name('strategic1LV.delete');

Route::get('target1LV',[Target1LevelController::class,'index']);
Route::post('target1LVInsert',[Target1LevelController::class,'insert']);
Route::get('target1LVEdit/{id}',[Target1LevelController::class,'edit'])->name('target1LV.edit');
Route::post('target1LVUpdate/{id}',[Target1LevelController::class,'update'])->name('target1LV.update');
Route::get('target1LVDelete/{id}',[Target1LevelController::class,'delete'])->name('target1LV.delete');


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
Route::get('/projectAll', [HomeController::class, 'projectAll']);

