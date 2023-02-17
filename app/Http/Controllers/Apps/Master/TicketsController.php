<?php

namespace App\Http\Controllers\Apps\Master;

use App\Http\Controllers\Controller;
use App\Models\Helpdesk;
use App\Models\Helpdesk_topic;
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
        $helpdesks = Helpdesk::with('thread', 'topic', 'module', 'sla', 'lis', 'cis', 'user', 'assign')->get();

        return Inertia::render('Apps/Tickets/Index',[
            'data' => $helpdesks
        ]);
    }

    public function create()
    {
        $departments = MasterDivision::get();
        $users = User::where('id', '!=', auth()->user()->id)->get();
        $topics = Helpdesk_topic::get();
        $sla_plans = Sla_plan::get();

        return Inertia::render('Apps/Tickets/Create', [
            'departments' => $departments,
            'topics'    => $topics,
            'users'     => $users,
            'sla_plans' => $sla_plans
        ]);
    }

    public function store(Request $request)
    {

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
            if(substr($last_data->index_id,0,5)!=date("ym")){
                $generated = date("ym").'0001';
            }else{
                $generated = $last_data->index_id+1;
            }
        } else {
            $generated = date("ym").'0001';
        }

            Helpdesk::create([
            'thread_id' => $generated,
            'ticket_date' => date("Ymd"),
            'ticket_source' => $request->ticket_source,
            'duedate'       => Carbon::now()->addHours($sla_hours->sla_hour),
            'status'        => 'pending',
            'created_by'    => auth()->user()->id,
            'department_id' => $request->department_id,
            'assign_id' => $request->assign_id,
            'topic_id' => $request->topic_id,
            'sla_id' => $request->sla_id,
            'priority' => $request->priority,
            'customer_id' => $request->customer_id,
            'branch_id' => $request->branch_id,
            'title' => $request->title,
            'description' => $request->description
        ]);

    }
}
