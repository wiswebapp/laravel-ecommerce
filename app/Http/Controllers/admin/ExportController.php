<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Exports\GeneralExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends GeneralController
{

    protected $exportType;

    public function __construct($type) {
        $this->exportType = $type;
    }

    public function exportData(Request $request) {

        $filterClass = new FilterController();
        $fileName = $this->exportType . "_list_". date("YmdHI") . ".xlsx";
        $requestData = $request->all();

        switch ($this->exportType) {

            case 'user':
                $fields = ['fname', 'lname', 'email', 'phonecode', 'phone', 'country', 'state', 'status','created_at'];
                $requestHeading =  ['First Name', 'Last Name', 'Email Address', "PhoneCode", "Mobile Number", "Country", "State", "Status", "Registered On"];

                if($requestData['exportAll'] == "Yes") {
                    $query = $filterClass->filterUserData($request, true);
                } else {
                    $query = $filterClass->filterUserData($request);
                }

                $query->addSelect($fields);
                $requestData = $query->get();
                $requestData->map(function($mapData) {
                    $mapData->country = $mapData->getUserCountry->name;
                    $mapData->state = $mapData->getUserState->name;
                    $mapData->created_at = $mapData->created_at->format('d-m-Y');
                });
                break;

            case 'category':
                $fields = ['category_name', 'status','created_at'];
                $requestHeading =  ['Category Name', "Status", "Created On"];

                if($requestData['exportAll'] == "Yes") {
                    $query = $filterClass->filterCategoryData($request, true);
                } else {
                    $query = $filterClass->filterCategoryData($request);
                }

                $query->addSelect($fields);
                $requestData = $query->get();
                $requestData->map(function($mapData) {
                    $mapData->created_at = $mapData->created_at->format('d-m-Y');
                });
                break;

            case 'subcategory':
                $fields = ['category_name', 'parent_id', 'status','created_at'];
                $requestHeading =  ['Category Name', "Parent Category", "Status", "Created On"];

                if($requestData['exportAll'] == "Yes") {
                    $query = $filterClass->filterSubCategoryData($request, true);
                } else {
                    $query = $filterClass->filterSubCategoryData($request);
                }

                $query->addSelect($fields);
                $requestData = $query->get();
                $requestData->map(function($mapData) {
                    $mapData->parent_id = $mapData->parent->category_name;
                    $mapData->created_at = $mapData->created_at->format('d-m-Y');
                });
                break;

            case 'product':
                $fields = ['category_id', 'subcategory_id', 'product_name', 'price', 'stock_count' ,'is_available', 'status', 'created_at'];
                $requestHeading =  ['Category', 'SubCategory', 'Product Name', 'Price', 'Stock Count' ,'Is Available', 'Status', 'Added On'];

                if($requestData['exportAll'] == "Yes") {
                    $query = $filterClass->filterProductData($request, true);
                } else {
                    $query = $filterClass->filterProductData($request);
                }

                $query->addSelect($fields);
                $requestData = $query->get();
                $requestData->map(function($mapData) {
                    $mapData->category_id = $mapData->category->category_name;
                    $mapData->subcategory_id = $mapData->subcategory->category_name;
                });
                break;

            case 'store':
                $fields = ['owner','name','email','address','location','country','state','zipcode','status','created_at'];
                $requestHeading =  ['Owner Name', 'Store Name', 'Email', "Address", "Location", "Country", "State","Zip","Status", "Registered On"];

                if($requestData['exportAll'] == "Yes") {
                    $query = $filterClass->filterStoreData($request, true);
                } else {
                    $query = $filterClass->filterStoreData($request);
                }

                $query->addSelect($fields);
                $requestData = $query->get();
                $requestData->map(function($mapData) {
                    $mapData->country = $mapData->getCountry->name;
                    $mapData->state = $mapData->getState->name;
                    $mapData->created_at = $mapData->created_at->format('d-m-Y');
                });
                break;

            default:
                abort(404);
                break;
        }

        return Excel::download(new GeneralExport($requestData, $requestHeading), $fileName);
    }
}
