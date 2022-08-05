<?php

namespace App\Http\Controllers\admin;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Requests\CreateStore;
use Illuminate\Support\Facades\Hash;

class StoreController extends FilterController
{
    public function store(Request $request) {
        abort_unless($this->checkPermission('View Store'), 403);
        $query = $this->filterStoreData($request);
        $data = $this->renderResponse('Store', [
            'pageData' => $query->paginate(10)
        ]);

        return view('admin.store.index')->with('data', $data);
    }

    public function create_store() {
        abort_unless($this->checkPermission('Create Store'), 403);
        $data = $this->renderResponse('Add Store', [
            'country' => $this->getCountry(),
            'action' => 'Add',
            'dayArray' => $this->dayArray,
        ]);

        return view('admin.store.store_action')->with('data', $data);
    }

    public function store_store(CreateStore $request) {
        abort_unless($this->checkPermission('Create Store'), 403);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->extension();
            $newFileName = "STORE_".time().".".$extension;
            $uploadPath = '/public/store/';
            $request->file('image')->storeAs($uploadPath, $newFileName);
            $input['image'] = $newFileName;
        }
        $storeDetails = Store::create($input);
        if ($storeDetails) {
            return redirect()->route('admin.store')->with('success','Data Updated Successfuly');
        } else {
            return redirect()->route('admin.store')->with('danger','Whoops..! Some error occured !');
        }
    }

    public function edit_store($id) {
        abort_unless($this->checkPermission('Edit Store'), 403);
        $storeData = Store::find($id);
        $data = $this->renderResponse('Edit Store', [
            'action' => 'Edit',
            'pageData' => $storeData,
            'country' => $this->getCountry(),
            'dayArray' => $this->dayArray,
            'timingType' => $storeData['store_timing']->default,
        ]);

        return view('admin.store.store_action')->with('data',$data);
    }

    public function update_store(CreateStore $request,$id) {
        abort_unless($this->checkPermission('Edit Store'), 403);
        $store = Store::find($id);
        $exceptArray = array_merge( array_map('strtolower', array_values($this->dayArray)),['default_morning_start', 'default_morning_end', 'default_evening_start', 'default_evening_end']);
        $input = $request->except($exceptArray);

        //Creating timing json
        $storeTimings = [];
        $selectionType = "default";
        $storeTimings['default']['morning']['start'] = $request->get('default_morning_start');
        $storeTimings['default']['morning']['end'] = $request->get('default_morning_end');
        $storeTimings['default']['evening']['start'] = $request->get('default_evening_start');
        $storeTimings['default']['evening']['end'] = $request->get('default_evening_end');
        foreach($this->dayArray as $day){
            $day = strtolower($day);
            $dayData =$request->get($day);
            if ($dayData[0] == "on" && $input['timingType'] != "daily") {
                $selectionType = "custom";
                $storeTimings[$day]['type'] = $selectionType;
                $storeTimings[$day]['morning']['start'] = $dayData[1];
                $storeTimings[$day]['morning']['end'] = $dayData[2];
                $storeTimings[$day]['evening']['start'] = $dayData[3];
                $storeTimings[$day]['evening']['end'] = $dayData[4];
            } else {
                $storeTimings[$day]['type'] = "default";
                $storeTimings[$day]['morning']['start'] = $request->get('default_morning_start');
                $storeTimings[$day]['morning']['end'] = $request->get('default_morning_end');
                $storeTimings[$day]['evening']['start'] = $request->get('default_evening_start');
                $storeTimings[$day]['evening']['end'] = $request->get('default_evening_end');
            }
        }
        $storeTimings['default']['type'] = $selectionType;
        $input['store_timing'] = json_encode($storeTimings);

        if ($request->hasFile('image')) {
            $currentImage = $store->image;
            $extension = $request->file('image')->extension();
            $newFileName = "STORE_".time().".".$extension;
            $uploadPath = '/public/store/';
            $fileStoragePath = public_path('storage/store/'. $currentImage);
            if ( file_exists($fileStoragePath)) {
                unlink($fileStoragePath);
            }
            $request->file('image')->storeAs($uploadPath, $newFileName);
            $input['image'] = $newFileName;
        }

        if($input['password'] == null) {
            unset($input['password']);
        } else {
            $input['password'] = Hash::make($input['password']);
        }
        $store->update($input);

        return redirect()->route('admin.store')->with('success','Data Updated Successfuly');
    }

    public function destroy_store(Request $request) {
        abort_unless($this->checkPermission('Delete Store'), 403);
        $dataTobeDelete = Store::find($request->dataId);
        if($dataTobeDelete->delete()) {
            return true;
        }

        return false;
    }
}
