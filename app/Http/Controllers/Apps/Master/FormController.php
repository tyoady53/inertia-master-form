<?php

namespace App\Http\Controllers\Apps\Master;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\master_table_structure;
use App\Models\MasterAssignment;
use App\Models\MasterCustomer;
use App\Models\MasterCustomerBranch;
use App\Models\MasterParentChild;
use App\Models\MasterTable;
use App\Models\PublicModel;
use Spatie\Permission\Models\Permission;

class FormController extends Controller
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
        if($a){
            $form_access = DB::table('master_tables')->whereIn('name',$a)->get();
        }else{
            $form_access = '';
        }

        return Inertia::render('Apps/Forms/Index', [
            'form_accesses'   => $form_access,
        ]);
    }

    public function create()
    {
        $roles = Role::where('name','!=','superadmin')->get();
        return Inertia::render('Apps/Forms/Create', [
            'roles' => $roles,
        ]);
    }

    public function create_form(Request $request)
    {
        $user_id = auth()->user()->id;
        $carbon         = Carbon::now();
        $table_name     = str_replace(array(' ', '-', ',', '.', '/'),'',strtolower($request->name));
        $index          = 'form-'.$table_name.'.index';
        $create         = 'form-'.$table_name.'.create';
        $edit           = 'form-'.$table_name.'.edit';
        $delete         = 'form-'.$table_name.'.delete';
        $group_name     = "-";
        $base          = "id int(11) NOT NULL AUTO_INCREMENT, created_at timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, updated_at timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
         created_by int(11), updated_by int(11), status varchar(1) NOT NULL, ";

        if($request->extend){
            $extend = '1';
            $base .= "index_id varchar(9),";
        }else{
            $extend = '0';
        }
        if($request->status){
            $status = '1';
            $base .= "status_report varchar(255),";
        }else{
            $status = '0';
        }
        
        if($request->customer){
            $customer = '1';
            $base .= "customer_id varchar(255),customer_branch varchar(255),";
            // master_table_structure::create(['name' => $index,   'guard_name' => 'web'])
        }else{
            $customer = '0';
        }
        if($request->clipboard){
            $clipboard = '1';
        }else{
            $clipboard = '0';
        }
        $tables_create = MasterTable::create([
            'group'         => '-',
            'name'          => $table_name,
            'description'   => $request->name,
            'is_show'       => '1',
            'created_by'    => $user_id,
            'updated_by'    => $user_id,
            'extend'        => $extend,
            'status'        => $status,
            'use_customer'  => $customer,
            'use_clipboard' => $clipboard,
        ]);
        if($request->customer){
            master_table_structure::create(['table_id' => $tables_create->id,   'field_name' => 'customer_id', 'field_description' => 'Customer Name', 'is_show' => '1', 'data_type' => 'varchar(255)', 'relation'=>'0','relate_to' => 'Customers#Parent', 'input_type'=>'Text', 'required' => 'required', 'sequence_id' => '1', 'created_by' => $user_id]);
            master_table_structure::create(['table_id' => $tables_create->id,   'field_name' => 'customer_branch', 'field_description' => 'Customer Branch', 'is_show' => '1', 'data_type' => 'varchar(255)', 'relation'=>'0','relate_to' => 'Customers#Child', 'input_type'=>'Text', 'required' => 'required', 'sequence_id' => '2', 'created_by' => $user_id]);
        }
        $query ="CREATE TABLE $table_name (".$base."PRIMARY KEY (`id`) USING BTREE)ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        DB::statement($query);

        $input_index    = Permission::create(['name' => $index,   'guard_name' => 'web']);
        $input_create   = Permission::create(['name' => $create,  'guard_name' => 'web']);
        $input_edit     = Permission::create(['name' => $edit,    'guard_name' => 'web']);
        $create_delete  = Permission::create(['name' => $delete,  'guard_name' => 'web']);

        for($i = 0; $i < count($request->roles); $i++){
            $role_data = Role::where('name',$request->roles[$i])->first();
            DB::table('role_has_permissions')->insert(['permission_id'=>$input_index->id , 'role_id'=>$role_data->id]);
            for($c = 0; $c < count($request->create); $c++){
                if($request->roles[$i] == explode('.', $request->create[$c])[0]){
                    DB::table('role_has_permissions')->insert(['permission_id'=>$input_create->id , 'role_id'=>$role_data->id]);
                }
            }
            for($e = 0; $e < count($request->edit); $e++){
                if($request->roles[$i] == explode('.', $request->create[$e])[0]){
                    DB::table('role_has_permissions')->insert(['permission_id'=>$input_edit->id , 'role_id'=>$role_data->id]);
                }
            }
            for($d = 0; $d < count($request->delete); $d++){
                if($request->roles[$i] == explode('.', $request->create[$d])[0]){
                    DB::table('role_has_permissions')->insert(['permission_id'=>$create_delete->id , 'role_id'=>$role_data->id]);
                }
            }
        }
        DB::table('role_has_permissions')->insert(['permission_id'=>$input_index->id , 'role_id'=>1]);

        return redirect()->route('apps.master.forms.index');
    }

    public function add_column(Request $request){
        if($request->data_type == 'Checklist'){
            $table = DB::table('master_tables')->where('id',$request->table_to)->first();
            $relate_to = $table->name.'#'.$request->field_to;
        } else {
            $relate_to = '';
        }
        $field_name = str_replace(array(' ', '-', ',', '.', '/'), '',strtolower($request->name));
        $table_name = $request->table;
        $data_type      = DB::table('master_datatype')->where('name',$request->data_type)->first();
        $table_selected = DB::table('master_tables')->where('name',$table_name)->first();
        $master_table_structure = master_table_structure::where('table_id',$table_selected->id)->orderBy('sequence_id','DESC')->first();
        $structure = new master_table_structure;
        $structure->table_id            = $table_selected->id;
        $structure->field_name          = $field_name;
        $structure->field_description   = $request->name;
        $structure->is_show             = '1';
        $structure->data_type           = $data_type->data_type;
        $structure->field_name          = $field_name;
        $structure->relation            = '0';
        $structure->input_type          = $request->data_type;
        $structure->sequence_id         = $master_table_structure->sequence_id + 1;
        $structure->relate_to           = $relate_to;
        $structure->created_by          = auth()->user()->id;
        $structure->save();
        if(str_contains($data_type->data_type, 'Text')||str_contains($data_type->data_type, 'varchar')){
            $insert_type = $data_type->data_type." CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL";
        }else{
            $insert_type = $data_type->data_type;
        }

        $query = "ALTER TABLE `$table_name` ADD `$field_name` $insert_type";

        DB::statement($query);

        return redirect()->route('apps.master.forms.manage',$table_name);
    }

    public function set_relation(Request $request)
    {
		$table			= $request->table;
		$field_name		= $request->field_from;
		$relate_to_table= $request->relate_table;

		$relate_to_field= $request->refer_to;
        $select = DB::table('master_tables')->where('name',$table)->first();
        $select2 = DB::table('master_tables')->where('id',$relate_to_table)->first();
        $table_from_desc= DB::table('master_tables')->where('name',$table)->first();
        $table_to_desc  = DB::table('master_tables')->where('id',$relate_to_table)->first();
        $field_from_desc= DB::table('master_table_structures')->where('table_id',$select->id)->where('field_name',$field_name)->first();
        $refer_to_desc  = DB::table('master_table_structures')->where('table_id',$select2->id)->where('field_name',$relate_to_field)->first();
        $base_relation_id = 'R.'.$select->id;
        $relation_lastindex = DB::table('master_table_structures')->whereRaw('LEFT(relate_to,'.strlen($base_relation_id).') = "'.$base_relation_id.'"')->latest()->first();
        if($relation_lastindex){
            $relation_id = $base_relation_id.'.'.(int)explode('.',$relation_lastindex->relate_to)[2]+1;
        } else {
            $relation_id = $base_relation_id.'.1';
        }
        // dd($relation_id);

		$insert1 = DB::statement("UPDATE master_table_structures SET relation='1',relate_to='$relation_id' WHERE table_id='$select->id' AND field_name='$field_name';");
		// $insert2 = DB::statement("UPDATE master_table_structures SET relation='1' WHERE table_id='$select2->id' AND field_name='$relate_to_field';");
		$insert3 = DB::statement("INSERT INTO master_relation (table_name_from,field_from,table_name_to,refer_to,field_from_desc,table_from_desc,table_to_desc,refer_to_desc,relation_id)
            VALUES ('$table','$field_name','$table_to_desc->name','$relate_to_field','$field_from_desc->field_description','$table_from_desc->description','$table_to_desc->description','$refer_to_desc->field_description','$relation_id');");
		if($insert1){
			return redirect()->route('apps.master.forms.manage',$table);
		}
    }

    public function set_parent(Request $request)
    {
		$table			    = $request->table;
		$field_name		    = $request->field_name;
		$child              = $request->child;
		$data_from_table    = $request->data_from_table;
		$parent_references  = $request->parent_reference;
		$child_data         = $request->child_data;
        $child_reference    = master_table_structure::where('id', $child_data)->first();
        $parent_reference   = master_table_structure::where('id', $parent_references)->first();
        $select_table       = DB::table('master_tables')->where('name',$table)->first();
        $table_data         = DB::table('master_tables')->where('id',$data_from_table)->first();
        $parent_table       = DB::table('master_table_structures')->where('table_id',$parent_reference->table_id)->where('relation','1')->first();
        $parent_related     = DB::table('master_relation')->where('field_from',$parent_reference->field_name)->where('table_name_from',$table_data->name)->first();
        $child_input    = 'Child#'.$child_reference->field_name;
        $parent_input   = 'Parent#'.$parent_reference->field_name;
        $base_child     = 'C.'.$select_table->id.'.'.$child_reference->table_id;
        $base_parent    = 'P.'.$select_table->id.'.'.$child_reference->table_id;
        $parent_lastindex = DB::table('master_table_structures')->whereRaw('LEFT(relate_to,'.strlen($base_parent).') = "'.$base_parent.'"')->orderByRaw('RIGHT(SUBSTRING_INDEX(relate_to,"#", 1),1)')->first();
        if($parent_lastindex){
            $input_indexP = $base_parent.'.'.(int)explode('.',$parent_lastindex->relate_to)[3]+1;
        } else {
            $input_indexP = $base_parent.'.1';
        }
        $child_lastindex = DB::table('master_table_structures')->whereRaw('LEFT(relate_to,'.strlen($base_child).') = "'.$base_child.'"')->orderByRaw('RIGHT(SUBSTRING_INDEX(relate_to,"#", 1),1)')->first();
        if($child_lastindex){
            $input_indexC = $base_child.'.'.(int)explode('.',$child_lastindex->relate_to)[3]+1;
        } else {
            $input_indexC = $base_child.'.1';
        }
        if($parent_table){
            $parent_relate  = $input_indexP.'#'.$parent_related->refer_to;
        } else {
            $parent_relate  = $input_indexP.'#'.$parent_reference->field_name;
        }
        $child_relate   = $input_indexC.'#'.$child_reference->field_name;

        $child_save = master_table_structure::where('field_name', $child)->where('table_id',$select_table->id) //update to selected child
                ->update([
                    'input_type'    => $child_input,
                    'relate_to'     => $child_relate
            ]);
        $parent = master_table_structure::where('field_name', $field_name)->where('table_id',$select_table->id) //update to selected parent
                ->update([
                    'input_type'    => $parent_input,
                    'relate_to'     => $parent_relate
            ]);
        MasterParentChild::create(['index_id' => $input_indexP,   'relate_to' => $table_data->name, 'field_name' => $parent_reference->field_name]);
        MasterParentChild::create(['index_id' => $input_indexC,   'relate_to' => $table_data->name, 'field_name' => $child_reference->field_name]);
		if($child_save){
			return redirect()->route('apps.master.forms.manage',$table);
		}
    }

    public function show(Request $request, $name)
    {
        $use_parent = '0';
        $data_ = array();
        $result = array();
        $public_model = new PublicModel();
        if(auth()){
            $user_id = auth()->user()->id;
        }
        $user = User::where('id',$user_id)->first();
        $request_name = request()->segment(count(request()->segments()));
        $a = '';

        $permissions = $user->getPermissionsViaRoles();
        if($request_name == 'manage'){
            $role_request = 'manage';
        } else {
            if($request_name == 'add_data'){
                $role_request = 'create';
            } else {
                $role_request = 'index';
            }
            for ($j = 0; $j < $permissions->count(); $j++){
                if(str_contains($permissions[$j]['name'], $role_request)){
                    $a .= $permissions[$j]['name'].', ';
                }
            }
        }
        $select_field = '';$form = ''; $relate = '';$table_to_check = [];$parent = [];$child = [];
        $select = $public_model->get_single_data_single_filter('master_tables','name',$name);//DB::table('master_tables')->where('name',$name)->first();
        $table_name = $select->description;
        $title  = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->get();
        // dd($title->count());
        $header = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->orderBy('sequence_id','asc')->get();
        if ($title->count() > 0){
            $relation = $public_model->get_table_single_filter('master_relation','table_name_from',$name); //DB::table('master_relation')->whereRaw('')->get();
			foreach ($title as $index => $t){
                $select_field .= $t->field_name.',';
                // if($t->relate_to != ''){
                //     // if($t->relate_to != 'Customers#Parent'){
                //     //     dd($t->relate_to);
                //     // }
                //     if($t->relate_to != 'Customers#Child' || $t->relate_to != 'Customers#Parent'){
                //         if(str_contains($t->input_type, 'Child')){
                //             $relate_table = DB::table('master_parent_child')->where('index_id',explode('#',$t->relate_to)[0])->first();
                //             if($relate_table){
                //                 $check_data = DB::table($relate_table->relate_to)->get();
                //                 foreach ($check_data as $chk_data){
                //                     $child[$t->input_type][$relate_table->field_name] = $check_data;
                //                 }
                //             }
                //         } else if (str_contains($t->input_type, 'Parent')){
                //             $relate_table = DB::table('master_parent_child')->where('index_id',explode('#',$t->relate_to)[0])->first();
                //             if($relate_table){
                //                 $check_data = DB::table($relate_table->relate_to)->get();
                //                 foreach ($check_data as $chk_data){
                //                     $parent[$t->input_type][$relate_table->field_name] = $check_data;
                //                 }
                //             }
                //         } else {
                //             $relations = $t->relate_to;
                //             $relate_table = explode('#',$relations);
                //             $field_check = $relate_table[1];
                //             $check_data = DB::table($relate_table[0])->get([$field_check]);
                //             foreach ($check_data as $chk_data){
                //                 $table_to_check[$t->input_type][$field_check] = $check_data;
                //             }
                //         }
                //     }
                // }
                if($relation->count() > 0){
                    foreach ($relation as $rel){
                        if($rel->relation_id == $t->relate_to){
                            // $result[] = [$rel->relation_id => DB::table($rel->table_name_to)->get(),"field_from" => $rel->field_from];
                            $result[$rel->relation_id] = DB::table($rel->table_name_to)->get();
                        }
                    }$relate = 'yes';
                } else {
                    $relate = 'no';
                }
			}
			$selected = 'id,created_at,'.substr($select_field, 0,-1);
            if($select->extend){
                if(str_contains(strtolower($user->getRoleNames()), 'staff')){
                    $form = DB::table($name)
                        ->join('master_assignment', $name.'.index_id', '=', "master_assignment.index_id")
                        ->select($name.'.*')
                        ->where('master_assignment.user_id',$user_id)
                        ->union(DB::table($name)->where('created_by',$user_id))->orderBy('id','DESC')
                        ->get();
                } else {
                    $form = DB::table($name)->selectRaw('index_id,'.$selected)->where('status','1')->latest()->get();
                }
            } else {
                if(str_contains(strtolower($user->getRoleNames()), 'staff')){
                    $form = DB::table($name)->selectRaw($selected)->where('created_by',$user_id)->where('status','1')->latest()->get();
                } else {
                    if($name == 'master_customers'){
                        $form = DB::table($name)->selectRaw($selected)->orderBy('customer_name','ASC')->get();
                    } else if($name == 'master_customer_branches'){
                        $form = DB::table($name)->join('master_customers', $name.'.customer_id', '=', "master_customers.id")->orderBy('customer_name','ASC')->orderBy('outlet_id','ASC')->get();
                    } else {
                        $form = DB::table($name)->latest()->get();
                    }
                }
            }
		} else {
            $form = DB::table($name)->latest()->get();
        }
        $checklist_data = array();
        $parent_count = 0;
        $parent_data  = array();
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
            if($he->relate_to == 'Customers#Parent'){
                $use_parent = '1';
            }
        }
        if($name == 'master_customer_branches' || $use_parent == '1'){
            $data_ = ['parent' => MasterCustomer::orderBy('customer_name','ASC')->get(), 'child' => MasterCustomerBranch::get()];
        }
        // dd($result);
        $field  = DB::table('master_datatype')->get();
        $show_table  = DB::table('master_tables')->where('is_show',1)->get();
        $structures  = DB::table('master_table_structures')->where('is_show',1)->get();
        if($role_request == 'manage'){
            return Inertia::render('Apps/Forms/Manage/Manage', [
                'table'         => $name,
                'create_data'   => 'form-'.$name.'.create',
                'edit_data'     => 'form-'.$name.'.edit',
                'delete_data'   => 'form-'.$name.'.delete',
                'csrfToken'     => csrf_token(),
                'table_name'    => $table_name,
                'title'         => $title,
                'fields'        => $field,
                'headers'       => $header,
                'forms'         => $form,
                'checklist'     => $table_to_check,
                'child'         => $child,
                'parent'        => $parent,
                'show_table'    => $show_table,
                'relation'      => $relation,
                'related'       => $result,
                'relate'        => $relate,
                'avail_tables'  => DB::table('master_tables')->where('is_show',1)->where('name','<>',$name)->get(),
                'structures'    => $structures,
                'parent_data'   => $parent_data,
                'child_data'    => $child_data,
                'parent_count'  => $parent_count,
            ]);
        }else {
            if(str_contains($a, $name)){
                switch($request_name){
                    case 'show':
                        return Inertia::render('Apps/Forms/Show', [
                            'table'         => $name,
                            'create_data'   => 'form-'.$name.'.create',
                            'edit_data'     => 'form-'.$name.'.edit',
                            'delete_data'   => 'form-'.$name.'.delete',
                            'csrfToken'     => csrf_token(),
                            'table_name'    => $select,
                            'title'         => $title,
                            'fields'        => $field,
                            'headers'       => $header,
                            'forms'         => $form,
                            'checklist'     => $table_to_check,
                            'child'         => $child,
                            'parent'        => $parent,
                            'show_table'    => $show_table,
                            'relation'      => $relation,
                            'related'       => $result,
                            'relate'        => $relate,
                            'parentData'    => $parent_data,
                            'child_data'    => $child_data,
                            'parent_count'  => $parent_count,
                            'checklist_data'=> $checklist_data,
                            'today'         => Carbon::today(),
                            'extend'        => $select->extend,
                            'status_report' => $select->status,
                            'select_status' => DB::table('master_status_report')->orderBy('id','ASC')->get(),
                            'divisions'     => DB::table('master_divisions')->where('id','!=','1')->where('id','!=',auth()->user()->division)->get(),
                            'users'         => DB::table('users')->where('id','!=',auth()->user()->id)->get(),
                            'data'          => $data_,
                        ]);
                        break;
                    case 'add_data' :
                        return Inertia::render('Apps/Forms/Show', [
                            'group'         => DB::table('master_tablegroup')->get(),
                            'table'         => $name,
                            'create_data'   => 'form-'.$name.'.create',
                            'edit_data'     => 'form-'.$name.'.edit',
                            'delete_data'   => 'form-'.$name.'.delete',
                            'table_name'    => $table_name,
                            'title'         => $title,
                            'fields'        => $field,
                            'headers'       => $header,
                            'forms'         => $form,
                            'checklist'     => $table_to_check,
                            'child'         => $child,
                            'parent'        => $parent,
                            'show_table'    => $show_table,
                            'relation'      => $relation,
                            'related'       => $result,
                            'relate'        => $relate,
                        ]);
                        break;
                }
            }
            return Inertia::render('Apps/Forbidden', [
            ]);
        }
    }

    public function create_data(Request $request){
        // dd($request);
        $generated = '';
        $table          = $request->table;
        $select         = DB::table('master_tables')->where('name',$request->table)->first();
        $table_head     = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->get();
        $last_data      = DB::table($table)->latest('created_at')->first();
        $now            = Carbon::now()->toDateTimeString();
        $auth           = auth()->user()->id;
		$select_field	= 'created_at,updated_at,created_by,updated_by,status,';
		$values	        = '"'.$now.'","'.$now.'",'.$auth.','.$auth.',"1",';
        if($select->extend=='1'){
            $select_field  .= 'index_id,';
            if($request->create_ticket){
                if($last_data){
                    if(substr($last_data->index_id,0,5)!=date("ym").$select->id){
                        $generated = date("ym").$select->id.'0001';
                        $values .= $generated.',';
                    }else{
                        $generated = $last_data->index_id+1;
                        $values .= $generated .',';
                    }
                } else {
                    $generated = date("ym").$select->id.'0001';
                    $values .= $generated.',';
                }
            } else {
                $values .= "'',";
            }
        }

        foreach ($table_head as $t){
            $fields = $t->field_name;
            $select_field .= $t->field_name.',';
            if($t->input_type == 'File'){
                $file= $request->file($fields)->store('public/'.$table.'-'.$fields);
                $values .= "'".str_replace('public/', '',$file)."',";
            } else if($t->input_type == 'Checklist'){
                if($request->$fields == ''){
                    $values .= "NULL,";
                } else {
                    $vehicleString = implode(",", $request->$fields);
                    $values .= "'".$vehicleString."',";
                }
            } else if (str_contains($t->input_type, 'Parent')){
                $select = explode('#',$t->input_type)[1];
                $relate_table = DB::table('master_parent_child')->where('index_id',explode('#',$t->relate_to)[0])->first();
                $parent_data = DB::table($relate_table->relate_to)->where($select,$request->$fields)->first();
                $values .= "'".$parent_data->id."',";
            } else {
                $values .= "'".$request->$fields."',";
            }
        }
        if($request->status_report){
            $select_field .= "status_report,";
            $values .= "'".$request->status_report."',";
        }
        $selected = substr($select_field, 0,-1);
        $insert_value = substr($values, 0,-1);
        // dd("INSERT INTO $table ($selected) VALUES ($insert_value)");
		$insert = DB::statement("INSERT INTO $table ($selected) VALUES ($insert_value);");
        if($request->assignSelector){
            if($request->assignSelector == 'division'){
                $get_user = User::where('division', $request->assign_to)->get();
                foreach($get_user as $user){
                    MasterAssignment::create(['index_id' => $generated,   'user_id' => $user->id]);
                }
            } else if ($request->assignSelector == 'staff'){
                MasterAssignment::create(['index_id' => $generated,   'user_id' => $request->assign_to]);
            }
        }
		if($insert){
			return redirect()->route('apps.master.forms.show',$table);
		}
    }

    public function update_data(Request $request){
        $table			= $request->table;
		$edit_id		= $request->data_id;
        $select         = DB::table('master_tables')->where('name',$request->table)->first();
        $table_head     = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->get();
		$select_field	= '';
		$values	        = '';
		if (count($table_head) > 0){
			foreach ($table_head as $t){
                $fields = $t->field_name;
				if($t->input_type == 'File'){
                    if($request->file($fields)){
                        $file= $request->file($fields)->store($table.'-'.$fields);
                        $values .= $t->field_name."='".$file."',";
                    }
                } else if($t->input_type == 'Checklist'){
                    if($request->$fields == ''){
                        $values .= $t->field_name."=NULL,";
                    } else {
                        $vehicleString = implode(",", $request->$fields);
                        $values .= $t->field_name."='".$vehicleString."',";
                    }
                } else {
                    $values .= $t->field_name."='".$request->$fields."',";
                }
			}
			$selected = substr($values, 0,-1);
		}
		$insert = DB::statement("UPDATE $table SET $selected WHERE id='$edit_id';");
		if($insert){
			return redirect()->route('apps.master.forms.show',$table);
		}
    }

    public function delete_data($name,$id){
		$table_head		= DB::statement("DELETE FROM $name WHERE id='$id';");
		$table_head		= DB::statement("UPDATE $name SET status='0' WHERE id='$id';");
        if($table_head){
            return redirect()->route('apps.master.forms.show',$name);
        }
	}
}
