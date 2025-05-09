<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Year;
use App\Models\Users;
use App\Models\UsersMapProject;
use App\Models\Status;
use App\Models\Projects;
use App\Models\StrategicMap;
use App\Models\KPIMainMapProjects;
use App\Models\Strategic2LevelMapProject;
use App\Models\KPIMain2LevelMapProject;
use App\Models\Strategic1LevelMapProject;
use App\Models\KPIProjects;
use App\Models\ProjectType;
use App\Models\ProjectCharec;
use App\Models\ProjectIntegrat;
use Illuminate\Http\Request;
use App\Models\Targets;
use App\Models\BadgetType;
use App\Models\UniPlan;
use App\Models\ExpenseBadgets;
use App\Models\CostTypes;
use App\Models\Objectives;
use App\Models\Steps;
use App\Models\CostQuarters;
use App\Models\Benefits;
use App\Models\Files;
use App\Models\Comment;
use App\Models\ProjectEvaluation;
use App\Models\OperatingResults;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Carbon\Carbon;

class PlanningAnalyst extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    function projectAll(){
        $year = Year::all();
        $projectYear = Projects::with('year')->get();
        $project=Projects::with('projectType','status')->get();
        // dd($project);
        $proID = $project->pluck('proID');
        // dd($proID);
        $status=Status::all();
        $users = $users=DB::table('users')->get();
        $report_quarter = DB::table('report_quarters')->whereIn('proID',$proID)->get();
        // dd($report_quarter);
        $data['evaluation']=DB::table('projects')
        ->join('project_evaluations','project_evaluations.proID','=','projects.proID')
        ->join('report_quarters','report_quarters.proID','=','project_evaluations.proID')
        ->get();
       
