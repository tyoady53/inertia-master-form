<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Extend;
use App\Models\master_table;
use App\Models\master_table_structure;
use App\Models\User;
use Carbon\Carbon;
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
        // dd(date("ym"));
        if(auth()){
            $user_id = auth()->user()->id;
        }
        $edit = 'no';$use_status = 'no'; $last_status = '';
        $extend = array();
        $data   = DB::table($name)
            ->join('master_assignment', $name.'.index_id', '=', "master_assignment.index_id")
            ->select($name.'.*')
            ->where('master_assignment.user_id',$user_id)
            ->where('master_assignment.index_id',$id)
            ->union(DB::table($name)->where('index_id',$id))->orderBy('id','ASC')
            ->first();
        $table_selected = master_table::where('name',$name)->first();
        $header = master_table_structure::where('table_id',$table_selected->id)->get();
        $ts = User::where('id',$data->created_by)->first();

        $datas = Extend::with('user','files')->where('index_id',$id)->get();
        foreach($datas as $d){
            $extend[] = ['index_id' => $d->index_id, 'description' => $d->description, 'created_at' => date_format($d->created_at,"Y-m-d H:i:s") , 'status' => $d->status, 'name' => $d['user']->name];
        }
        if($data->created_by == auth()->user()->id){
            $edit = 'yes';
        }
        if($table_selected->status == '1'){
            $last_status = $data->status_report;
            $use_status = 'yes';
        }
        // dd($data,$extend,$edit);


        if($data->index_id){
            return inertia('Apps/Forms/Extend/Index', [
                'data'          => $data,
                'edit'          => $edit,
                'extend'        => $extend,
                'headers'       => $header,
                'treat_starter' => $ts,
                'ticket'        => $id,
                'table'         => $table_selected,
                'csrfToken'     => csrf_token(),
                'select_status' => DB::table('master_status_report')->orderBy('id','ASC')->get(),
                'last_status'   => $last_status,
                'use_status'    => $use_status,
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
        // dd(auth()->user()->name);
        $status_now = '';$input_status = '';
        $select = DB::table('master_tables')->where('name',$name)->first();
        $table_id = $select->id;
        $data_table = DB::table($name)->where('index_id',$id)->first();
        if($select->status == '1'){
            $status_now = $data_table->status_report;
            if(auth()->user()->id == $data_table->created_by){
                if($status_now == 'Done'){
                    $input_status = 'Done';
                } else {
                    $input_status = $request->status_report;
                    if($status_now != $input_status){
                        $desc = '[System] '.auth()->user()->name.' Update status from '.$status_now.' to '.$input_status;
                        Extend::create(['table_id'=>$table_id,'index_id'=>$id,'description'=>$desc,'status'=>$input_status,'created_by'=>auth()->user()->id]);
                        DB::statement("UPDATE $name SET status_report = '$input_status',created_at = '$data_table->created_at' WHERE index_id='$id';");
                    }
                }
                $data   = Extend::create(['table_id'=>$table_id,'index_id'=>$id,'description'=>$request->description,'status'=>$input_status,'created_by'=>auth()->user()->id]);
            } else {
                $input_status = $status_now;
                $data   = Extend::create(['table_id'=>$table_id,'index_id'=>$id,'description'=>$request->description,'status'=>$input_status,'created_by'=>auth()->user()->id]);
            }
        }else {
            $data   = Extend::create(['table_id'=>$table_id,'index_id'=>$id,'description'=>$request->description,'created_by'=>auth()->user()->id]);
        }

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
    public function edit(Request $request)
    {
        
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
