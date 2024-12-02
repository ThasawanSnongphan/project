<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Users;
use App\Models\UsersMapProject;
use App\Models\Status;
use App\Models\Strategics;
use App\Models\StrategicMap;
use App\Models\StrategicIssues;
use App\Models\Goals;
use App\Models\Tactics;
use App\Models\KPIMains;
use App\Models\KPIProjects;
use App\Models\Projects;
use App\Models\ProjectType;
use App\Models\ProjectCharec;
use App\Models\ProjectIntegrat;
use App\Models\Targets;
use App\Models\BadgetType;
use App\Models\UniPlan;
use App\Models\Funds;
use App\Models\ExpenseBadgets;
use App\Models\CostTypes;
use App\Models\Objectives;
use App\Models\Steps;
use App\Models\CostQuarters;
use App\Models\Benefits;
use App\Models\Files;
use App\Models\CountKPIProjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    function index(){
        $year = Year::all();
        $projectYear = Projects::with('year')->get();
        $project=Projects::all();
        $status=Status::all();
        $users = $users=DB::table('users')->get();
        return view('Project.index',compact('users','project','status','year','projectYear'));
    }
    function create(){
        $user = Users::all();
        $year = Year::all(); // ดึงข้อมูลปี
        $strategic = Strategics::all(); // ดึงข้อมูลแผนทั้งหมด
        $SFA = StrategicIssues::all();
        $goal = Goals::all();
        $tactics = Tactics::all();
        $KPIMain=KPIMains::with('goal.SFA.strategic.year')->get();
        $projectType=ProjectType::all();
        $projectCharec=ProjectCharec::all();
        $projectIntegrat=ProjectIntegrat::all();
        $target=Targets::all();
        $badgetType=BadgetType::all();
        $uniplan=UniPlan::all();
        $fund=Funds::all();
        $expanses = ExpenseBadgets::all();
        $costTypes=CostTypes::all();
        $CountKPIProjects = CountKPIProjects::all();
        return view('Project.create',compact('CountKPIProjects','year','user','strategic','SFA','goal','tactics','KPIMain','projectType','projectCharec','projectIntegrat','target','badgetType','uniplan','fund','expanses','costTypes'));
    }
    function send(Request $request){
        $year = Year::where('yearID',$request->input('yearID'))->first();
        $strategic = Strategics::where('straID',$request->input('straID'))->first();
        $SFA = StrategicIssues::where('SFAID',$request->input('SFAID'))->first();
        $goal = Goals::where('goalID',$request->input('goalID'))->first();
        $tactics = Tactics::where('tacID',$request->input('tacID'))->first();
        $KPIMain = KPIMains::where('KPIMainID',$request->input('KPIMainID'))->first();
        $proType = ProjectType::where('proTypeID',$request->input('proTypeID'))->first();
        $proCha = ProjectCharec::where('proChaID',$request->input('proChaID'))->first();
        $proIn = ProjectIntegrat::where('proInID',$request->input('proInID'))->first();
        $target = Targets::where('tarID',$request->input('tarID'))->first();
        $badget = BadgetType::where('badID',$request->input('badID'))->first();
        $UniPlan = UniPlan::where('planID',$request->input('planID'))->first();
        $expID = ExpenseBadgets::where('expID',$request->input('expID'))->first();
        $costID = CostTypes::where('costID',$request->input('costID'))->first();
        $status = Status::all();
        $request->validate(
            [
                'name'=>'required',
                'principle'=>'required',
                'obj'=>'required',
                'stepName'=>'required',
                'stepStart'=>'required',
                'stepEnd'=>'required',
                // 'costQu1'=>'required',
                // 'costQu2'=>'required',
                // 'costQu3'=>'required',
                // 'costQu4'=>'required',
                'benefit'=>'required',
                'file'=>'required',
            ]
        );
        $project = new Projects();
        $project->yearID = $year->yearID;
        $project->name = $request->input('name');
        $project->format = $request->input('format');
        $project->princiDetail = $request->input('principle');
        $project->proTypeID = $proType->proTypeID;
        $project->proChaID = $proCha->proChaID;
        $project->proInID = $proIn->proInID;
        $project->proInDetail = $request->input('proInDetail');
        $project->tarID = $target->tarID;
        $project->badID = $badget->badID;
        $project->badgetTotal = $request->input('badgetTotal');
        $project->planID = $UniPlan->planID;
        $project->statusID =  1;
        $project->save();

        $project = $project->fresh();

        $users = $request->input('userID');
        if(!empty($users) && is_array($users)){
            foreach($users as $index => $user){
                $userMap = new UsersMapProject();
                $userMap->userID = $user;
                $userMap->proID = $project->proID;
                $userMap->save();
            }
        }

        $objDetail = $request->input('obj');
        if(is_array($objDetail)) {
            foreach($objDetail as $index => $obj){
                $objs = new Objectives();
                $objs->name = $obj;
                $objs->proID = $project->proID;
                $objs->save();
            }
        }

        $KPIName = $request->input('KPIProject') ;
        $KPICount =  $request->input('countKPIProject') ;
        $KPITarget =  $request->input('targetProject') ;
        if(is_array($KPIName) && is_array($KPICount) && is_array($KPITarget)){
            foreach ($KPIName as $index => $KPI){
                $KPIProject = new KPIProjects();
                $KPIProject->name = $KPI;
                $KPIProject->count =  $KPICount[$index] ?? null;
                $KPIProject->target = $KPITarget[$index] ?? null;
                $KPIProject->proID = $project->proID;
                $KPIProject->save();
            }
        }

        $stepName = $request->input('stepName');
        $stepStart = $request->input('stepStart');
        $stepEnd = $request->input('stepEnd');
        if(is_array($stepName) && is_array($stepStart) && is_array($stepEnd)){
            foreach($stepName as $index => $name){
                $step = new Steps();
                $step->name = $name;
                $step->start = $stepStart[$index] ?? null;
                $step->end = $stepEnd[$index] ?? null;
                $step->proID = $project->proID;
                $step->save();
            }
        }

        $costQu1 = $request->input('costQu1');
        $costQu2= $request->input('costQu2');
        $costQu3= $request->input('costQu3');
        $costQu4= $request->input('costQu4');
        if(is_array($costQu1) && is_array($costQu2) && is_array($costQu3) && is_array($costQu4)){
            foreach($costQu1 as $index => $cost1){
                $costQu = new CostQuarters();
                $costQu->costQu1 = $cost1;
                $costQu->costQu2 = $costQu2[$index];
                $costQu->costQu3 = $costQu3[$index];
                $costQu->costQu4 = $costQu4[$index];
                $costQu->proID = $project->proID;
                $costQu->expID = $expID->expID;
                $costQu->costID = $costID->costID;
                $costQu->save();
            }
        }

        $benefits = $request->input('benefit');
        if(is_array($benefits)){
            foreach($benefits as $index => $bnf){
                $benefit = new Benefits();
                $benefit->detail = $bnf;
                $benefit->proID = $project->proID;
                $benefit->save();
            }
        }
        return redirect('/project');
    }

    function save(Request $request){
        $year = Year::where('yearID',$request->input('yearID'))->first();
        $strategic = Strategics::where('straID',$request->input('straID'))->first();
        $SFA = StrategicIssues::where('SFAID',$request->input('SFAID'))->first();
        $goal = Goals::where('goalID',$request->input('goalID'))->first();
        $tactics = Tactics::where('tacID',$request->input('tacID'))->first();
        $KPIMain = KPIMains::where('KPIMainID',$request->input('KPIMainID'))->first();
        $proType = ProjectType::where('proTypeID',$request->input('proTypeID'))->first();
        $proCha = ProjectCharec::where('proChaID',$request->input('proChaID'))->first();
        $proIn = ProjectIntegrat::where('proInID',$request->input('proInID'))->first();
        $target = Targets::where('tarID',$request->input('tarID'))->first();
        $badget = BadgetType::where('badID',$request->input('badID'))->first();
        $UniPlan = UniPlan::where('planID',$request->input('planID'))->first();
        $expID = ExpenseBadgets::where('expID',$request->input('expID'))->first();
        $costID = CostTypes::where('costID',$request->input('costID'))->first();
        $status = Status::all();
        $request->validate(
            [
                'name'=>'required',
            ]
        );
        $project = new Projects();
        $project->yearID = $year->yearID;
        $project->name = $request->input('name');
        $project->format = $request->input('format');
        $project->princiDetail = $request->input('principle');
        $project->proTypeID = $proType->proTypeID;
        $project->proChaID = $proCha->proChaID;
        $project->proInID = $proIn->proInID;
        $project->proInDetail = $request->input('proInDetail');
        $project->tarID = $target->tarID;
        $project->badID = $badget->badID;
        $project->planID = $UniPlan->planID;
        $project->statusID =  16;
        $project->save();

        $project = $project->fresh();

        $users = $request->input('userID');
        if(!empty($users) && is_array($users)){
            foreach($users as $index => $user){
                $userMap = new UsersMapProject();
                $userMap->userID = $user;
                $userMap->proID = $project->proID;
                $userMap->save();
            }
        }

        $objDetail = $request->input('obj');
        if(!empty($objDetail) && is_array($objDetail)) {
            foreach($objDetail as $index => $obj){
                $objs = new Objectives();
                $objs->name = $obj;
                $objs->proID = $project->proID;
                $objs->save();
            }
        }

        $straMap = new StrategicMap();
        $straMap->proID = $project->proID;
        $straMap->straID = $strategic->straID;
        $straMap->SFAID = $SFA->SFAID;
        $straMap->goalID = $goal->goalID;
        $straMap->tacID = $tactics->tacID;
        if ($request->has('KPIMainID') && !empty($request->input('KPIMainID'))) {
        $straMap->KPIMainID = $KPIMain->KPIMainID;
        }
        $straMap->save();

        $KPIName = $request->input('KPIProject') ;
        $KPICount =  $request->input('countKPIProject') ;
        $KPITarget =  $request->input('targetProject') ;
        if(!empty($KPIMain) && is_array($KPIName) && is_array($KPICount) && is_array($KPITarget)){
            foreach ($KPIName as $index => $KPI){
                $KPIProject = new KPIProjects();
                $KPIProject->name = $KPI;
                $KPIProject->countKPIProID =  $KPICount[$index] ?? null;
                $KPIProject->target = $KPITarget[$index] ?? null;
                $KPIProject->proID = $project->proID;
                $KPIProject->save();
            }
        }

        $stepName = $request->input('stepName');
        $stepStart = $request->input('stepStart');
        $stepEnd = $request->input('stepEnd');
        if( is_array($stepName) && is_array($stepStart) && is_array($stepEnd)){
            foreach($stepName as $index => $name){
                $step = new Steps();
                $step->name = $name;
                $step->start = $stepStart[$index] ?? null;
                $step->end = $stepEnd[$index] ?? null;
                $step->proID = $project->proID;
                $step->save();
            }
        }

       
        $costQu1 = $request->input('costQu1');
        $costQu2= $request->input('costQu2');
        $costQu3= $request->input('costQu3');
        $costQu4= $request->input('costQu4');
        if(!empty($costQu1) && is_array($costQu1) && is_array($costQu2) && is_array($costQu3) && is_array($costQu4)){
            foreach($costQu1 as $index => $cost1){
                $costQu = new CostQuarters();
                $costQu->costQu1 = $cost1;
                $costQu->costQu2 = $costQu2[$index];
                $costQu->costQu3 = $costQu3[$index];
                $costQu->costQu4 = $costQu4[$index];
                $costQu->proID = $project->proID;
                $costQu->expID = $expID->expID;
                $costQu->costID = $costID->costID;
                $costQu->save();
            }
        }
       

        $benefits = $request->input('benefit');
        if(!empty($benefit) && is_array($benefits)){
            foreach($benefits as $index => $bnf){
                $benefit = new Benefits();
                $benefit->detail = $bnf;
                $benefit->proID = $project->proID;
                $benefit->save();
            }
        }
        

        $files = $request->file('file');
        $torSelections = $request->input('TOR') ;
        // dd($torSelections);
        if ($files && is_array($files) && is_array($torSelections)) {
            foreach ($files as $index => $file) {
                    $fileName = $file->getClientOriginalName(); // รับชื่อไฟล์
                    // $filePath = $file->store('fileProject', 'public'); // บันทึกไฟล์ในที่เก็บ 'files'
                    
                    if (isset($files) && !isset($torSelections[$index])) {
                        $fileType = 'อื่นๆ';
                    }
                    else{
                        $fileType = 'TOR';
                         
                    }
                    // สร้างข้อมูลไฟล์ใหม่ในฐานข้อมูล
                    $newFile = new Files();
                    $newFile->name = $fileName;
                    $newFile->type =  $fileType;
                    $newFile->proID = $project->proID; // หรือกำหนดค่าอื่นๆ ตามที่ต้องการ
                    $newFile->save(); // บันทึกข้อมูลลงฐานข้อมูล
                
            }
        }
        
        return redirect('/project');
    }

    function delete($id){
        DB::table('projects')->where('proID',$id)->delete();
        return redirect('/project');
    }

    function edit($id){
        // $project = Projects::with('strategicMap')->find($proID);
        // $project=DB::table('projects')->where('proID',$id)->first();
        $user = Users::all();
        $userMap = UsersMapProject::with('users')->get();
        $project=Projects::with('strategicMap')->where('proID',$id)->first();
        $year = Year::all(); // ดึงข้อมูลปี
        $strategic = Strategics::all(); // ดึงข้อมูลแผนทั้งหมด
        $SFA = StrategicIssues::all();
        $goal = Goals::all();
        $tactics = Tactics::all();
        $KPIMain=KPIMains::with('goal.SFA.strategic.year')->get();
        $projectType=ProjectType::all();
        $projectCharec=ProjectCharec::all();
        $projectIntegrat=ProjectIntegrat::all();
        $target=Targets::all();
        $badgetType=BadgetType::all();
        $uniplan=UniPlan::all();
        $fund=Funds::all();
        $expanses = ExpenseBadgets::all();
        $costTypes=CostTypes::all();
        $obj = Objectives::all();
        $objProject = $obj->where('proID',$project->proID)->first();
        $KPIProjects = KPIProjects::all();
        $KPIProject = $KPIProjects->where('proID',$project->proID)->first();
        $CountKPIProjects = CountKPIProjects::all();
        $steps = Steps::all();
        $step = $steps->where('proID',$project->proID)->first();
        $costQuarters = CostQuarters::all();
        $costQuarter = $costQuarters->where('proID',$project->proID)->first();
        $benefits = Benefits::all();
        $benefit = $benefits->where('proID',$project->proID)->first();
        return view('Project.update',compact('userMap','user','project','year','strategic','SFA','goal','tactics','obj','objProject','KPIMain','KPIProjects','KPIProject','CountKPIProjects','steps','step','costQuarters','costQuarter','projectType','projectCharec','projectIntegrat','target','badgetType','uniplan','fund','expanses','costTypes','benefits','benefit'));
    }

    function update(Request $request,$id){
        $project=[
            'yearID'=>$request->yearID,
            'name'=>$request->name,
            'format'=>$request->format,
            'princiDetail'=>$request->principle,
            'proTypeID'=>$request->proTypeID,
            'proChaID'=>$request->proChaID,
            'proInID'=>$request->proInID,
            'proInDetail'=>$request->proInDetail,
            'tarID'=>$request->tarID,
            'badID'=>$request->badID,
            'planID'=>$request->planID,
            'updated_at' => now()
        ];
        
        
        $straMap=[
            // 'straID'=>$request->StraID[0],
            // 'SFAID'=>$request->SFAID[0],
            // 'goalID'=>$request->goalID[0],
            // 'tacID'=>$request->tacID[0],
            'KPIMainID'=>$request->KPIMainID[0],
            'updated_at' => now()
        ];

        $userMaps = DB::table('users_map_projects')->where('proID',$id)->get();
        $userMapIDs = $userMaps->pluck('userMapID')->toArray();
        // dd($userMapIDs);
        $userMap = $request->userID;
        dd($userMap);


        $objs = DB::table('objectives')->where('proID',$id)->get();
        $objIDs = $objs->pluck('objID')->toArray();
        $obj = $request->obj;
        $objID = $request->objID;
        
        $KPIProjects =DB::table('k_p_i_projects')->where('proID',$id)->get(); 
        $KPIProIDs = $KPIProjects->pluck('KPIProID')->toArray();
        $KPIProject = $request->KPIProject;
        $countProject = $request->countKPIProject;
        $targetProject = $request->targetProject;
        $KPIProID = $request->KPIProID;
        // dd($KPIProID);

        $steps =DB::table('steps')->where('proID',$id)->get(); 
        $stepIDs = $steps->pluck('stepID')->toArray();
        $stepName = $request->stepName;
        $stepStart = $request->stepStart;
        $stepEnd = $request->stepEnd;
        $stepID = $request->stepID;

        $benefits = DB::table('benefits')->where('proID',$id)->get();
        $bnfIDs = $benefits->pluck('bnfID')->toArray();
        $bnf = $request->benefit;
        $bnfID = $request->bnfID;

        DB::table('projects')->where('proID',$id)->update($project);
        
        DB::table('strategic_maps')->where('proID',$id)->update($straMap);
        foreach ($obj as $index => $obj) {
            
            // ตรวจสอบว่า $objID[$index] มีค่าอยู่หรือไม่
            if (isset($objID[$index])) {
                $currentObjID = $objID[$index];  // ดึง objID จาก array objID[]
                
                // ตรวจสอบว่า objID นี้มีอยู่ในฐานข้อมูลหรือไม่
                if (in_array($currentObjID, $objIDs)) {
                    // หาก objID นี้มีอยู่ในฐานข้อมูลแล้ว, ให้ทำการ update
                    DB::table('objectives')->updateOrInsert(
                        [   
                            'objID' => $currentObjID
                        ],  // เช็คด้วย objID
                        [
                            'proID' => $id,
                            'name' => $obj,  // อัปเดตชื่อ
                            'updated_at'=>now()
                        ]
                    );
                } else {
                    // หากไม่มี objID หรือ objID ไม่ตรง ให้ทำการ insert ใหม่
                    DB::table('objectives')->insert([
                        'proID' => $id,
                        'name' => $obj,  // เพิ่มชื่อใหม่
                        'updated_at' => now(), // ใช้เวลาปัจจุบันที่ Laravel รองรับ
                        'created_at' => now() // หรือสร้างพร้อมกัน
                    ]);
                }
            } else {
                // หากไม่มี objID ที่ตรงกับ index นี้ ให้ทำการ insert ใหม่
                DB::table('objectives')->insert([
                    'proID' => $id,
                    'name' => $obj,  // เพิ่มชื่อใหม่
                    'updated_at' => now(), // ใช้เวลาปัจจุบันที่ Laravel รองรับ
                    'created_at' => now() // หรือสร้างพร้อมกัน
                ]);
            }
        }
        // หาค่า objIDs ที่อยู่ในฐานข้อมูล แต่ไม่มีอยู่ใน $objID
        $objIDsToDelete = array_diff($objIDs, $objID);
        // dd($objIDsToDelete);
        if (!empty($objIDsToDelete)) {
        // ลบข้อมูลที่ไม่มีในคำขอ
            DB::table('objectives')
            ->where('proID', $id)
            ->whereIn('objID', $objIDsToDelete)
            ->delete();
        }
        // dd($countProject,$targetProject);
        foreach($KPIProject as $index => $KPI){
            // dd($KPI);
            if(isset($KPIProID[$index])){
                $currentKPIProID = $KPIProID[$index];
                if(in_array($currentKPIProID,$KPIProIDs)){
                    DB::table('k_p_i_projects')->updateOrInsert(
                        [
                            'KPIProID' => $currentKPIProID
                        ],
                        [
                            'proID' => $id,
                            'name' => $KPI,
                            'countKPIProID' => $countProject[$index],
                            'target' => $targetProject[$index],
                            'updated_at'=>now()
                        ]
                    );
                } else {
                    DB::table('k_p_i_projects')->Insert(
                        [
                            'proID' => $id,
                            'name' => $KPI,
                            'countKPIProID' => $countProject[$index],
                            'target' => $targetProject[$index],
                            'updated_at'=>now(),
                            'created_at' => now()
                        ]
                    );
                }
            } else {
                DB::table('k_p_i_projects')->Insert(
                    [
                        'proID' => $id,
                        'name' => $KPI,
                        'countKPIProID' => $countProject[$index],
                        'target' => $targetProject[$index],
                        'updated_at'=>now(),
                        'created_at' => now()
                    ]
                );
            }
        }
        $KPIProjectDelect = array_diff($KPIProIDs,$KPIProID);
        if(!empty($KPIProjectDelect)){
            DB::table('k_p_i_projects')
            ->where('proID',$id)
            ->whereIn('KPIProID',$KPIProjectDelect)
            ->delete();
        }

        foreach($stepName as $index => $step){
            // dd($KPI);
            if(isset($stepID[$index])){
                $currentstepID = $stepID[$index];
                if(in_array($currentstepID,$stepIDs)){
                    DB::table('steps')->updateOrInsert(
                        [
                            'stepID' => $currentstepID
                        ],
                        [
                            'proID' => $id,
                            'name' => $step,
                            'start' => $stepStart[$index],
                            'end' => $stepEnd[$index],
                            'updated_at'=>now()
                        ]
                    );
                } else {
                    DB::table('steps')->Insert(
                        [
                            'proID' => $id,
                            'name' => $step,
                            'start' => $stepStart[$index],
                            'end' => $stepEnd[$index],
                            'updated_at'=>now(),
                            'created_at' => now()
                        ]
                    );
                }
            } else {
                DB::table('steps')->Insert(
                    [
                        'proID' => $id,
                        'name' => $step,
                        'start' => $stepStart[$index],
                        'end' => $stepEnd[$index],
                        'updated_at'=>now(),
                        'created_at' => now()
                    ]
                );
            }
        }
        $stepDelect = array_diff($stepIDs,$stepID);
        if(!empty($stepDelect)){
            DB::table('steps')
            ->where('proID',$id)
            ->whereIn('stepID',$stepDelect)
            ->delete();
        }

        foreach ($bnf as $index => $bnf) {
            
            // ตรวจสอบว่า $objID[$index] มีค่าอยู่หรือไม่
            if (isset($bnfID[$index])) {
                $currentbnfID = $bnfID[$index];  // ดึง objID จาก array objID[]
                
                // ตรวจสอบว่า objID นี้มีอยู่ในฐานข้อมูลหรือไม่
                if (in_array($currentbnfID, $bnfIDs)) {
                    // หาก objID นี้มีอยู่ในฐานข้อมูลแล้ว, ให้ทำการ update
                    DB::table('benefits')->updateOrInsert(
                        [   
                            'bnfID' => $currentbnfID
                        ],  // เช็คด้วย objID
                        [
                            'proID' => $id,
                            'detail' => $bnf,  // อัปเดตชื่อ
                            'updated_at'=>now()
                        ]
                    );
                } else {
                    // หากไม่มี objID หรือ objID ไม่ตรง ให้ทำการ insert ใหม่
                    DB::table('benefits')->insert([
                        'proID' => $id,
                        'detail' => $bnf,  // เพิ่มชื่อใหม่
                        'updated_at' => now(), // ใช้เวลาปัจจุบันที่ Laravel รองรับ
                        'created_at' => now() // หรือสร้างพร้อมกัน
                    ]);
                }
            } else {
                // หากไม่มี objID ที่ตรงกับ index นี้ ให้ทำการ insert ใหม่
                DB::table('benefits')->insert([
                    'proID' => $id,
                    'detail' => $bnf,  // เพิ่มชื่อใหม่
                    'updated_at' => now(), // ใช้เวลาปัจจุบันที่ Laravel รองรับ
                    'created_at' => now() // หรือสร้างพร้อมกัน
                ]);
            }
        }
        // หาค่า objIDs ที่อยู่ในฐานข้อมูล แต่ไม่มีอยู่ใน $objID
        $bnfIDsToDelete = array_diff($bnfIDs, $bnfID);
        // dd($objIDsToDelete);
        if (!empty($bnfIDsToDelete)) {
        // ลบข้อมูลที่ไม่มีในคำขอ
            DB::table('benefits')
            ->where('proID', $id)
            ->whereIn('bnfID', $bnfIDsToDelete)
            ->delete();
        }


        return redirect('/project');
    }

    function report($id){
        $project=DB::table('projects')->where('proID',$id)->first();
        return view('Project.report',compact('project'));
    }


   
}