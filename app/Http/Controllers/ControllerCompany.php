<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Image;
use App\Company;
use Session;
use Storage;
// use Purifier;
class ControllerCompany extends Controller
{
    public function ViewInfo(){
        return view('Company.view');
    }
    public function Handing(Request $request){
        $validation = Validator::make($request->all(),[
            'name'=> 'required',
            'address'=> 'required',
            'images'=> 'required | mimes: jpg,png,jpeg ',
            'allinfo'=> 'required',
        ])->validate();
        $name = $request->input('name');
        $address = $request->input('address');
        $allinfo = $request->input('allinfo');
        // $allinfo = Purifier::clean($request->input('allinfo'));
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $company =new Company;
        $company->name = $name;
        $company->address = $address;
        $company->content = $allinfo;
        $company->lat = $lat;
        $company->lng = $lng;
        if($request->hasFile('images')){
            $images = $request->file('images');
            // $images->move('public/uploads/Images/',$images_name);
            // $images_name = $images->getClientOriginalName();
            $images_name = time(). "." .$images->getClientOriginalExtension();
            $location = public_path('uploads\img'.$images_name);
            Image::make($images)->resize(280,250)->save($location);
            // $old_images = $company->images;
            $company->images = $images_name;
            // Storage::delete($old_images);
        }
        else{
            return redirect()->back()->withInput()->withErrors($validation);
        }

        $company->save();
        // Session::flash('status', 'Add Infomation Company Successful !');
        return redirect()->back()->withInput()->withErrors($validation)->with('status', 'Add Infomation Company Successful !');
    }
}
