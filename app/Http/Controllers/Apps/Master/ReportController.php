<?php

namespace App\Http\Controllers\Apps\Master;

use App\Exports\FilterExport;
use App\Http\Controllers\Controller;
use App\Models\MasterCustomer;
use App\Models\MasterCustomerBranch;
use App\Models\PublicModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpOffice\PhpSpreadsheet\Reader\Gnumeric\PageSetup;

class ReportController extends Controller
{
    public function index()
    {
        $a = array();
        if(auth()){
            $user_id = auth()->user()->id;
        }
        $user = User::where('id',$user_id)->first();
        $sides = Role::where('name', $user->getRoleNames())->with('permissions')->latest()->get();
        $e = '(';
        for ($i = 0; $i < $sides->count(); $i++){
            for ($j = 0; $j < $sides[$i]['permissions']->count(); $j++){
                if(str_contains($sides[$i]['permissions'][$j]['name'], 'index')){
                    if(str_contains($sides[$i]['permissions'][$j]['name'],'form')){
                        $a[] = array(explode('-', explode('.', $sides[$i]['permissions'][$j]['name'])[0])[1]);
                        $e .= "'".explode('-', explode('.', $sides[$i]['permissions'][$j]['name'])[0])[1]."',";
                        $b[]= explode('-', explode('.', $sides[$i]['permissions'][$j]['name'])[0])[1];
                    }
                }
            }
        }
        $select_val = substr($e,0,-1);
        $select_val .= ')';
        $form_access = DB::table('master_tables')->whereIn('name',$a)->get();

        return Inertia::render('Apps/Reports/Index', [
            'form_access'   => $form_access,
        ]);
    }

    public function show(Request $request, $name)
    {
        if(auth()){
            $user_id = auth()->user()->id;
        }
        $user = User::where('id',$user_id)->first();
        $select_field = '';$form = '';
        $select = DB::table('master_tables')->where('name',$name)->first();
        $table_name = $select->description;
        $title  = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->get();
        if($name == 'master_customers'){
            $users = NULL;
        } else if($name == 'master_customer_branches'){
            $users = NULL;
        } else{
            $users = DB::table('users')
            ->join($name, 'users.id', '=', $name.".created_by")
            ->select('users.*')
            ->groupBy($name.".created_by")
            ->get();
        }
        // dd($users);
        $header = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->get();
        
        $selected_data = array();
        if ($title->count() > 0){
			foreach ($title as $index => $t){
				$select_field .= 'id,'.$t->field_name.',';
			}
			$selected = substr($select_field, 0,-1);
            $form = DB::table($name)->selectRaw($selected)->where('status','1')->get();
		} else {
            $form = DB::table($name)->latest()->get();
        }
        foreach($header as $head){
            $selected_data[$head->field_name] = DB::table($name)->distinct()->get($head->field_name);
        }
        return Inertia::render('Apps/Reports/Show', [
            'table'         => $name,
            'user_role'     => strtolower($user->getRoleNames()),
            'user_id'       => auth()->user()->id,
            'csrfToken'     => csrf_token(),
            'table_name'    => $select,
            'title'         => $title,
            'headers'       => $header,
            'users'         => $users,
            'forms'         => $form,
            'selected'      => $selected_data,
            'extend'        => $select->extend,
            'status_report' => $select->status,
        ]);
    }

