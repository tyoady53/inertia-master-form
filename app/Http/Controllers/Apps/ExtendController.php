<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Extend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ExtendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name,$id)
    {
        if(auth()){
            $user_id = auth()->user()->id;
        }
        $data   = DB::table($name)
            ->join('master_assignment', $name.'.index_id', '=', "master_assignment.index_id")
            ->select($name.'.*')
            ->where('master_assignment.user_id',$user_id)
            ->where('master_assignment.index_id',$id)
            ->union(DB::table($name)->where('index_id',$id))->orderBy('id','ASC')
            ->first();
            // dd($data->status_report);
        $ts = User::where('id',$data->created_by)->first();

        $extend = Extend::with('user','files')->where('index_id',$id)->get();

        if($data->index_id){
            return inertia('Apps/Forms/Extend/Index', [
                'data'          => $data,
                'extend'        => $extend,
                'treat_starter' => $ts,
                'ticket'        => $id,
                'table'         => $name,
                'csrfToken'     => csrf_token(),
                'select_status' => DB::table('master_status_report')->orderBy('id','ASC')->get(),
                'last_status'   => $data->status_report,
            ]);
        }

        return Inertia::render('Apps/Forbidden', [
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$name,$id)
    {
        $select = DB::table('master_tables')->where('name',$name)->first();
        $data   = Extend::create(['table_id'=>$select->id,'index_id'=>$id,'description'=>$request->description,'created_by'=>auth()->user()->id]);

        if($data){
            return redirect()->route('apps.master.forms.extend_index',[$name,$id]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
