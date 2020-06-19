<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Customers;

class CustomerController extends Controller
{
    public function customers(){
        Session::put('page','customers');
        $customers=Customers::get();
        return view('admin.customer.customers')->with(compact('customers'));
    }

    public function addCustomer(Request $request){

        $customer = new Customers;
        if($request->isMethod('post')){
            $data = $request->all();

            //echo "<pre>"; print_r($data); die;
            $rules = [
                'customername' => 'required|regex:/^[\pL\s\-]+$/u',
                'customermobile' =>'required|digits:10',
                'customeremail' => 'required',
                'customerplace'=>'required|regex:/^[\pL\s\-]+$/u',

            ];
            $customMessage = [
                'customername.required' =>"Customer Name is Required",
                'customername.regex' =>"Enter Valid Customer Name",
                'customermobile.required' => "Customer Number is Required",
                'customermobile.digits' => "Customer Number is Invalid",
                'customeremail.required' => "Customer Email is Required",
                'customerplace.required' => "Customer place is Required",
                'customerplace.regex' => "Enter Valid Customer Place",
                 
            ];
            $this->validate($request,$rules,$customMessage);

            //$customer->customer_id = $data['customer_id'];
            $customer->customer_name = $data['customername'];
            $customer->customer_mobile = $data['customermobile'];
            $customer->customer_email = $data['customeremail'];
            $customer->customer_place = $data['customerplace'];         
            $customer->save();
       
            Session::flash('success_message',"Customer added successfully");
            return redirect('admin/customers');
        }
        return view('admin.customer.add_customer');
    }

    public function deleteCustomer($id){
        Customers::where('id',$id)->delete();

        $message = "Customer Deleted Successfully";
        session::flash('success_message',$message);
        return redirect()->back();
    }
}
