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

class Executive extends Controller
{
    function index(){
        $year = Year::all();
        $projectYear = Projects::with('year')->get();
        // $status=Status::all();
        
        if(auth()->user()->username == 'prasertsakt'){
            $project=Projects::with('status')->where([['proTypeID',3]])->whereIn('statusID',[3,7])->orWhere('statusID',1)->where('approverID',auth()->id())->get();
        }else{
            $project=Projects::with('status')->where([['proTypeID',3],['approverID',auth()->id()]])->whereIn('statusID',[1,5])->get();
            // dd($project);
        }
        $proID = $project->pluck('proID');
        // dd($proID);
        $users = $users=DB::table('users')->get();
        $report_quarter = DB::table('report_quarters')->whereIn('proID',$proID)->get();
        // dd($report_quarter);
        return view('Executive.projectlist',compact('users','project','year','projectYear','report_quarter'));
    }

    function projectOutPlan(){
        $year = Year::all();
        $projectYear = Projects::with('year')->get();
        if(auth()->user()->username == 'prasertsakt'){
            $project=Projects::with('status')->where([['proTypeID',4]])->whereIn('statusID',[3,7])->orWhere('statusID',1)->where('approverID',auth()->id())->get();
        }else{
            $project=Projects::with('status')->where([['proTypeID',4],['statusID',1],['approverID',auth()->id()]])->get();
            // dd($project);
        }
        $users = $users=DB::table('users')->get();
        return view('Executive.projectOutPlan',compact('users','project','year','projectYear'));
    }

