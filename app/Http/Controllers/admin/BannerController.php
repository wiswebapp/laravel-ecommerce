<?php

namespace App\Http\Controllers\admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Requests\CreateBanner;
use Illuminate\Support\Facades\Storage;

class BannerController extends FilterController
{
    public function banner(Request $request){
        abort_unless($this->checkPermission('View Banner'), 403);
        $query = $this->filterBannerData($request);
        $data['pageData'] = $query->paginate(10);
        $data['pageTitle'] = "Banner";

        return view('admin.banner.index')->with('data',$data);
    }

    public function create_banner(){
        abort_unless($this->checkPermission('Create Banner'), 403);
        $data['pageTitle'] = "Add Banner";
        $data['action'] = "Add";

        return view('admin.banner.banner_action')->with('data',$data);
    }

    public function store_banner(CreateBanner $request){
        abort_unless($this->checkPermission('Create Banner'), 403);
        $banner = new Banner();
        $banner->title = $request->input('title');
        $banner->status = $request->input('status');
        if ($request->hasFile('path')) {
            $extension = $request->file('path')->extension();
            $newFileName = "BANNER_".time().".".$extension;
            $uploadPath = '/public/banner/';
            if (! Storage::exists($uploadPath)) {
                Storage::makeDirectory($uploadPath);
            }
            $request->file('path')->storeAs($uploadPath, $newFileName);
            $banner->path = $newFileName;
        }
        $banner->save();

        return redirect()->route('admin.banner')->with('success','Data Inserted Successfuly');
    }

    public function edit_banner($id){
        abort_unless($this->checkPermission('Edit Banner'), 403);
        $data['pageTitle'] = "Edit Banner";
        $data['action'] = "Edit";
        $data['pageData'] = Banner::find($id);

        return view('admin.banner.banner_action')->with('data',$data);
    }

    public function update_banner($id, CreateBanner $request){
        abort_unless($this->checkPermission('Edit Banner'), 403);
        $banner = Banner::find($id);
        $banner->title = $request->input('title');
        $banner->status = $request->input('status');
        if ($request->hasFile('path')) {
            $currentImage = $banner->path;
            $extension = $request->file('path')->extension();
            $newFileName = "BANNER_".time().".".$extension;
            $uploadPath = '/public/banner/';
            $fileStoragePath = public_path('storage/banner/'. $currentImage);
            if ( file_exists($fileStoragePath)) {
                unlink($fileStoragePath);
            }
            $request->file('path')->storeAs($uploadPath, $newFileName);
            $banner->path = $newFileName;
        }
        $banner->save();

        return redirect()->route('admin.banner')->with('success','Data Updated Successfuly');
    }

    public function destroy_banner(Request $request){
        abort_unless($this->checkPermission('Delete Banner'), 403);
        $banner = Banner::find($request->dataId);

        $fileStoragePath = public_path('storage/banner/'. $banner->path);
        if ( file_exists($fileStoragePath)) {
            unlink($fileStoragePath);
        }
        if ($banner->delete()) {
            return true;
        }

        return false;
    }
}
