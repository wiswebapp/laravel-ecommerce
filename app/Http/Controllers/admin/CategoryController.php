<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCategory;
use App\Http\Requests\CreateSubCategory;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends FilterController
{
    //----------------------Category Module----------------------//
    public function category(Request $request){
        abort_unless($this->checkPermission('View Category'), 403);
        $query = $this->filterCategoryData($request);
        $data['pageData'] = $query->paginate(10);
        $data['pageTitle'] = "Product Category";

        return view('admin.category.category')->with('data',$data);
    }

    public function create_category(){
        abort_unless($this->checkPermission('Create Category'), 403);
        $data['pageTitle'] = "Add Product Category";
        $data['action'] = "Add";

        return view('admin.category.category_action')->with('data',$data);
    }

    public function store_category(CreateCategory $request){
        abort_unless($this->checkPermission('Create Category'), 403);
        $category = new Category;
        $category->category_name = $request->input('category_name');
        $category->status = $request->input('status');
        $category->save();

        return redirect()->route('admin.category')->with('success','Data Inserted Successfuly');
    }

    public function edit_category($id){
        abort_unless($this->checkPermission('Edit Category'), 403);
        $data['pageTitle'] = "Edit Product Category";
        $data['action'] = "Edit";
        $data['pageData'] = Category::find($id);

        return view('admin.category.category_action')->with('data',$data);
    }

    public function update_category($id, CreateCategory $request){
        abort_unless($this->checkPermission('Edit Category'), 403);
        $category = Category::find($id);
        $category->category_name = $request->input('category_name');
        $category->status = $request->input('status');
        $category->save();

        return redirect()->route('admin.category')->with('success','Data Updated Successfuly');
    }

    public function destroy_category(Request $request){
        abort_unless($this->checkPermission('Delete Category'), 403);
        $category = Category::find($request->dataId);
        $category->children()->delete();
        $category->products()->delete();
        $category->delete();

        return $this->category($request);
    }

    //----------------------SubCategory Module----------------------//
    public function getCatListing() {
        return Category::where('status' ,'Active')
                ->whereNull(['parent_id','deleted_at'])
                ->orderBy('id', 'desc')
                ->get();
    }

    public function subcategory(Request $request) {
        abort_unless($this->checkPermission('View SubCategory'), 403);
        $query = $this->filterSubCategoryData($request);
        $data['pageData'] = $query->paginate(10);
        $data['pageTitle'] = "Sub Product Category";

        return view('admin.category.subcategory')->with('data',$data);
    }

    public function create_subcategory() {
        abort_unless($this->checkPermission('Create SubCategory'), 403);
        $data['pageTitle'] = "Add Product SubCategory";
        $data['action'] = "Add";
        $data['pageData']['category'] = $this->getCatListing();

        return view('admin.category.subcategory_action')->with('data',$data);
    }

    public function store_subcategory(CreateSubCategory $request) {
        abort_unless($this->checkPermission('Create SubCategory'), 403);
        $category = new Category();
        $input = $request->all();
        $category::create($input);

        return redirect()->route('admin.subcategory')->with('success','Data Added Successfuly');
    }

    public function edit_subcategory($id) {
        abort_unless($this->checkPermission('Edit SubCategory'), 403);
        $dataCategory = Category::find($id);
        $data['pageTitle'] = "Edit Product SubCategory";
        $data['action'] = "Edit";
        $data['pageData'] = $dataCategory;
        $data['pageData']['category'] = $this->getCatListing();

        return view('admin.category.subcategory_action')->with('data',$data);
    }

    public function update_subcategory($id, CreateSubCategory $request) {
        abort_unless($this->checkPermission('Edit SubCategory'), 403);
        $category = Category::find($id);
        $input = $request->all();
        $category->fill($input)->save();

        return redirect()->route('admin.subcategory')->with('success','Data Updated Successfuly');
    }

    public function destroy_subcategory(Request $request) {
        abort_unless($this->checkPermission('Delete SubCategory'), 403);
        $category = Category::find($request->dataId);
        $category->delete();
        echo 1;
    }

    public function get_ajax_category(Request $request) {
        abort_unless($this->checkPermission('View Category'), 403);
        $selectedId = $request->input('selectedId');
        $catData = Builder::getCategoryData();
        if( $catData->count() > 0){
            $CatData="";
            foreach($catData as $catData){
                $selected = ($selectedId == $catData->id) ? "selected" : "";
                $CatData .= "<option value='".$catData->id."' $selected>".$catData->category_name."</option>";
            }
        }

        return response()->json(['success' => true, 'subCatData' => $CatData]);
    }

    public function get_ajax_subcategory(Request $request) {
        abort_unless($this->checkPermission('View SubCategory'), 403);
        $subCat = Builder::getSubCategoryData('*',[
            'status'=>'Active',
            'parent_id'=> $request->categoryId
        ]);
        $subCatData="";
        if( $subCat->count() > 0){
            foreach($subCat as $catData){
                $selected = ($request->selectedId == $catData->id) ? "selected" : "";
                $subCatData .= "<option value='".$catData->id."' $selected>".$catData->category_name."</option>";
            }
        }else{
            $subCatData .= "<option value=''>Select Category First</option>";
        }

        return response()->json(['success' => true, 'subCatData' => $subCatData]);
    }
}
