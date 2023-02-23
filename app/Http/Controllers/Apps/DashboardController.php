<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\master_table;
use App\Models\MasterCustomer;
use App\Models\MasterCustomerBranch;
use App\Models\MasterRelation;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // dd(MasterRelation::all());
        $output_cust = '';
        $output_branch = '';
        $customers = MasterCustomer::all();
        $customer_branch = MasterCustomerBranch::all();
        foreach($customers as $customer){
            $output_cust .= " MasterCustomer::create(['customer_name' => '".$customer->customer_name."']);"."\r";
        }
        foreach($customer_branch as $branch){
            $output_branch .= " MasterCustomerBranch::create(['outlet_id' => '".$branch->outlet_id."','customer_id' => '".$branch->customer_id."','customer_branch' => '".$branch->customer_branch."']);\n";
        }
        // dd($output_cust, $output_branch);
        // dd($form_access);
        return Inertia::render('Apps/Dashboard/Index', [
            // 'form_access' => $form_access,
        ]);
    }
}
