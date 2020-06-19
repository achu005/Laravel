<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Section;
use Session;
use Image;

class CategoryController extends Controller
{
    public function categories(){
        Session::put('page','categories');
         $categories = Category::with(['section','parentcategory'])->get();//section and parentcategory are functions from model
        // $categories = json_decode(json_encode($categories));
        // echo "<pre>"; print_r($categories); die; 
        return view('admin.categories.categories')->with(compact('categories'));//compat categories is from previous line
    }

    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Category::where('id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id=null){
        //url has id ,it means edit category else if url has no id,it means add category
        if($id==""){
            $title = "Add Category";
            //add category function
            $category = new Category;
            $categorydata = array();
            $getCategories = array();
            $message = "Category Added Successfully";

        }else{

            $title = "Edit Category";
            //edit category functions
            $categorydata = Category::where('id',$id)->first();
            $getCategories = Category::where(['parent_id'=>0,'section_id'=>$categorydata['section_id']])->get();
            $category = Category::find($id);
            $message = "Category Updated Successfully";
        }
        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' =>'required',
                'url' => 'required',
                'category_image'=>'image'

            ];
            $customMessage = [
                'category_name.required' =>"Category Name is Required",
                'category_name.regex' =>"Enter Valid Category Name",
                'section_id.required' => "Section Id required",
                'url.required'=>"Category Url required",
                'category_image.image'=>"Valid Image Format is Required",
                 
            ];
            $this->validate($request,$rules,$customMessage);

            if($request->hasFile('category_image')){
                $image_tmp = $request->file('category_image');
                if($image_tmp->isValid()){
                    //get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //generate new image name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/category_images/'.$imageName;
                    //upload image
                    Image::make($image_tmp)->save($imagePath);
                    //save image
                    $category->category_image = $imageName;

                }
            }


            if(empty($data['description'])){
                $data['description']="";  
            }
            // if(empty($data['category_image'])){
            //     $data['category_image']="";  
            //}
            if(empty($data['meta_title'])){
                $data['meta_title']="";  
            }
            if(empty($data['meta_description'])){
                $data['meta_description']="";  
            }
            if(empty($data['meta_keywords'])){
                $data['meta_keywords']="";  
            }


            //echo "<pre>"; print_r($data); die;
            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
            //$category->category_image = $data['category_image'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();
       
            Session::flash('success_message',$message);
            return redirect('admin/categories');
        }
       
        //get all sections
        $getSections = Section::get();

        return view('admin.categories.add_edit_categories')->with(compact('title','getSections','categorydata','getCategories'));
    }

    public function appendCategoryLevel(Request $request){

        if($request->ajax()){
            $data = $request->all();
            $getCategories = Category::with('subcategories')->where(['section_id'=>$data['section_id'],'parent_id'=>0,'status'=>1])->get();
            // echo "<pre>"; print_r($getCategories); die;
             //$getCategories = json_decode(json_encode($getCategories),true);
            return view('admin.categories.append_category_level')->with(compact('getCategories'));
        }
    }
    public function deleteCategoryImage($id){
        //get category
        $categoryImage = Category::select('category_image')->where('id',$id)->first();

        //get categoryimage path
        $category_image_path = 'images/category_images/';
        
        //delete image from local folder
        if(file_exists( $category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
        }

        //delete image from table
            Category::where('id',$id)->update(['category_image'=>'']);
            return redirect()->back();

    }

    public function deleteCategory($id){
        //delete category
        Category::where('id',$id)->delete();

        $message = "Category Deleted Successfully";
        session::flash('success_message',$message);
        return redirect()->back();
    }
}
