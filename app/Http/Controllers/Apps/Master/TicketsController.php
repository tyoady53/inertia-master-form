<?php

namespace App\Http\Controllers\Apps\Master;

use App\Http\Controllers\Controller;
use App\Models\Cis_menu_app;
use App\Models\Helpdesk;
use App\Models\Helpdesk_thread;
use App\Models\Helpdesk_topic;
use App\Models\Lis_cis_module;
use App\Models\Lis_menu_app;
use App\Models\MasterCustomer;
use App\Models\MasterCustomerBranch;
use App\Models\MasterDivision;
use App\Models\Sla_plan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TicketsController extends Controller
{
    public function index()
    {
        $helpdesks = Helpdesk::with('thread', 'topic', 'module', 'sla', 'lis', 'cis', 'user', 'assign', 'customer', 'branch')->get();

        return Inertia::render('Apps/Tickets/Index',[
            'data' => $helpdesks
        ]);
    }

    public function create(Request $request)
    {
        $departments = MasterDivision::get();
        $users = User::where('id', '!=', auth()->user()->id)->get();
        $topics = Helpdesk_topic::get();
        $sla_plans = Sla_plan::get();
        $tag_modules = Lis_cis_module::get();
        $lis_menu_tags = Lis_menu_app::get();
        $cis_menu_apps = Cis_menu_app::get();
        $master_customers = MasterCustomer::get();
        $master_customer = MasterCustomer::where('id', $request->id)->first();

        return Inertia::render('Apps/Tickets/Create', [
            'departments' => $departments,
            'topics'    => $topics,
            'users'     => $users,
            'sla_plans' => $sla_plans,
            'tag_modules' => $tag_modules,
            'lis_menu_app'  => $lis_menu_tags,
            'cis_menu_app'  => $cis_menu_apps,
            'master_customers' => $master_customers,
        ]);
    }

    public function store(Request $request)
    {

        // dd(strlen($request->description));
        $this->validate($request, [
            'department_id' => 'required',
            'assign_id' => 'required',
            'topic_id' => 'required',
            'sla_id' => 'required',
            'ticket_source' => 'required',
            'priority' => 'required',
            'customer_id' => 'required',
            'branch_id' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        $sla_hours = Sla_plan::where('id', $request->sla_id)->first();
        $last_data = Helpdesk::latest('created_at')->first();
        if($last_data){
            if(substr($last_data->thread_id,0,5)!=date("ym")){
                $generated = date("ym").'0001';
            }else{
                $generated = $last_data->thread_id + 1;
            }
        } else {
            $generated = date("ym").'0001';
        }

            Helpdesk::create([
            'thread_id' => $generated,
            'ticket_date' => date("Ymd"),
            'ticket_source' => $request->ticket_source,
            'duedate'       => Carbon::now()->addHours($sla_hours->sla_hour),
            'status'        => 'open',
            'created_by'    => auth()->user()->id,
            'department_id' => $request->department_id,
            'assign_id' => $request->assign_id,
            'topic_id' => $request->topic_id,
            'sla_id' => $request->sla_id,
            'priority' => $request->priority,
            'customer_id' => $request->customer_id,
            'branch_id' => $request->branch_id,
            'title' => $request->title,
            'description' => $request->description,
            'outlet_id' => $request->outlet_id,
            // 'out_name'  => $request->out_name,
            'analyzer_name' => $request->analyzer_name,
            'hid'   => $request->hid,
            'cable_length'  => $request->cable_length,
            'additional_com'    => $request->additional_com,

        ]);

        return redirect()->route('apps.master.tickets.index');
    }

    public function getDepartments()
    {
        $departments = MasterDivision::get();

        return response()->json([
            'success'   => true,
            'message'   => 'Get All Departments',
            'data'      => $departments
        ]);
    }

    public function getUser(Request $request)
    {
        $departments = MasterDivision::where('id', $request->id)->first();

        $users = User::where('division', $request->id)->get();

        return response()->json([
            'success'   => true,
            'message'   =>'List Data City By Province : '.$departments->name.'',
            'data'      => $users
        ]);
    }

    public function getBranch(Request $request)
    {
        $master_branch = MasterCustomerBranch::where('customer_id', $request->id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'List Data Branch By Customer',
            'data'      => $master_branch
        ]);
    }

    public function show($thread_id) 
    {

        // dd($thread_id);
        $thread = Helpdesk::with('user', 'topic', 'assign', 'sla', 'division', 'thread')->where('thread_id', $thread_id)->first();
        $threads = Helpdesk_thread::with('user')->where('helpdesk_id', $thread_id)->orderBy('id', 'ASC')->get();
        // dd($threads);
        $users = User::where('id', '!=', auth()->user()->id)->get();
        // $helpdesk = Helpdesk::get();

        return Inertia::render('Apps/Tickets/Thread', [
            'data' => $thread,
            'users'  => $users,
            'threads' => $threads
            // 'helpdesks' => $helpdesk,
        ]); 
    }

    public function thread(Request $request)
    {
        Helpdesk_thread::create([
            'helpdesk_id'   => $request->helpdesk_id,
            'title'         => $request->title,
            'description'   => $request->description,
            'file_upload'   => $request->file_upload,
            'assign_id'     => $request->assign_id,
            'created_by'    => auth()->user()->id,

        ]);

        return back()->with('Data Berhasil Terkirim');
    }
}
