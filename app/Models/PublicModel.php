<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PublicModel extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];

    public function get_table_structure_by_table_id($id){
        $users = DB::table('master_table_structures')->where('table_id',$id)->where('is_show',1)->get();
        return $users;
    }

    public function get_all_table_data($name){
        $users = DB::table($name)->get();
        return $users;
    }

    public function get_table_single_filter($name,$selector,$filter){
        $users = DB::table($name)->where($selector,$filter)->get();
        return $users;
    }

    public function get_single_data_single_filter($name,$selector,$filter){
        $users = DB::table($name)->where($selector,$filter)->first();
        return $users;
    }
}