    function generate_report($name, $id){
        $tgl = '';
        $result = array();
        $array_data = array();
        $array_ = array();
        $select_field = '';
        $user_id = $id;
        $public_model = new PublicModel();
        $select = $public_model->get_single_data_single_filter('master_tables','name',$name);
        if($select->extend){
            $form = DB::table($name)
                ->join('master_assignment', $name.'.index_id', '=', "master_assignment.index_id")
                ->select($name.'.*')
                ->where('master_assignment.user_id',$user_id)
                ->union(DB::table($name)->where('created_by',$user_id))->orderBy('id','DESC')
                ->get();
        } else {
            $form = DB::table($name)->where('created_by',$user_id)->latest()->get();
        }
        $header = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->orderBy('sequence_id','asc')->get();
        $child_data   = array();
        foreach ($header as $he){
            if(str_contains($he->input_type, 'Parent')){
                if($he->relate_to != 'Customers#Parent'){
                    $relate_table = DB::table('master_parent_child')->where('index_id',explode('#',$he->relate_to)[0])->first();
                    $data = explode('#',$he->relate_to)[0];
                    $table_reference_id = explode('.',$data)[2];
                    $table_reference_name = DB::table('master_tables')->where('id',$table_reference_id)->first();
                    $reference_structure = DB::table('master_table_structures')->where('table_id',$table_reference_id)->get();
                    if($public_model->get_table_single_filter('master_relation','table_name_from',$table_reference_name->name)->count() > 0){
                        foreach ($reference_structure as $chk_data){
                            $m = DB::table('master_relation')->where('table_name_from',$relate_table->relate_to)->get();
                            foreach($m as $n){
                                $z = $n->table_name_to;
                                $parent_data = [$data => DB::table($z)->get()];
                            }
                        }
                    } else {
                        $parent_data = [$data => DB::table($relate_table->relate_to)->groupBy($relate_table->field_name)->get()];
                    }
                }
            }
            if(str_contains($he->input_type, 'Child')){
                if($he->relate_to != 'Customers#Child'){
                    $relate_table = DB::table('master_parent_child')->where('index_id',explode('#',$he->relate_to)[0])->first();
                    $child_data  = DB::table($relate_table->relate_to)->get();
                }
            }
            if(str_contains($he->input_type, 'Checklist')){
                $checklist_data[explode('#',$he->relate_to)[0]] = [explode('#',$he->relate_to)[0] => $public_model->get_all_table_data(explode('#',$he->relate_to)[0])/*DB::table(explode('#',$he->relate_to)[0])->get()*/,"field_from" => explode('#',$he->relate_to)[1]];
            }
        }

        $title  = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->get();
        $header = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->orderBy('sequence_id','asc')->get();
        if ($title){
            $relation = $public_model->get_table_single_filter('master_relation','table_name_from',$name);
			foreach ($title as $index => $t){
                $select_field .= $t->field_name.',';
                if($relation->count() > 0){
                    foreach ($relation as $rel){
                        if($rel->relation_id == $t->relate_to){
                            $result[$rel->relation_id] = DB::table($rel->table_name_to)->get();
                        }
                    }
                }
			}
		} else {
            $form = DB::table($name)->latest()->get();
        }
        if($name == 'master_customer_branches'){
            $data_ = ['parent' => MasterCustomer::orderBy('customer_name','ASC')->get(), 'child' => MasterCustomerBranch::orderBy('customer_id','ASC')->orderBy('customer_branch','ASC')->get()];
        }
        if($name == 'master_customers'){
            $paginator = MasterCustomer::orderBy('customer_name','ASC')->get();
        } else if($name == 'master_customer_branches'){
            $paginator = MasterCustomerBranch::join('master_customers', 'master_customer_branches.customer_id', '=', "master_customers.id")->orderBy('master_customers.customer_name','ASC')->orderBy('outlet_id','ASC')->get();
            // $paginator = MasterCustomerBranch::with('customer_name')->orderBy('customer_name','ASC')->orderBy('outlet_id','ASC')->paginate(5);
        } else{
            foreach($form as $idx => $raw){
                foreach($header as $h) {
                    if($select->extend == '1'){
                        $test['index_id'] = $raw->index_id;
                    }
                    if($select->status == '1'){
                        $test['status_report'] = $raw->status_report;
                    }
                    $field_name = $h->field_name;
                    if(explode('#',$h->input_type)[0] == 'Parent'){
                        $name = explode('#',$h->relate_to)[1];
                        $this_head_parent = DB::table('master_table_structures')->where('table_id',explode('.',$h->relate_to)[2])->get();
                        foreach($this_head_parent as $head_parent){
                            if($head_parent->relate_to != ''){
                                $this_parent_rel = DB::table('master_relation')->where('relation_id',$head_parent->relate_to)->first();
                                $this_parent_data = DB::table($this_parent_rel->table_name_to)->get();
                                foreach($this_parent_data as $parent_rel){
                                    if(!$raw->$field_name){
                                        $test[$h->field_name] = $raw->$field_name;
                                    } else {
                                        if($raw->$field_name == $parent_rel->id){
                                            if(isset($parent_rel->$name)){
                                                $d = $parent_rel->$name;
                                            }
                                            $test[$h->field_name] = $d;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else if(explode('#',$h->input_type)[0] == 'Child'){
                        $name = explode('#',$h->relate_to)[1];
                        $this_head_child = DB::table('master_table_structures')->where('table_id',explode('.',$h->relate_to)[2])->get();
                        foreach($this_head_child as $head_child){
                            if($head_child->relate_to != ''){
                                if(explode('#',$h->input_type)[1] == $head_child->field_name){
                                    $relate_table = DB::table('master_parent_child')->where('index_id',explode('#',$h->relate_to)[0])->first();
                                    $childs = DB::table($relate_table->relate_to)->get();
                                    $this_child_rel = DB::table('master_relation')->where('relation_id',$head_child->relate_to)->first();
                                    $refer_to = $this_child_rel->refer_to;
                                    $this_child_data = DB::table($this_child_rel->table_name_to)->get();
                                    // dd($childs,$this_child_data);
                                    foreach($childs as $ch){
                                        foreach($this_child_data as $child_rel){
                                            if(!$raw->$field_name){
                                                $test[$h->field_name] = $raw->$field_name;
                                            } else {
                                                if($ch->id == $raw->$field_name){
                                                    $temp_ = $relate_table->field_name;
                                                    // dd($ch->$temp_,$ch->$name,$this_child_data,$refer_to);
                                                    if($ch->$name == $child_rel->id){
                                                        $d = $child_rel->$refer_to;
                                                        // dd($ch->$name,$child_rel->id,$refer_to,$d);
                                                        $test[$h->field_name] = $d;
                                                    }
                                                    // else {
                                                    //     dd($child_rel->id);
                                                    //     $test[$h->field_name] = $child_rel->id;
                                                    // }
                                                }
                                            }
                                        }
                                    }
                                }
                            } else {
                                if($raw->$field_name!=''||$raw->$field_name!=NULL){
                                    if($raw->$field_name == $head_child->id){
                                        $name = explode('#',$h->relate_to)[1];
                                        $test[$h->field_name] = $head_child->$name;
                                    }
                                } else {
                                    $test[$h->field_name] = $raw->$field_name;
                                }
                            }
                        }
                    }
                    else if($h->relation === '1'){
                        $parent_key = $result;
                        foreach($parent_key as $index => $key){
                            if($h->relate_to == $index){
                                foreach($relation as $rel){
                                    if($rel->relation_id == $index){
                                        $refer_to = $rel->refer_to;
                                        foreach($result[$index] as $sel){
                                            if($raw->$field_name){
                                                if($sel->id == $raw->$field_name){
                                                    $test[$h->field_name] = $sel->$refer_to;
                                                }
                                            } else {
                                                $test[$h->field_name] = '';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else if($h->input_type == 'Today Date'){
                        $test[$h->field_name] = date('Y-m-d', strtotime($raw->created_at));
                        $tgl = $h->field_name;
                    }
                    else if($h->input_type == 'Longtext'){
                        $test[$h->field_name] = $raw->$field_name;
                    }
                    else if($h->input_type == 'File'){
                        if($raw->$field_name){
                            $test[$h->field_name] = $raw->$field_name;
                        } else {
                            $test[$h->field_name] = NULL;
                        }
                    }
                    else{
                        if($h->relate_to){
                            $data_ = ['parent' => MasterCustomer::orderBy('customer_name','ASC')->get(), 'child' => MasterCustomerBranch::orderBy('customer_id','ASC')->orderBy('customer_branch','ASC')->get()];
                            if($h->relate_to == 'Customers#Parent'){
                                foreach($data_['parent'] as $parent){
                                    if($raw->$field_name == $parent->id){
                                        $test[$h->field_name] = $parent->customer_name;
                                    }
                                }
                            }else if($h->relate_to == 'Customers#Child'){
                                foreach($data_['child'] as $child){
                                    if($raw->$field_name == $child->id){
                                        $test[$h->field_name] = $child->customer_branch;
                                    }
                                }
                            }
                        }else{
                            // if($h->field_name == 'created_at'){
                            //     $test[$h->field_name] = $raw->created_at->format('Y-m-d');
                            // } else {
                                $test[$h->field_name] = $raw->$field_name;
                            // }
                        }
                    }
                }
                $array_[$idx] = $test;
            }
            $data_arr = array();
            $collection = new Collection();
            if($select->extend == '1'){
                // $data_header[] = ['field_name' => 'index_id', 'field_description' => 'ID', 'can_copy' =>'1'];
                $collection->push((object)['field_name' => 'index_id', 'field_description' => 'ID', 'type' => $he->input_type, 'can_copy' =>'1']);
            }
            foreach($header as $he){
                // $data_header[] = ['field_name' => $he->field_name, 'field_description' => $he->field_description, 'can_copy' =>$he->can_copy];
                $collection->push((object)['field_name' => $he->field_name, 'field_description' => $he->field_description, 'type' => $he->input_type, 'can_copy' =>$he->can_copy]);
            }
            if($select->status == '1'){
                // $data_header[] = ['field_name' => 'status_report', 'field_description' => 'Status', 'can_copy' =>'1'];
                $collection->push((object)['field_name' => 'status_report', 'field_description' => 'Status', 'type' => $he->input_type, 'can_copy' =>'1']);
            }
            $collect_header = $collection;
            // dd(request()->start_date);
            if(request()->start_date != 'null'){
                $start_date = strtotime(request()->start_date);
                $end_date = strtotime(request()->end_date);
                $selected_arr = array();
                foreach ($array_ as $key => $val) {
                    foreach($collect_header as $col){
                        $selected_arr[] = $key;
                    }
                }
                $a = array_unique($selected_arr);
                foreach ($a as $key) {
                    $data_arr[] = $array_[$key];
                }
                $array_data = array_filter($data_arr, function($var) use ($start_date, $end_date, $tgl) {
                    $evtime = strtotime($var[$tgl]);
                    return $evtime <= $end_date && $evtime >= $start_date;
                });
            }else{
                $array_data = $array_;
            }
        }

        // dd($array_data,$array_,$this_parent_data,$this_parent_rel,$data_header,$collect_header);
        if($array_data){
            return response()->json([
                'success'   => true,
                'message'   => 'Data',
                'data'      => [
                    'forms'=>$array_data,
                    'headers'=>$header
                ]
            ]);
        }
        return response()->json([
            'success'   => true,
            'message'   => 'Data',
            'data'      => 'cannot find data'
        ]);
    }

    // public function generate_report(Request $request, $name)
    // {
    //     $filtered = array();
    //     $user = $request->user;
    //     $users = User::where('id',$user)->first();
    //     /** Initializing variable
    //      * Variable [a] for filter data by user
    //      * variable [b] for filter data by field name
    //      * variable [date] for label date selected title of report
    //      * variable [date_filter] for filter data by created at
    //      */
    //     if(auth()){
    //         $user_id = auth()->user()->id;
    //     }
    //     $getusers = DB::table('users')
    //         ->join($name, 'users.id', '=', $name.".created_by")
    //         ->select('users.*')
    //         ->groupBy($name.".created_by")
    //         ->get();
    //     $a = ''; $b = ''; $date = ''; $date_filter = '';$start_date = '';$end_date = '';
    //     $select = DB::table('master_tables')->where('name',$name)->first();
    //     $header = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->get();
    //     $table_name = $select->description;
    //     // looping selection and title for created at filter
    //     if(!is_null($request->start_date) && !is_null($request->end_date)){
    //         $date = "Periode ".$request->start_date." to ".$request->end_date;
    //         $date_filter = " AND (".$name.".created_at BETWEEN '".$request->start_date."' AND '".$request->end_date."')";
    //     }

    //     // looping and selection data for user filter
    //     if($user){
    //         $filtered[] = "User`~>`".auth()->user()->name;
    //         $a = " AND ".$name.".created_by = '".$user."'";
    //     }

    //     // looping and selection for field filter
    //     if($request->check_array){                                  // check is some field checked
    //         for($i = 0; $i < count($request->check_array);$i++){    // loop data from checklist input
    //             foreach($request->data as $index => $d){            // looping data from form input
    //                 if($index == $request->check_array[$i]){        // fetching data checklist input & form input
    //                     $select2 = DB::table('master_table_structures')->where('table_id',$select->id)->where('field_name',$request->check_array[$i])->first();
    //                     $filtered[] = $select2->field_description."`~>`".$d;    // for title
    //                     $b .= " AND ".$request->check_array[$i]." = '".$d."'";  // add selector
    //                 } else {                                        // exception for loop data where field is date format
    //                     $select2 = DB::table('master_table_structures')->where('table_id',$select->id)->where('field_name',$request->check_array[$i])->first();
    //                     if(str_contains($index,$request->check_array[$i])){
    //                         if(str_contains($index,'start_date#')){
    //                             $start_date .= $d;                  // start date of field filter
    //                         } else {
    //                             $end_date .= $d;                    // end date of field filter
    //                             $b .= " AND (".$request->check_array[$i]." BETWEEN '".$start_date."' AND '".$end_date."')"; // add selector field date type
    //                             $filtered[] = $select2->field_description."`~>`".$start_date." to ".$end_date;              // for title
    //                             $start_date = '';$end_date = '';    // reset the date filter
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     $query = "SELECT * FROM users JOIN $name ON users.id = $name.created_by WHERE $name.`status` = 1 $a $b $date_filter;"; // the query selector
    //     $data =  DB::select($query);
    //         // dd($query,$name,$filtered,$date_filter,$request);

    //     return Inertia::render('Apps/Reports/Show', [
    //         'user_role'     => strtolower($users->getRoleNames()),
    //         'table'         => $name,
    //         'csrfToken'     => csrf_token(),
    //         'table_name'    => $table_name,
    //         'user_id'       => $user_id,
    //         'headers'       => $header,
    //         'data'          => $data,
    //         'date'          => $date,
    //         'users'         => $getusers,
    //         'filters'       => $filtered,
    //         'selected_user' => $request->user,
    //     ]);
    // }

    public function export(Request $request,$name) {
        $filtered = array();
        $user = $request->user;
        $users = User::where('id',$user)->first();
        // dd($user);
        /** Initializing variable
         * Variable [a] for filter data by user
         * variable [b] for filter data by field name
         * variable [date] for label date selected title of report
         * variable [date_filter] for filter data by created at
         */
        $a = ''; $b = ''; $date = ''; $date_filter = '';$start_date = '';$end_date = '';
        $select = DB::table('master_tables')->where('name',$name)->first();
        $header = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->get();
        $table_name = $select->description;
        // looping selection and title for created at filter
        if(!is_null($request->start_date) && !is_null($request->end_date)){
            $date = "Periode ".$request->start_date." to ".$request->end_date;
            $date_filter = " AND (".$name.".created_at BETWEEN '".$request->start_date."' AND '".$request->end_date."')";
        }

        // looping and selection data for user filter
        if($user){
            $filtered[] = "User`~>`".auth()->user()->name;
            $a = " AND ".$name.".created_by = '".$user."'";
        }

        // looping and selection for field filter
        if($request->check_array){                                  // check is some field checked
            for($i = 0; $i < count($request->check_array);$i++){    // loop data from checklist input
                foreach($request->data as $index => $d){            // looping data from form input
                    if($index == $request->check_array[$i]){        // fetching data checklist input & form input
                        $select2 = DB::table('master_table_structures')->where('table_id',$select->id)->where('field_name',$request->check_array[$i])->first();
                        $filtered[] = $select2->field_description."`~>`".$d;    // for title
                        $b .= " AND ".$request->check_array[$i]." = '".$d."'";  // add selector
                    } else {                                        // exception for loop data where field is date format
                        $select2 = DB::table('master_table_structures')->where('table_id',$select->id)->where('field_name',$request->check_array[$i])->first();
                        if(str_contains($index,$request->check_array[$i])){
                            if(str_contains($index,'start_date#')){
                                $start_date .= $d;                  // start date of field filter
                            } else {
                                $end_date .= $d;                    // end date of field filter
                                $b .= " AND (".$request->check_array[$i]." BETWEEN '".$start_date."' AND '".$end_date."')"; // add selector field date type
                                $filtered[] = $select2->field_description."`~>`".$start_date." to ".$end_date;              // for title
                                $start_date = '';$end_date = '';    // reset the date filter
                            }
                        }
                    }
                }
            }
        }
        // dd($request);
        $query = "SELECT * FROM users JOIN $name ON users.id = $name.created_by WHERE $name.`status` = 1 $a $b $date_filter;"; // the query selector

        return Excel::download(new FilterExport([
            'table_name'    => $table_name,
            'headers'       => $header,
            'data'          => DB::select($query)
        ]), $table_name.$request->start_date.' -'.$request->end_date.'.xlsx');
    }
}

