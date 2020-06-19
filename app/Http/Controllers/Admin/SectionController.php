<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;
use Session;

class SectionController extends Controller
{
    public function section(){
        Session::put('page','sections');
        $sections = Section::get();
        return view('admin.sections.sections')->with(compact('sections'));
    }

    public function addSection(Request $request){
        $section = new Section;
        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'sectionname' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessage = [
                'sectionname.required' =>"Section Name is Required",
                'sectionname.regex' =>"Enter Valid Section Name",
            ];
            $this->validate($request,$rules,$customMessage);

            $section->name = $data['sectionname'];
            $section->status = 1;
            $section->save();

            Session::flash('success_message',"Section Added Successfully");
            return redirect('admin/sections');
        }

        return view('admin.sections.add_section');
    }

    public function updateSectionStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Section::where('id',$data['section_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'section_id'=>$data['section_id']]);
        }
    }
}