    function projectDenied(){
        $data['year'] = Year::all();
        $data['projectYear'] = Projects::with('year')->get();
        $data['project'] = Projects::with('status')->whereIn('statusID',[15,11])->get();

        // $data['user'] = DB::table('users_map_projects')->where('userID',auth()->id())->get();

        // $data['project'] = Projects::with('status')->whereIn('statusID',[15,11])->whereIn('proID',$data['user']->pluck('proID'))->get();
        return view('Executive.projectDenied',compact('data'));
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
        // dd($comment );
        return view('Executive.projectDetail',compact('data'));
    }
    function ExecutivePass(Request $request, $id){
        DB::table('projects')->where('proID',$id)->update(['statusID' => 2]);
        $project = Projects::with('status')->where('proID',$id)->first();
        // dd($project);
        $detail = $request->input('comment');
        if(!empty($detail)){
            $userID = Auth::id();
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
        }

        $userMap = UsersMapProject::with('users')->where('proID',$id)->get();
        
        
        foreach ($userMap as $index => $item) {
            $mailData = [
                'name' => $project->name,
                'text' => $project->status->name
            ];
            if(!empty($comment)){
                $mailData['comment'] = $comment->detail;
                $mailData['userComment'] = Auth::user()->displayname;
                $mailData['created_at'] = $comment->created_at;
            }
            Mail::to($item->users->email)->send(new SendMail($mailData));
        }

        return redirect('/ExecutiveProjectlist');
    }
    function ExecutiveApprove(Request $request, $id){
        DB::table('projects')->where('proID',$id)->update(['statusID' => 4]);
        $project = Projects::with('status')->where('proID',$id)->first();
        // dd($project);
        $detail = $request->input('comment');
        if(!empty($detail)){
            $userID = Auth::id();
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
        }

        $userMap = UsersMapProject::with('users')->where('proID',$id)->get();
        
        
        foreach ($userMap as $index => $item) {
            $mailData = [
                'name' => $project->name,
                'text' => $project->status->name
            ];
            if(!empty($comment)){
                $mailData['comment'] = $comment->detail;
                $mailData['userComment'] = Auth::user()->displayname;
                $mailData['created_at'] = $comment->created_at;
            }
            Mail::to($item->users->email)->send(new SendMail($mailData));
        }

        return redirect('/ExecutiveProjectlist');
    }
    function ExecutiveDenied(Request $request,$id){
        $request->validate([
            'comment'=>'required'
        ]);
        DB::table('projects')->where('proID',$id)->update(['statusID' => 15]);
        $detail = $request->input('comment');
        $userID = Auth::id();
        
        $commentID = DB::table('comments')->insertGetId(
            [
                'proID' => $id,
                'detail' => $detail,
                'type' => 'เอกสารเสนอโครงการ',
                'userID' => $userID,
                'updated_at' => now(), 
                'created_at' => now() 
            ]);

        $comment = DB::table('comments')->where('commentID',$commentID)->first();
        $project = Projects::with('status')->where('proID',$id)->first();

        $userMap = UsersMapProject::with('users')->where('proID',$id)->get();
        foreach ($userMap as $index => $item) {
            Mail::to($item->users->email)->send(new SendMail(
                [
                    'name' => $project->name,
                    'text' => $project->status->name,
                    'comment' => $comment->detail,
                    'userComment' => Auth::user()->displayname,
                    'created_at' => $comment->created_at
                ]
            ));
        }


        return redirect('/ExecutiveProjectlist');
    }
    function ExecutiveEdit(Request $request,$id){
        $request->validate([
            'comment'=>'required'
        ]);
        DB::table('projects')->where('proID',$id)->update(['statusID' => '12']);
        $detail = $request->input('comment');
        $userID = Auth::id();
        $commentID = DB::table('comments')->insertGetID(
            [
                'proID' => $id,
                'detail' => $detail,
                'type' => 'เอกสารเสนอโครงการ',
                'userID' => $userID,
                'updated_at' => now(), 
                'created_at' => now() 
            ]);

        $comment = DB::table('comments')->where('commentID',$commentID)->first();
        $userMap = UsersMapProject::with('users')->where('proID',$id)->get();
        $project = Projects::with('status')->where('proID',$id)->first();
        foreach ($userMap as $index => $item) {
            Mail::to($item->users->email)->send(new SendMail(
                [
                    'name' => $project->name,
                    'text' => $project->status->name,
                    'comment' => $comment->detail,
                    'userComment' => Auth::user()->displayname,
                    'created_at' => $comment->created_at
                ]
            ));
        }
        return redirect('/ExecutiveProjectlist');
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

        return view('Executive.detailEvaluation',compact('data'));
    }
    function EvaluationPass(Request $request, $id){
        $data['evaluation'] = DB::table('project_evaluations')->where('proID',$id)->first();

        // $data['statusID'] = '';
        // if($data['evaluation']->operID == 1){
        //     $data['statusID'] = 8;
        // }elseif($data['evaluation']->operID == 2){
        //     $data['statusID'] = 9;
        // }elseif($data['evaluation']->operID == 3){
        //     $data['statusID'] = 10;
        // }else{
        //     $data['statusID'] = 11;
        // }

        DB::table('projects')->where('proID',$id)->update(['statusID' => 6]);
        $data['project'] = Projects::with('status')->where('proID',$id)->first();
        $detail = $request->input('comment');
        if(!empty($detail)){
            $userID = Auth::id();
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
        }

        $userMap = UsersMapProject::with('users')->where('proID',$id)->get();
        
        foreach ($userMap as $index => $item) {
            $mailData = [
                'name' => $data['project']->name,
                'text' => $data['project']->status->name
            ];
            if(!empty($comment)){
                $mailData['comment'] = $comment->detail;
                $mailData['userComment'] = Auth::user()->displayname;
                $mailData['created_at'] = $comment->created_at;
            }
            Mail::to($item->users->email)->send(new SendMail($mailData));
        }

        return redirect('/ExecutiveProjectlist');
    }
    function EvaluationEdit(Request $request,$id){
        
        DB::table('projects')->where('proID',$id)->update(['statusID' => '13']);
        $data['project'] = Projects::with('status')->where('proID',$id)->first();
        $detail = $request->input('comment');
        $userID = Auth::id();
        $commentID = DB::table('comments')->insertGetId(
            [
                'proID' => $id,
                'detail' => $detail,
                'type' => 'เอกสารประเมินโครงการ',
                'userID' => $userID,
                'updated_at' => now(), 
                'created_at' => now() 
            ]);

            $comment = DB::table('comments')->where('commentID',$commentID)->first();
            $userMap = UsersMapProject::with('users')->where('proID',$id)->get();
            foreach ($userMap as $index => $item) {
                Mail::to($item->users->email)->send(new SendMail(
                    [
                        'name' => $data['project']->name,
                        'text' => $data['project']->status->name,
                        'comment' => $comment->detail,
                        'userComment' => Auth::user()->displayname,
                        'created_at' => $comment->created_at
                    ]
                ));
            }
        return redirect('/ExecutiveProjectlist');
    }
    function EvaluationDenied(Request $request,$id){
        // $request->validate([
        //     'comment'=>'required'
        // ]);
        DB::table('projects')->where('proID',$id)->update(['statusID' => 15]);
        $data['project'] = Projects::with('status')->where('proID',$id)->first();
        
        $detail = $request->input('comment');
        $userID = Auth::id();
        
        $commentID = DB::table('comments')->insertGetId(
            [
                'proID' => $id,
                'detail' => $detail,
                'type' => 'เอกสารประเมินโครงการ',
                'userID' => $userID,
                'updated_at' => now(), 
                'created_at' => now() 
            ]);

            $comment = DB::table('comments')->where('commentID',$commentID)->first();
            $userMap = UsersMapProject::with('users')->where('proID',$id)->get();
            foreach ($userMap as $index => $item) {
                Mail::to($item->users->email)->send(new SendMail(
                    [
                        'name' => $data['project']->name,
                        'text' => $data['project']->status->name,
                        'comment' => $comment->detail,
                        'userComment' => Auth::user()->displayname,
                        'created_at' => $comment->created_at
                    ]
                ));
            }
            

        return redirect('/ExecutiveProjectlist');
    }

    function EvaluationApprove(Request $request, $id){
        $data['evaluation'] = DB::table('project_evaluations')->where('proID',$id)->first();

        $data['statusID'] = '';
        if($data['evaluation']->operID == 1){
            $data['statusID'] = 8;
        }elseif($data['evaluation']->operID == 2){
            $data['statusID'] = 9;
        }elseif($data['evaluation']->operID == 3){
            $data['statusID'] = 10;
        }else{
            $data['statusID'] = 11;
        }

        DB::table('projects')->where('proID',$id)->update(['statusID' => $data['statusID']]);
        $data['project'] = Projects::with('status')->where('proID',$id)->first();
        $detail = $request->input('comment');
        if(!empty($detail)){
            $userID = Auth::id();
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
        }

        $userMap = UsersMapProject::with('users')->where('proID',$id)->get();
        
        foreach ($userMap as $index => $item) {
            $mailData = [
                'name' => $data['project']->name,
                'text' => $data['project']->status->name
            ];
            if(!empty($comment)){
                $mailData['comment'] = $comment->detail;
                $mailData['userComment'] = Auth::user()->displayname;
                $mailData['created_at'] = $comment->created_at;
            }
            Mail::to($item->users->email)->send(new SendMail($mailData));
        }

        return redirect('/ExecutiveProjectlist');
    }

}
