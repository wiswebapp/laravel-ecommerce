<?php
namespace App\Http\Controllers\admin;

use App\Product;
use App\ProductOptions;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProduct;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends FilterController
{
    public function product(Request $request) {
        abort_unless($this->checkPermission('View Product'), 403);
        $query = $this->filterProductData($request);
        $data['pageData'] = $query->paginate(10);
        $data['pageTitle'] = "Product";

        return view('admin.product.index')->with('data',$data);
    }

    public function create_product() {
        abort_unless($this->checkPermission('Create Product'), 403);
        $data['action'] = "Add";
        $data['pageTitle'] = "Add Product";
        $data['pageData']['category'] = Builder::getCategoryData();

        return view('admin.product.product_action')->with('data',$data);
    }

    public function store_product(CreateProduct $request) {
        abort_unless($this->checkPermission('Create Product'), 403);
        $newFileName = "";

        if ($request->hasFile('product_image')) {
            $extension = $request->file('product_image')->extension();
            $newFileName = "PRODUCT_".time().".".$extension;
            $uploadPath = '/public/product/';
            if (! Storage::exists($uploadPath)) {
                Storage::makeDirectory($uploadPath);
            }
            $request->file('product_image')->storeAs($uploadPath, $newFileName);
        }
        $product = new Product();
        $input = $request->all();
        unset($input['_token']);
        $input['product_image'] = $newFileName;
        $product::insert($input);

        return redirect()->route('admin.product')->with('success','Data Updated Successfuly');
    }

    public function edit_product($id) {
        abort_unless($this->checkPermission('Edit Product'), 403);
        $data['action'] = "Edit";
        $data['pageData'] = Product::find($id);
        $data['pageTitle'] = "Edit Product";
        $data['pageData']['category'] = Builder::getCategoryData();

        return view('admin.product.product_action')->with('data',$data);
    }

    public function update_product($id, CreateProduct $request) {
        abort_unless($this->checkPermission('Edit Product'), 403);
        $product = Product::find($id);

        if( count($request->all('option_name')) > 0) {
            ProductOptions::where([
                'user_id' => $request->user()->id,
                'product_id' => $product->id,
            ])->forceDelete();
            foreach ($request->get('option_name') as $key => $value) {
                $dataArr = [
                    'user_id' => $request->user()->id,
                    'product_id' => $product->id,
                    'option_name' => $value,
                    'option_value' => $request->get('option_price')[$key]
                ];
                ProductOptions::create($dataArr);
            }
        }
        if ($request->hasFile('product_image')) {
            $currentImage = $product->product_image;
            $extension = $request->file('product_image')->extension();
            $newFileName = "PRODUCT_".time().".".$extension;
            $uploadPath = '/public/product/';
            $fileStoragePath = public_path('storage/product/'. $currentImage);
            if ( file_exists($fileStoragePath)) {
                unlink($fileStoragePath);
            }
            $request->file('product_image')->storeAs($uploadPath, $newFileName);
            $product->product_image = $newFileName;
        }
        $update = $product->fill($request->all())->save();
        if($update):
            return redirect()->route('admin.product')->with('success','Data Updated Successfuly');
        else:
            return redirect()->route('admin.product')->with('error', 'Data Failed to update');
        endif;
    }

    public function destroy_product( Request $request) {
        abort_unless($this->checkPermission('Delete Product'), 403);
        $product = Product::find($request->dataId);
        $product->delete();
        echo 1;
    }
}
