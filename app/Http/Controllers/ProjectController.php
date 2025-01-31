<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Users;
use App\Models\UsersMapProject;
use App\Models\Status;
use App\Models\Strategic3Level;
use App\Models\StrategicMap;
use App\Models\StrategicIssues;
use App\Models\StrategicIssues2Level;
use App\Models\Goals;
use App\Models\Tactics;
use App\Models\Tactic2Level;
use App\Models\KPIMains;
use App\Models\KPIMainMapProjects;
use App\Models\KPIMain2Level;
use App\Models\Strategic2Level;
use App\Models\Strategic1Level;
use App\Models\KPIProjects;
use App\Models\Projects;
use App\Models\ProjectType;
use App\Models\ProjectCharec;
use App\Models\ProjectIntegrat;
use App\Models\Targets;
use App\Models\Target1Level;
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
    
    function create1(Request $request){
        $year = Year::all();
        $selectYear = $request->input('yearID');
       
        $strategic3Level = $selectYear ? Strategic3Level::where('yearID',$selectYear)->get() : Strategic3Level::all();
        // dd($strategic3Level);
        $strategic2Level = $selectYear ? Strategic2Level::where('yearID',$selectYear)->get() : Strategic2Level::all();
        $strategic1Level = $selectYear ? Strategic1Level::where('yearID',$selectYear)->get() : Strategic1Level::all();
       
        $name = $request->input('name');
        // dd($name);
        $selectStra3LV = $request->input('stra3LVID', []);
        $selectSFA3Level = $request->input('SFA3LVID');
        $selectGoal3Level = $request->input('goal3LVID');
        $selectTactics3LV = $request->input('tac3LVID');
        $selectKPIMain = $request->input('KPIMain3LVID');
        // dd($request->all());
        // dd($selectStra3LV,$selectSFA3Level,$selectGoal3Level,$selectTactics3LV,$selectKPIMain);
        // dd($selectStra3LV);
        $SFA3LVs = StrategicIssues::all();
        $goal3Level = Goals::all();
        $tactics3LV = Tactics::all(); 
        $KPIMain3LV = KPIMains::all();

        $SFA2LV = StrategicIssues2Level::all(); 
        $tactics2LV = Tactic2Level::all();
        $KPIMain2LV = KPIMain2Level::all();

        $target1LV = Target1Level::all();

        return view('Project.create1',compact('name','year','selectYear','strategic3Level','selectStra3LV','strategic2Level','strategic1Level','selectSFA3Level','SFA3LVs','selectGoal3Level','goal3Level','tactics3LV','selectTactics3LV','KPIMain3LV','SFA2LV','tactics2LV','KPIMain2LV','target1LV','selectKPIMain'));
    }

    function create2(Request $request){
        $year = Year::where('yearID',$request->input('yearID'))->first();
        $project = new Projects();
        $project->yearID = $year->yearID;
        $project->name = $request->input('name');
        $project->statusID =  16;
        $project->save(); 

        $project = $project->fresh();

        $stra3LV = $request->input('stra3LVID');
        $SFA3LV = $request->input('SFA3LVID');
        $goal3LV = $request->input('goal3LVID');
        $tac3LV = $request->input('tac3LVID');
        // dd();
        if(is_array($stra3LV) && is_array($SFA3LV) && is_array($goal3LV) && is_array($tac3LV) ){
            foreach($stra3LV as $index => $stra){
                $straMap = new StrategicMap();
                $straMap->proID = $project->proID;
                $straMap->stra3LVID = $stra;
                $straMap->SFA3LVID = $SFA3LV[$index] ?? null;
                $straMap->goal3LVID = $goal3LV[$index] ?? null;
                $straMap->tac3LVID = $tac3LV[$index] ?? null;
                $straMap->save();
            }
        }

        $KPIMain3LV = $request->input('KPIMain3LVID');
        // dd($KPIMain3LV);
        if(is_array($KPIMain3LV)){
            foreach ($KPIMain3LV as $index => $KPIMain) {
                if(!empty($KPIMain)){
                $map = new KPIMainMapProjects();
                $map->KPIMain3LVID = $KPIMain ?? null;
                $map->proID = $project->proID;
                $map->save(); 
                }
            }
        }

        $user = Users::all();
        $years = Year::all(); // ดึงข้อมูลปี
        $strateegicMap = StrategicMap::all();
        $strategic = Strategic3Level::all(); // ดึงข้อมูลแผนทั้งหมด
        $SFAs = StrategicIssues::all();
        $goals = Goals::all();
        $tactics = Tactics::all();
        $KPIMains=KPIMains::all();
        $KPIMainMapProject = KPIMainMapProjects::all();
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
        return view('Project.create2',compact('project','CountKPIProjects','year','years','user','strateegicMap','strategic','SFAs','goals','tactics','KPIMainMapProject','KPIMains','projectType','projectCharec','projectIntegrat','target','badgetType','uniplan','fund','expanses','costTypes'));
    }

    
    function send(Request $request){
        $year = Year::where('yearID',$request->input('yearID'))->first();
        $strategic = Strategic3Level::where('stra3LVID',$request->input('straID'))->first();
        $SFA = StrategicIssues::where('SFA3LVID',$request->input('SFAID'))->first();
        $goal = Goals::where('goal3LVID',$request->input('goalID'))->first();
        $tactics = Tactics::where('tac3LVID',$request->input('tacID'))->first();
        $KPIMain = KPIMains::where('KPIMain3LVID',$request->input('KPIMainID'))->first();
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
                $objs->detail = $obj;
                $objs->proID = $project->proID;
                $objs->save();
            }
        }

        $straID = $request->input('straID');
        $SFAID = $request->input('SFAID');
        $goalID = $request->input('goalID');
        $tacID = $request->input('tacID');
        $KPIMainID = $request->input('KPIMainID');
        if(is_array($straID) && is_array($SFAID) && is_array($goalID) && is_array($tacID) && is_array($KPIMainID)){
            foreach($straID as $index => $stra){
                $straMap = new StrategicMap();
                $straMap->proID = $project->proID;
                $straMap->straID = $stra;
                $straMap->SFAID = $SFAID[$index] ?? null;
                $straMap->goalID = $goalID[$index] ?? null;
                $straMap->tacID = $tacID[$index] ?? null;
                // if ($request->has('KPIMainID') && !empty($request->input('KPIMainID'))) {
                    $straMap->KPIMainID = $KPIMainID[$index] ?? null;
                // }
                $straMap->save();
            }
        }

        $KPIName = $request->input('KPIProject') ;
        $KPICount =  $request->input('countKPIProject') ;
        $KPITarget =  $request->input('targetProject') ;
        if(is_array($KPIName) && is_array($KPICount) && is_array($KPITarget)){
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
        $expID = $request->input('expID');
        $costID = $request->input('costID');
        if(is_array($costQu1) && is_array($costQu2) && is_array($costQu3) && is_array($costQu4)){
            foreach($costQu1 as $index => $cost1){
                $costQu = new CostQuarters();
                $costQu->costQu1 = $cost1;
                $costQu->costQu2 = $costQu2[$index];
                $costQu->costQu3 = $costQu3[$index];
                $costQu->costQu4 = $costQu4[$index];
                $costQu->proID = $project->proID;
                $costQu->expID = $expID[$index];
                $costQu->costID = $costID[$index];
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

    

    function save1(Request $request){
        $year = Year::where('yearID',$request->input('yearID'))->first();
        $project = new Projects();
        $project->yearID = $year->yearID;
        $project->name = $request->input('name');
        $project->statusID =  16;
        $project->save();   
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
        $project->badgetTotal = $request->input('badgetTotal');
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
                $objs->detail = $obj;
                $objs->proID = $project->proID;
                $objs->save();
            }
        }

        $straID = $request->input('straID');
        $SFAID = $request->input('SFAID');
        $goalID = $request->input('goalID');
        $tacID = $request->input('tacID');
        $KPIMainID = $request->input('KPIMainID');
        if(is_array($straID) && is_array($SFAID) && is_array($goalID) && is_array($tacID) && is_array($KPIMainID)){
            foreach($straID as $index => $stra){
                $straMap = new StrategicMap();
                $straMap->proID = $project->proID;
                $straMap->straID = $stra;
                $straMap->SFAID = $SFAID[$index] ?? null;
                $straMap->goalID = $goalID[$index] ?? null;
                $straMap->tacID = $tacID[$index] ?? null;
                // if ($request->has('KPIMainID') && !empty($request->input('KPIMainID'))) {
                    $straMap->KPIMainID = $KPIMainID[$index] ?? null;
                // }
                $straMap->save();
            }
        }

        

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
        $expID = $request->input('expID');
        $costID = $request->input('costID');
        // dd($expID);
        // dd($costQu1,$costQu2,$costQu3,$costQu4);
        if(is_array($costQu1) && is_array($costQu2) && is_array($costQu3) && is_array($costQu4)){
            foreach($costQu1 as $index => $cost1){
                $costQu = new CostQuarters();
                $costQu->costQu1 = $cost1;
                $costQu->costQu2 = $costQu2[$index] ?? null;
                $costQu->costQu3 = $costQu3[$index] ?? null;
                $costQu->costQu4 = $costQu4[$index] ?? null;
                $costQu->proID = $project->proID;
                $costQu->expID = $expID[$index];
                $costQu->costID = $costID[$index];
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
        $strategic = Strategic3Level::all(); // ดึงข้อมูลแผนทั้งหมด
        $strategicMap = StrategicMap::all();
        $straMap = $strategicMap->where('proID',$project->proID)->first();
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
        return view('Project.update',compact('userMap','user','project','year','strategic','strategicMap','straMap','SFA','goal','tactics','obj','objProject','KPIMain','KPIProjects','KPIProject','CountKPIProjects','steps','step','costQuarters','costQuarter','projectType','projectCharec','projectIntegrat','target','badgetType','uniplan','fund','expanses','costTypes','benefits','benefit'));
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
        DB::table('projects')->where('proID',$id)->update($project);
        
        
        $strategicMap = DB::table('strategic_maps')->where('proID',$id)->get();
        $straMapIDs = $strategicMap->pluck('straMapID')->toArray();
        $straIDs = $strategicMap->pluck('straID')->toArray();
        $SFAIDs = $strategicMap->pluck('SFAID')->toArray();
        $goalIDs = $strategicMap->pluck('goalID')->toArray();
        $tacIDs = $strategicMap->pluck('tacID')->toArray();
        // dd($straMapIDs,$straIDs);
        $straMapID = $request->straMapID;
        $straID = $request->straID;
        $SFAID = $request->SFAID;
        $goalID = $request->goalID;
        $tacID = $request->tacID;
        // dd($straMapIDs,$straMapID,$straIDs,$straID,$SFAIDs,$SFAID,$goalIDs,$goalID,$tacIDs,$tacID);

        foreach($straMapID as $index => $straMap){
            if(isset($straMap)){
                $currentstraMapID = $straMap;
                if(in_array($currentstraMapID,$straMapIDs)){
                    DB::table('strategic_maps')->updateOrInsert(
                        [
                            'straMapID' => $currentstraMapID
                        ],
                        [
                            'proID' => $id,
                            'updated_at' => now()
                        ]
                    );
                }else{
                    DB::table('strategic_maps')->insert(
                        [
                            'straMapID' => $straMap,
                            'proID' => $id,
                            'updated_at' => now(), 
                            'created_at' => now() 
                        ]
                    );
                
                }    
            }else{
                DB::table('strategic_maps')->insert(
                    [
                        'straMapID' => $straMap,
                        'proID' => $id,
                        'updated_at' => now(), 
                        'created_at' => now() 
                    ]
                );
            }
        
        }
        $straMapToDelete = array_diff($straMapIDs,$straMapID);
        if(!empty($straMapToDelete)){
            DB::table('strategic_maps')
            ->where('proID',$id)
            ->whereIn('straMapID',$straMapToDelete)
            ->delete();
        }


        $userMaps = DB::table('users_map_projects')->where('proID',$id)->get();
        //ดึงuserIDทัั้งหมดในuserMap
        $userMapIDs = $userMaps->pluck('userID')->toArray();
        // dd($userMapIDs);
        $userMapID = $request->userID;
        //  dd($userMapIDs,$userMapID);

        
        foreach ($userMapID as $index => $userMap){
            if(isset($userMap)){
                $currentuserMapID = $userMap;
                // dd($currentuserMapID);
                if(in_array($currentuserMapID,$userMapIDs)){
                    DB::table('users_map_projects')->updateOrInsert(
                        [
                            'userID' => $currentuserMapID
                        ],
                        [
                            'proID' => $id,
                            'updated_at' => now()
                        ]
                        );
                }else{
                    DB::table('users_map_projects')->insert(
                        [
                            'userID' => $userMap,
                            'proID' => $id,
                            'updated_at' => now(), 
                            'created_at' => now() 
                        ]);
                }
            }else{
                DB::table('users_map_projects')->insert(
                    [
                        'userID'=>$userMap,
                        'proID'=>$id,
                        'updated_at' => now(), 
                        'created_at' => now() 
                    ]);
            }
        }

        $userMapToDelete = array_diff($userMapIDs,$userMapID);
        if(!empty($userMapToDelete)){
            DB::table('users_map_projects')
            ->where('proID',$id)
            ->whereIn('userID',$userMapToDelete)
            ->delete();
        }

        $objs = DB::table('objectives')->where('proID',$id)->get();
        $objIDs = $objs->pluck('objID')->toArray();
        // dd($objIDs);
        $obj = $request->obj;
        $objID = $request->objID;
        // dd($objIDs,$objID);
        
        foreach ($obj as $index => $obj) {
            
            // ตรวจสอบว่า $objID[$index] มีค่าอยู่หรือไม่
            if (isset($objID[$index])) {
                $currentObjID = $objID[$index];  // ดึง objID จาก array objID[]
                // dd($currentObjID);
                // ตรวจสอบว่า objID นี้มีอยู่ในฐานข้อมูลหรือไม่
                if (in_array($currentObjID, $objIDs)) {
                    // หาก objID นี้มีอยู่ในฐานข้อมูลแล้ว, ให้ทำการ update
                    DB::table('objectives')->updateOrInsert(
                        [   
                            'objID' => $currentObjID
                        ],  // เช็คด้วย objID
                        [
                            'proID' => $id,
                            'detail' => $obj,  // อัปเดตชื่อ
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
        
        $KPIProjects =DB::table('k_p_i_projects')->where('proID',$id)->get(); 
        $KPIProIDs = $KPIProjects->pluck('KPIProID')->toArray();
        $KPIProject = $request->KPIProject;
        $countProject = $request->countKPIProject;
        $targetProject = $request->targetProject;
        $KPIProID = $request->KPIProID;
        // dd($KPIProID);
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

        $steps =DB::table('steps')->where('proID',$id)->get(); 
        $stepIDs = $steps->pluck('stepID')->toArray();
        $stepName = $request->stepName;
        $stepStart = $request->stepStart;
        $stepEnd = $request->stepEnd;
        $stepID = $request->stepID;
        
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

        $benefits = DB::table('benefits')->where('proID',$id)->get();
        $bnfIDs = $benefits->pluck('bnfID')->toArray();
        $bnf = $request->benefit;
        $bnfID = $request->bnfID;

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
        $user=Users::all();
        $userMap = UsersMapProject::with('users')->get();
        $project=DB::table('projects')->where('proID',$id)->first();
        $strategicMap=StrategicMap::all();
        $strategic = Strategic3Level::all();
        $SFA = StrategicIssues::all();
        $goal = Goals::all();
        $tactics = Tactics::all();
        $projectYear=Year::all();
        $projectType=ProjectType::all();
        $projectCharector=ProjectCharec::all();
        $projectIntegrat=ProjectIntegrat::all();
        $projectOBJ=Objectives::all();
        $projectTarget=Targets::all();
        $projectStep=Steps::all();
        $projectBadgetType=BadgetType::all();
        $projectUniPlan=UniPlan::all();
        $projectCostQuarter=CostQuarters::all();
        $peojectEXP=ExpenseBadgets::all();
        $projectCostType=CostTypes::all();
        $projectBenefit=Benefits::all();
        return view('Project.report',compact('user','userMap','project','strategicMap','strategic','SFA','goal','tactics','projectYear','projectType','projectCharector','projectIntegrat','projectOBJ','projectTarget','projectStep','projectBadgetType','projectUniPlan','projectCostQuarter','peojectEXP','projectCostType','projectBenefit'));
    }



   
}