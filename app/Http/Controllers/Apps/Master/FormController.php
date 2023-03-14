<?php

namespace App\Http\Controllers\Apps\Master;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Extend;
use App\Models\master_table_structure;
use App\Models\MasterAssignment;
use App\Models\MasterCustomer;
use App\Models\MasterCustomerBranch;
use App\Models\MasterParentChild;
use App\Models\MasterTable;
use App\Models\PublicModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
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
        $can_copy = '';$required = '';
        $field_name = str_replace(array(' ', '-', ',', '.', '/'), '',strtolower($request->name));
        $table_name = $request->table;
        $data_type      = DB::table('master_datatype')->where('name',$request->data_type)->first();
        $table_selected = DB::table('master_tables')->where('name',$table_name)->first();
        $master_table_structure = master_table_structure::where('table_id',$table_selected->id)->orderBy('sequence_id','DESC')->first();
        if($master_table_structure){
            $last_sequence = $master_table_structure->sequence_id;
        } else {
            $last_sequence = 0;
        }
        if($request->can_copy){
            $can_copy = 1;
        }
        if($request->required){
            $required = 'required';
        }
        $structure = new master_table_structure;
        $structure->can_copy            = $can_copy;
        $structure->required            = $required;
        $structure->table_id            = $table_selected->id;
        $structure->field_name          = $field_name;
        $structure->field_description   = $request->name;
        $structure->is_show             = '1';
        $structure->data_type           = $data_type->data_type;
        $structure->field_name          = $field_name;
        $structure->relation            = '0';
        $structure->input_type          = $request->data_type;
        $structure->sequence_id         = $last_sequence + 1;
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

    public function edit(Request $request)
    {
        // dd($request);
        $can_copy = '';$required = '';
        $data = ''; $updated_row = '';
        $selected_row = master_table_structure::where('id',$request->id)->first();
        if($selected_row->sequence_id < $request->sequence_id){
            $data = master_table_structure::where('table_id',$selected_row->table_id)->where('sequence_id','<=',$request->sequence_id)->where('sequence_id','>',$selected_row->sequence_id)->where('sequence_id','!=',$selected_row->sequence_id)->get();

        }elseif($selected_row->sequence_id > $request->sequence_id){
            $data = master_table_structure::where('table_id',$selected_row->table_id)->where('sequence_id','>=',$request->sequence_id)->where('sequence_id','<',$selected_row->sequence_id)->where('sequence_id','!=',$selected_row->sequence_id)->get();
        }
        if($data){
            if($selected_row->sequence_id < $request->sequence_id){
                foreach($data as $d){
                    master_table_structure::where('id', $d->id)->update(['sequence_id' => $d->sequence_id-1]);
                    // $updated_row .= 'Field '.$d->field_description.' with seq '.$d->sequence_id.' will updated to '.$d->sequence_id-1 .' with id '.$d->id.' #';
                }
            }elseif($selected_row->sequence_id > $request->sequence_id){
                foreach($data as $d){
                    master_table_structure::where('id', $d->id)->update(['sequence_id' => $d->sequence_id+1]);
                    // $updated_row .= 'Field '.$d->field_description.' with seq '.$d->sequence_id.' will updated to '.$d->sequence_id+1 .' with id '.$d->id.' #';
                }
            }
        }
        if($request->can_copy){
            $can_copy = 1;
        }
        if($request->required){
            $required = 'required';
        }
        $update_row = master_table_structure::where('id', $selected_row->id)->update(['sequence_id' => $request->sequence_id,'can_copy' => $can_copy,'required'=>$required,'field_description'=>$request->field_description]);

        if($update_row){
            return redirect()->route('apps.master.forms.manage',$request->table);
        }
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
        $relation = '';
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
        $form = array(); $test = array();
        $select_field = '';$raw_form = ''; $relate = '';$table_to_check = [];$parent = [];$child = [];
        $select = $public_model->get_single_data_single_filter('master_tables','name',$name);
        $table_name = $select->description;
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
                    }$relate = 'yes';
                } else {
                    $relate = 'no';
                }
			}
			$selected = 'id,created_at,'.substr($select_field, 0,-1);
            $raw_form = $this->getDataTable($name);
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
                    $relate_tableP = DB::table('master_parent_child')->where('index_id',explode('#',$he->relate_to)[0])->first();
                    $dataP = explode('#',$he->relate_to)[0];
                    $table_reference_idP = explode('.',$dataP)[2];
                    $table_reference_nameP = DB::table('master_tables')->where('id',$table_reference_idP)->first();
                    $reference_structureP = DB::table('master_table_structures')->where('table_id',$table_reference_idP)->get();
                    if($public_model->get_table_single_filter('master_relation','table_name_from',$table_reference_nameP->name)->count() > 0){
                        foreach ($reference_structureP as $chk_data){
                            $mP = DB::table('master_relation')->where('table_name_from',$relate_tableP->relate_to)->get();
                            foreach($mP as $n){
                                if($n->field_from == explode('#',$he->input_type)[1]){
                                    $zP = $n->table_name_to;
                                    $parent_data = [$dataP => DB::table($zP)->get()];
                                }
                            }
                        }
                    } else {
                        $parent_data = [$dataP => DB::table($relate_tableP->relate_to)->groupBy($relate_tableP->field_name)->get()];
                    }
                }
            }
            if(str_contains($he->input_type, 'Child')){
                $this_head_child = DB::table('master_table_structures')->where('table_id',explode('.',$he->relate_to)[2])->get();
                foreach($this_head_child as $head_child){
                    if($head_child->relate_to != ''){
                        if(explode('#',$he->input_type)[1] == $head_child->field_name){
                            $relate_table = DB::table('master_parent_child')->where('index_id',explode('#',$he->relate_to)[0])->first();
                                $data = explode('#',$he->relate_to)[0];
                                $table_reference_id = explode('.',$data)[2];
                                $table_reference_name = DB::table('master_tables')->where('id',$table_reference_id)->first();
                                $reference_structure = DB::table('master_table_structures')->where('table_id',$table_reference_id)->get();
                                // dd($parent_data, $child_data, $reference_structure);
                                if($public_model->get_table_single_filter('master_relation','table_name_from',$table_reference_name->name)->count() > 0){
                                    $child_arr = array();
                                    $m = DB::table('master_relation')->where('table_name_from',$relate_table->relate_to)->get();
                                    foreach($m as $n){
                                        if($n->field_from == explode('#',$he->input_type)[1]){
                                            $collection = new Collection();
                                            $childs = DB::table($relate_table->relate_to)->get();
                                            $z = $n->table_name_to;
                                            $field_from = $n->field_from;
                                            $refer_to = $n->refer_to;
                                            $child_rel = DB::table($z)->get();
                                            foreach($childs as $idx => $ch){
                                                $test['id'] = $ch->id;
                                                foreach($child_rel as $chr){
                                                    if($ch->$field_from == $chr->id){
                                                        foreach ($reference_structure as $chk_data){
                                                            $field_name = $chk_data->field_name;
                                                            if($field_name == explode('#',$he->input_type)[1]){
                                                                $test[$field_name] = $chr->$refer_to;
                                                            } else {
                                                                $test[$field_name] = $ch->$field_name;
                                                            }
                                                        }
                                                    }
                                                }
                                                $child_arr[$idx] = $test;
                                                $collection->push((object)[$child_arr]);
                                            }
                                        }
                                    }
                                    $child_data = $child_arr;
                                }
                        } else {
                            $relate_table = DB::table('master_parent_child')->where('index_id',explode('#',$he->relate_to)[0])->first();
                            $child_data  = DB::table($relate_table->relate_to)->get();
                        }
                    }
                }
                // if($he->relate_to != 'Customers#Child'){
                //     $this_head_child = DB::table('master_table_structures')->where('table_id',explode('.',$he->relate_to)[2])->get();
                //         foreach($this_head_child as $head_child){
                //             if(explode('#',$he->input_type)[1] == $head_child->field_name){
                //                 $relate_table = DB::table('master_parent_child')->where('index_id',explode('#',$he->relate_to)[0])->first();
                //                 $data = explode('#',$he->relate_to)[0];
                //                 $table_reference_id = explode('.',$data)[2];
                //                 $table_reference_name = DB::table('master_tables')->where('id',$table_reference_id)->first();
                //                 $reference_structure = DB::table('master_table_structures')->where('table_id',$table_reference_id)->get();
                //                 // dd($parent_data, $child_data, $reference_structure);
                //                 if($public_model->get_table_single_filter('master_relation','table_name_from',$table_reference_name->name)->count() > 0){
                //                     $child_arr = array();
                //                     $m = DB::table('master_relation')->where('table_name_from',$relate_table->relate_to)->get();
                //                     foreach($m as $n){
                //                         if($n->field_from == explode('#',$he->input_type)[1]){
                //                             $collection = new Collection();
                //                             $childs = DB::table($relate_table->relate_to)->get();
                //                             $z = $n->table_name_to;
                //                             $field_from = $n->field_from;
                //                             $refer_to = $n->refer_to;
                //                             $child_rel = DB::table($z)->get();
                //                             foreach($childs as $idx => $ch){
                //                                 $test['id'] = $ch->id;
                //                                 foreach($child_rel as $chr){
                //                                     if($ch->$field_from == $chr->id){
                //                                         foreach ($reference_structure as $chk_data){
                //                                             $field_name = $chk_data->field_name;
                //                                             if($field_name == explode('#',$he->input_type)[1]){
                //                                                 $test[$field_name] = $chr->$refer_to;
                //                                             } else {
                //                                                 $test[$field_name] = $ch->$field_name;
                //                                             }
                //                                         }
                //                                     }
                //                                 }
                //                                 $child_arr[$idx] = $test;
                //                                 $collection->push((object)[$child_arr]);
                //                             }
                //                         }
                //                     }
                //                     $child_data = $child_arr;
                //                 }
                //             }else {
                //                 $relate_table = DB::table('master_parent_child')->where('index_id',explode('#',$he->relate_to)[0])->first();
                //                 $child_data = DB::table($relate_table->relate_to)->get();
                //             }
                //         }
                //     // $relate_table = DB::table('master_parent_child')->where('index_id',explode('#',$he->relate_to)[0])->first();
                //     // $child_data  = DB::table($relate_table->relate_to)->get();
                     
                // }
                // dd($child_data);
            }
            if(str_contains($he->input_type, 'Checklist')){
                $checklist_data[explode('#',$he->relate_to)[0]] = [explode('#',$he->relate_to)[0] => $public_model->get_all_table_data(explode('#',$he->relate_to)[0]),"field_from" => explode('#',$he->relate_to)[1]];
            }
            if($he->relate_to == 'Customers#Parent'){
                $use_parent = '1';
            }
        }
        if($name == 'master_customer_branches' || $use_parent == '1'){
            $data_ = ['parent' => MasterCustomer::orderBy('customer_name','ASC')->get(), 'child' => MasterCustomerBranch::orderBy('customer_id','ASC')->orderBy('customer_branch','ASC')->get()];
        }
        if($name == 'master_customers'){
            $form = DB::table($name)->orderBy('customer_name','ASC')->get();
        } else if($name == 'master_customer_branches'){
            $form = DB::table($name)->join('master_customers', $name.'.customer_id', '=', "master_customers.id")->orderBy('customer_name','ASC')->orderBy('outlet_id','ASC')->get();
        } else{
            foreach($raw_form as $idx => $raw){
                foreach($header as $h) {
                    if($select->extend == '1'){
                        $test['index_id'] = $raw->index_id;
                    }
                    if($select->status == '1'){
                        $test['status_report'] = $raw->status_report;
                    }
                    $field_name = $h->field_name;
                    if(explode($h->input_type,'#')[0] === 'Parent'){
                        $parent_key = $parent_data[0];
                        $parent_data = $parent_data[$parent_key];
                        if(explode($h->relate_to,'#')[0] == $parent_key){
                            foreach($parent_data as $parent){
                                if($parent->id == $raw->$field_name){
                                    $test[$h->field_name] = $parent[explode($h->relate_to,'#')[1]];
                                }
                            }
                        }
                    }
                    else if(explode($h->input_type,'#')[0] === 'Child'){
                        foreach($child_data as $child){
                            if($raw->$field_name == $child->id){
                                $test[$h->field_name] = $child[explode($h->relate_to,'#')[1]];
                            }
                        }
                    }
                    else if($h->relation === '1'){
                        $parent_key = $result;
                        foreach($parent_key as $index => $key){
                            if($h->relate_to == $index){
                                // dd($result[$index],$raw->$field_name,$relation);
                                foreach($relation as $rel){
                                    if($rel->relation_id == $index){
                                        $refer_to = $rel->refer_to;
                                        foreach($result[$index] as $sel){
                                            if($sel->id == $raw->$field_name){
                                                $test[$h->field_name] = $sel->$refer_to;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else if($h->input_type == 'Today Date'){
                        $test[$h->field_name] = $h->created_at;
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
                            $test[$h->field_name] = $raw->$field_name;
                        }
                    }
                }
                $form[$idx] = $test;
            }
        }
        // dd($header,$raw_form,$form,$rel,$parent_key);
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
                'avail_tables'  => DB::table('master_tables')->where('is_show',1)->where('name','!=',$name)->get(),
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
                            'userID'        => auth()->user()->id,
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

    function getDataTable($name){
        $user_id = 1;
        // if(auth()){
        //     $user_id = auth()->user()->id;
        // }
        $user = User::where('id',$user_id)->first();
        $public_model = new PublicModel();
        $select = $public_model->get_single_data_single_filter('master_tables','name',$name);
        if($select->extend){
            if(str_contains(strtolower($user->getRoleNames()), 'staff')){
                $form = DB::table($name)
                    ->join('master_assignment', $name.'.index_id', '=', "master_assignment.index_id")
                    ->select($name.'.*')
                    ->where('master_assignment.user_id',$user_id)
                    ->union(DB::table($name)->where('created_by',$user_id))->orderBy('id','DESC')
                    ->get();
            } else {
                $form = DB::table($name)->latest()->get();
            }
        } else {
            if(str_contains(strtolower($user->getRoleNames()), 'staff')){
                $form = DB::table($name)->where('created_by',$user_id)->latest()->get();
            } else {
                $form = DB::table($name)->latest()->get();
            }
        }

        return $form;
    }

    function get_user(){
        return auth()->user()->id;
    }

    function getDataTable_API($name, $id){
        $per_page=request()->per_page;
        $result = array();
        $array_data = array();
        $array_ = array();
        $select_field = '';
        $user_id = $id;
        $user = User::where('id',$user_id)->first();
        $public_model = new PublicModel();
        $select = $public_model->get_single_data_single_filter('master_tables','name',$name);
        if($select->extend){
            if(str_contains(strtolower($user->getRoleNames()), 'staff')){
                $form = DB::table($name)
                    ->join('master_assignment', $name.'.index_id', '=', "master_assignment.index_id")
                    ->select($name.'.*')
                    ->where('master_assignment.user_id',$user_id)
                    ->union(DB::table($name)->where('created_by',$user_id))->orderBy('id','DESC')
                    ->get();
            } else {
                $form = DB::table($name)->latest()->get();
            }
        } else {
            if(str_contains(strtolower($user->getRoleNames()), 'staff')){
                $form = DB::table($name)->where('created_by',$user_id)->latest()->get();
            } else {
                $form = DB::table($name)->latest()->get();
            }
        }
        $header = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->orderBy('sequence_id','asc')->get();
        $parent_data  = array();
        $child_data   = array();
        $parent_keys  = '';
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
            $paginator = MasterCustomer::when(request()->q, function($paginator) {
                $paginator = $paginator->where('customer_name', 'like', '%'. request()->q . '%');
            })->orderBy('customer_name','ASC')->paginate($per_page);
        } else if($name == 'master_customer_branches'){
            $paginator = MasterCustomerBranch::join('master_customers', 'master_customer_branches.customer_id', '=', "master_customers.id")->when(request()->q, function($paginator) {
                $paginator = $paginator->where('master_customers.customer_name', 'like', '%'. request()->q . '%')
                    ->orWhere('customer_branch', 'like', '%'. request()->q . '%')
                    ->orWhere('outlet_id', 'like', '%'. request()->q . '%');
            })->orderBy('master_customers.customer_name','ASC')->orderBy('outlet_id','ASC')->paginate($per_page);
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
                        $nameP = explode('#',$h->relate_to)[1];
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
                                            if(isset($parent_rel->$nameP)){
                                                $d = $parent_rel->$nameP;
                                            }
                                            $test[$h->field_name] = $d;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else if(explode('#',$h->input_type)[0] == 'Child'){
                        $nameC = explode('#',$h->relate_to)[1];
                        $this_head_child = DB::table('master_table_structures')->where('table_id',explode('.',$h->relate_to)[2])->get();
                        foreach($this_head_child as $head_child){
                            if($head_child->relate_to != ''){
                                $this_child_rel = DB::table('master_relation')->where('relation_id',$head_child->relate_to)->first();
                                $childs = DB::table($relate_table->relate_to)->get();
                                if(explode('#',$h->input_type)[1] == $head_child->field_name){
                                    $relate_table = DB::table('master_parent_child')->where('index_id',explode('#',$h->relate_to)[0])->first();
                                    $refer_to = $this_child_rel->refer_to;
                                    $this_child_data = DB::table($this_child_rel->table_name_to)->get();
                                    // dd($childs,$this_child_data);
                                    foreach($childs as $ch){
                                        foreach($this_child_data as $child_rel){
                                            if(!$raw->$field_name){
                                                $test[$h->field_name] = $raw->$field_name;
                                            } else {
                                                if($ch->id == $raw->$field_name){
                                                    if($ch->$nameC == $child_rel->id){
                                                        $d = $child_rel->$refer_to;
                                                        $test[$h->field_name] = $d;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            } else {
                                $temp_data = DB::table(explode('#',$h->relate_to)[1])->get();
                                // dd($raw->$field_name);
                                if($raw->$field_name!=''||$raw->$field_name!=NULL){
                                    foreach($temp_data as $temp){
                                        if($raw->$field_name == $temp->id){
                                            $nameC = explode('#',$h->relate_to)[1];
                                            $test[$h->field_name] = $temp->$nameC;
                                        }
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
                            $test[$h->field_name] = $raw->$field_name;
                        }
                    }
                }
                $array_[$idx] = $test;
            }
            // dd($array_);
            if(request()->page){
                $currentPage = request()->page;
            } else {
                $currentPage = 1;
            }
            $data_header = array();
            $collection = new Collection();
            if($select->extend == '1'){
                // $data_header[] = ['field_name' => 'index_id', 'field_description' => 'ID', 'can_copy' =>'1'];
                $collection->push((object)['field_name' => 'index_id', 'field_description' => 'ID', 'can_copy' =>'1']);
            }
            foreach($header as $he){
                // $data_header[] = ['field_name' => $he->field_name, 'field_description' => $he->field_description, 'can_copy' =>$he->can_copy];
                $collection->push((object)['field_name' => $he->field_name, 'field_description' => $he->field_description, 'can_copy' =>$he->can_copy]);
            }
            if($select->status == '1'){
                // $data_header[] = ['field_name' => 'status_report', 'field_description' => 'Status', 'can_copy' =>'1'];
                $collection->push((object)['field_name' => 'status_report', 'field_description' => 'Status', 'can_copy' =>'1']);
            }
            $collect_header = $collection;
            // dd($array_,$this_parent_data,$this_parent_rel,$data_header,$header,$collect_header);
            if(request()->q){
                $selected_arr = array();
                foreach ($array_ as $key => $val) {
                    foreach($collect_header as $col){
                        if (str_contains(strtolower($val[$col->field_name]),strtolower(request()->q))) {
                            $selected_arr[] = $key;
                        }
                    }
                }
                $a = array_unique($selected_arr);
                foreach ($a as $key) {
                    $array_data[] = $array_[$key];
                }
            }else{
                $array_data = $array_;
            }
            $perPage = $per_page; // How many items do you want to display.
            $offSet = ($currentPage * $perPage) - $perPage;
            $itemsForCurrentPage = array_slice($array_data, $offSet, $perPage, true);
            $total = count($array_data);
            $paginator = new LengthAwarePaginator($itemsForCurrentPage, $total, $perPage, $currentPage);
        }

        // dd($array_,$this_parent_data,$this_parent_rel,$data_header,$collect_header);
        if($paginator){
            return response()->json([
                'success'   => true,
                'message'   => 'Data',
                'data'      => [
                    'forms'=>$paginator,
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

    function myfunction($products, $field, $value)
    {
        foreach($products as $key => $product) {
            if ( $product[$field] === $value )
                return $key;
         }
        return false;
    }

    function searchForId($id, $array,$headers) {
        foreach ($array as $key => $val) {
            foreach($headers as $h){
                if (str_contains($val[$h->field_name],$id)) {
                    return $key;
                }
            }
        }
        return null;
     }

    public function create_data(Request $request){
        // dd($request);
        $generated = ''; $extend = 0; $base_ ='';
        $table          = $request->table;
        $select         = DB::table('master_tables')->where('name',$request->table)->first();
        $table_head     = DB::table('master_table_structures')->where('table_id',$select->id)->where('is_show',1)->get();
        $now            = Carbon::now()->toDateTimeString();
        $auth           = auth()->user()->id;
        $table_id       = $select->id;
		$select_field	= 'created_at,updated_at,created_by,updated_by,status,';
		$values	        = '"'.$now.'","'.$now.'",'.$auth.','.$auth.',"1",';
        if($select->extend=='1'){
            $last_data      = DB::table($table)->whereRaw('LEFT(index_id,4) = "'.date('ym').'"')->latest('index_id')->first();
            $select_field  .= 'index_id,';
            if($request->create_ticket){
                if($last_data){
                    if(substr($last_data->index_id,0,4).$select->id!=date("ym").$select->id){
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
            $base_ = '[System] Created New Data #'.$generated;
            if($select->status == '1'){
                $base_ .= ' With status '.$request->status_report;
            }
            $extend = 1;
        }

        foreach ($table_head as $t){
            $fields = $t->field_name;
            $select_field .= $t->field_name.',';
            if($t->input_type == 'File'){
                $file= $request->file($fields);
                if($file){
                    $save_file = $file->store('public/'.$table.'-'.$fields);
                    $values .= "'".str_replace('public/', '',$save_file)."',";
                }else{
                    $values .= "NULL,";
                }
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
                $values .= "'".$parent_data->$select."',";
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
        // dd($parent_data,"INSERT INTO $table ($selected) VALUES ($insert_value)");
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
        if($extend == 1){
            Extend::create(['table_id'=>$table_id,'index_id'=>$generated,'description'=>$base_,'status'=>$request->status_report,'created_by'=>auth()->user()->id]);
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