        return view('Planning_Analyst.projectAll',compact('users','project','status','year','projectYear','report_quarter','data'));
    }
    
    function index(){
        $year = Year::all();
        $projectYear = Projects::with('year')->get();
        $project=DB::table('projects')->where('proTypeID',3)->whereIn('statusID',[2,6])->get();
        $proID = $project->pluck('proID');
        // dd($proID);
        $status=Status::all();
        $users = $users=DB::table('users')->get();
        $report_quarter = DB::table('report_quarters')->whereIn('proID',$proID)->get();
        // dd($report_quarter);
        $data['evaluation']=DB::table('projects')
        ->join('project_evaluations','project_evaluations.proID','=','projects.proID')
        ->join('report_quarters','report_quarters.proID','=','project_evaluations.proID')
        ->get();
        return view('Planning_Analyst.project',compact('users','project','status','year','projectYear','report_quarter','data'));
    }

    function projectOutPlan(){
        $year = Year::all();
        $projectYear = Projects::with('year')->get();
        $project=DB::table('projects')->where('proTypeID','4')->whereIn('statusID',[2,6])->get();
        // dd($project);
        $status=Status::all();
        $users = $users=DB::table('users')->get();
        $data['report'] = DB::table('report_quarters')->get();
        return view('Planning_Analyst.projectOutPlan',compact('users','project','status','year','projectYear','data'));
    }
    function projectCancel(){
        $data['year'] = Year::all();
        $data['projectYear'] = Projects::with('year')->get();
        $data['project'] = Projects::with('status')->whereIn('statusID',[15,11])->get();
        $data['evaluation']=DB::table('projects')
        ->join('project_evaluations','project_evaluations.proID','=','projects.proID')
        ->join('report_quarters','report_quarters.proID','=','project_evaluations.proID')
        ->get();
        // $data['user'] = DB::table('users_map_projects')->where('userID',auth()->id())->get();

        // $data['project'] = Projects::with('status')->whereIn('statusID',[15,11])->whereIn('proID',$data['user']->pluck('proID'))->get();
        return view('Planning_Analyst.projectCancel',compact('data'));
    }

    //เอกสารเสนอโครงการ
    function detail($id){
        $data['project'] = Projects::with(['year','status','projectType','badgetType','projectCharecter','projectIntegrat','target','UniPlan','Approver'])->where('proID',$id)->first();
        $data['user'] = UsersMapProject::with('users')->where('proID',$id)->get();

        $data['obj'] = Db::table('objectives')->where('proID',$id)->get();
        $data['benefit'] = DB::table('benefits')->where('proID',$id)->get();
        $data['file'] = DB::table('files')->where([['proID',$id],['type','เอกสารเสนอโครงการ']])->get();
        $data['stra3LVMap'] = StrategicMap::with(['Stra3LV','SFA3LV','goal3LV','tac3LV'])->where('proID',$id)->get();
        $data['KPI3LVMap'] = KPIMainMapProjects::with('KPI')->where('proID',$id)->get();
        // dd($data['KPI3LVMap']);
        $data['stra2LVMap']=Strategic2LevelMapProject::with(['stra2LV','SFA2LV','tac2LV'])->where('proID',$id)->get();
        $data['KPI2LVMap'] = KPIMain2LevelMapProject::with('KPI')->where('proID',$id)->get();

        $data['stra1LVMap'] = Strategic1LevelMapProject::with(['stra1LV','tar1LV'])->where('proID',$id)->get();

        $data['KPIProject'] = KPIProjects::with('count')->where('proID',$id)->get();
        $data['step'] = DB::table('steps')->where('proID',$id)->get();
        $data['costQuarter'] = CostQuarters::with(['exp','cost'])->where('proID',$id)->get();

        $data['comment'] = Comment::with('user')->where([['proID',$id],['type','เอกสารเสนอโครงการ']])->get();
        // dd($comment);
        return view('Planning_Analyst.detail',compact('data'));
    }
    function planningPass(Request $request,$id){
        DB::table('projects')->where('proID',$id)->update(['statusID' => '3']);
        $detail = $request->input('comment');
        $userID = Auth::id();
        if(!empty($detail)){
            $commentID = DB::table('comments')->insertGetId(
                [
                    'proID' => $id,
                    'detail' => $detail,
                    'type' => 'เอกสารเสนอโครงการ',
                    'userID' => $userID,
                    'updated_at' => now(), 
                    'created_at' => now() 
                ]);
        }

        if(!empty($commentID)){
            $comment = DB::table('comments')->where('commentID',$commentID)->first();
            // dd($comment);
        }

        $Executive = DB::table('users')->where([['Executive',1],['position_name','รองผู้อำนวยการ ฝ่ายบริหาร']])->first();
        $project = Projects::with('status')->where('proID',$id)->first();

        // dd($Executive);
        // foreach ($Executive as $index => $item) {
            $mailData = [
                'name' => $project->name,
                'text' => $project->status->name
            ];

            if(!empty($comment)) {
                $mailData['comment'] = $comment->detail;
                $mailData['userComment'] = Auth::user()->displayname;
                $mailData['created_at'] = $comment->created_at;
            }
            Mail::to($Executive->email)->send(new SendMail($mailData));
        // }

        $users = UsersMapProject::with('users')->where('proID',$id)->get();
        foreach ($users as $index => $item) {
            $mailData = [
                'name' => $project->name,
                'text' => $project->status->name
            ];

            if(!empty($comment)) {
                $mailData['comment'] = $comment->detail;
                $mailData['userComment'] = Auth::user()->displayname;
                $mailData['created_at'] = $comment->created_at;
            }
            Mail::to($item->users->email)->send(new SendMail($mailData));
        }

        if($project->proTypeID == 3){
            return redirect('/PlanningAnalystProject');
        }else{
            return redirect('/PlanningAnalystProjectOutPlan');
        }

        
    }

    //เอกสารประเมินโครงการ
    function detailEvaluation($id){
        $data['evaluation']=ProjectEvaluation::with('operating')->where('proID',$id)->first();

        $data['project'] = Projects::with('badgetType')->where('proID',$id)->first();
        $data['status'] = DB::table('statuses')->where('statusID',$data['project']->statusID)->first();
        
        $data['file'] = DB::table('files')->where('proID',$id)->where('type','เอกสารปิดโครงการ')->get();
       

        $data['stra3LVMap'] = StrategicMap::with(['Stra3LV','SFA3LV','goal3LV','tac3LV'])->where('proID',$id)->get();
        $data['stra2LVMap']=Strategic2LevelMapProject::with(['stra2LV','SFA2LV','tac2LV'])->where('proID',$id)->get();
        $data['stra1LVMap'] = Strategic1LevelMapProject::with(['stra1LV','tar1LV'])->where('proID',$id)->get();
        
        $data['stepStart'] = DB::table('steps')->where('proID',$id)->orderBy('start' ,'ASC')->first();
        $data['stepStartFormat'] = Carbon::parse($data['stepStart']->start)
        ->locale('th')  // ตั้งค่าภาษาไทย
        ->translatedFormat('j F Y');
        
        $data['stepEnd']= DB::table('steps')->where('proID',$id)->orderBy('end' ,'desc')->first();
        $data['stepEndFormat'] = Carbon::parse($data['stepEnd']->end)
        ->locale('th')  // ตั้งค่าภาษาไทย
        ->translatedFormat('j F Y');
        
        $data['obj']=DB::table('objectives')->where('proID',$id)->get();
        $data['operating'] = OperatingResults::all();
        $data['KPIProject']=DB::table('k_p_i_projects')->where('proID',$id)->get();

        $data['report_quarter'] = DB::table('report_quarters')->where('proID',$id)->get();
        $data['costResult']=$data['report_quarter']->sum('costResult');
        $data['comment'] = Comment::with('user')->where([['proID',$id],['type','เอกสารประเมินโครงการ']])->get();
       

        return view('Planning_Analyst.detailEvaluation',compact('data'));
    }

    function EvaluationPass(Request $request,$id){
        DB::table('projects')->where('proID',$id)->update(['statusID' => '7']);
        $detail = $request->input('comment');
        $userID = Auth::id();
        if(!empty($detail)){
            $commentID = DB::table('comments')->insertGetId(
                [
                    'proID' => $id,
                    'detail' => $detail,
                    'type' => 'เอกสารประเมินโครงการ',
                    'userID' => $userID,
                    'updated_at' => now(), 
                    'created_at' => now() 
                ]);
        }

        if(!empty($commentID)){
            $comment = DB::table('comments')->where('commentID',$commentID)->first();
            // dd($comment);
        }

        $Executive = DB::table('users')->where([['Executive',1],['position_name','รองผู้อำนวยการ ฝ่ายบริหาร']])->first();
        $project = Projects::with('status')->where('proID',$id)->first();

        // dd($Executive);
        // foreach ($Executive as $index => $item) {
            $mailData = [
                'name' => $project->name,
                'text' => $project->status->name
            ];

            if(!empty($comment)) {
                $mailData['comment'] = $comment->detail;
                $mailData['userComment'] = Auth::user()->displayname;
                $mailData['created_at'] = $comment->created_at;
            }
            Mail::to($Executive->email)->send(new SendMail($mailData));
        // }

        $users = UsersMapProject::with('users')->where('proID',$id)->get();
        foreach ($users as $index => $item) {
            $mailData = [
                'name' => $project->name,
                'text' => $project->status->name
            ];

            if(!empty($comment)) {
                $mailData['comment'] = $comment->detail;
                $mailData['userComment'] = Auth::user()->displayname;
                $mailData['created_at'] = $comment->created_at;
            }
            Mail::to($item->users->email)->send(new SendMail($mailData));
        }
        if($project->proTypeID == 3){
            return redirect('/PlanningAnalystProject');
        }else{
            return redirect('/PlanningAnalystProjectOutPlan');
        }
    }

    
}
