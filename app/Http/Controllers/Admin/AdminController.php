<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
use Hash;
use Image;
use App\Category;
use App\Section;
use App\Customers;
class AdminController extends Controller
{

    public function login(Request $request){
        // echo $pswd = Hash::make('123456789'); die(); //to generate hash pswd
        if ($request->isMethod('post')){
            $data = $request->all();

            // $validatedData = $request->validate([
            //     'email' => 'required|email|max:255',
            //     'password' => 'required',
            // ]); since its big for more fields,will make is small ass follows

            $rules = [
            'email' => 'required|email|max:255',
            'password' => 'required',
            ];

            $customMessages = [
                'email.email' => 'Valid email is required',
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
            ];

            $this->validate($request,$rules,$customMessages);

            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']])){
                return redirect('admin/dashboard');
            }else{
                Session::flash('error_message','Invalid Credentials');
                return redirect()->back();
            }
                // echo "<pre>";
                // print_r($data);
                // die();
        }
        return view('admin.admin_login');   

    }


    public function dashboard(){
        Session::put('page','dashboard'); 
        $category = Category::get();
        $category = Category::where('status','1')->count();
        $sections = Section::where('status','1')->count();
        $customers = Customers::count();
        $subadmins = Admin::where('type','subadmin')->count();
        //echo "<pre>"; print_r($subadmins); die;
        return view('admin.admin_dashboard')->with(compact('category','sections','customers','subadmins'));
    }

    public function chkCurrentPassword(Request $request){
        $data = $request->all();
         //echo "<pre>";
        // print_r($data);
        // die();
        //print_r(Auth::guard('admin')->user()->password);
        //die();

        if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
            echo "true";
        }else{
            echo "false";
        }
    }

   

    public function updateCurrentPassword(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>";print_r($data);die();
            if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){

                if($data['new_pwd']==$data['confirm_pwd']){
                    //Admin is model and bcrypt() to decrypt password
                    Admin::where('id',Auth::guard('admin')->user()->id)->update
                    (['password'=>bcrypt($data['new_pwd'])]);
                    Session::flash('success_message','Password updated successfully');
                }else{
                    
                    Session::flash('error_message','Your new password and confirm passwords not matching');
                
                }
            }else{

                Session::flash('error_message','Your current password is incorrect');
                
            }
            return redirect()->back();

        }

    }

    public function updateAdminDetails(Request $request){

        Session::put('page','update-admin-details');
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>";print_r($data);die();

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' =>'required|numeric|digits:10',
                'admin_image' => 'image'

            ];
            $customMessage = [
                'admin_name.required' =>"Name is Required",
                'admin_mobile.required' => "Mobile number required",
                'admin_mobile.numeric' => "Valid Mobile number required",
                'admin_mobile.digits' => "Enter 10 digit Mobile Number",
                'admin_image.image'=>"Valid image format is required",
                 
            ];
            $this->validate($request,$rules,$customMessage);
            //upload image
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()){
                    //get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //generate new image name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/admin_images/admin_photo/'.$imageName;
                    //upload image
                    Image::make($image_tmp)->save($imagePath);
                }
                else if(!empty($data['current_admin_image'])){
                    
                    $imageName = $data['current_admin_image'];

                }
            }
            else{
                    $imageName ="";
                }           


            //update admin details
            Admin::where('email',Auth::guard('admin')->user()->email)
            ->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'],
            'image'=>$imageName]);
            Session::flash('success_message',"Details Updated");
            return redirect()->back();
        }
        return view('admin.update_admin_details');
        
    }

    public function settings(){
        Session::put('page','settings');
        return view('admin.admin_settings');
    }
    

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin');
        }
}
 