<?php

function generateExportSection($exportType) {
    $deleteAllBtn = ($exportType == 'user') ? '<a data-deleteType="'. $exportType .'" class="delete-all-data dropdown-item">Delete Selected</a>' : '';

    return '<div class="export-section" style="display: none">
                <div class="btn-group" style="float: right">
                    <button type="button" data-exportType="'. $exportType .'"  class="export-data btn btn-default">Export</button>
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu" style="">
                        ' . $deleteAllBtn . '
                        <a data-exportType="'. $exportType .'" class="export-all-data dropdown-item">Export All Data</a>
                    </div>
                </div>
            </div>';
}

function generateStatusRow($pageData) {
    $statusTxt = ($pageData->status != "Active") ? "In-active" : $pageData->status;
    $badgeClass = ($pageData->status == "Active") ? 'success' : 'danger';
    return '<span class="badge badge-'. $badgeClass .'">'. $statusTxt .'</span>';
}

function generateEditButton($link) {
    return "<a href='".$link."' class='btn btn-primary btn-sm'><i class='fas fa-pencil-alt'></i> Edit</a>";
}

function generateDeleteButton($module, $id) {
    return "<span onclick=\"removeData('". $module ."', ".$id.")\" class=\"btn btn-danger btn-sm\"><i class=\"fas fa-trash\"></i> Delete</span>";
}

function getRoutesPath($arrray) {
    $newRouteArray = $arrray;
    if (! empty($arrray)) {
        foreach($arrray as $value) {
            $value = explode('.', $value);
            unset($value[0]);
            $value = implode('.', $value);
            array_push($newRouteArray, 'admin.create_' . $value);
            array_push($newRouteArray, 'admin.edit_' . $value);
            array_push($newRouteArray, 'admin.destroy_' . $value);
        }
    }

    return $newRouteArray;
}

function adminAssets($url = '') {
    return URL::to('/backend/'.$url);
}

function toDate($date,$format = 'd-M-Y') {
    $newDate = date($format , strtotime($date));
    return $newDate;
}

function formatNum($number, $decimal = 2) {
    $newNumber = number_format($number, $decimal);
    return $newNumber;
}

function greetings()
{
    $time = date("H");

    $timezone = date("e");
    if ($time < "12") {
        $returnMsg = "Good morning";
    } else
    if ($time >= "12" && $time < "17") {
        $returnMsg = "Good afternoon";
    } else
    if ($time >= "17" && $time < "19") {
        $returnMsg = "Good evening";
    } else
    if ($time >= "19") {
        $returnMsg = "Good night";
    }
    return $returnMsg;
}
