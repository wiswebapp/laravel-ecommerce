/**
 *
 * Note : In this file all the functions are defined first and then after
 * one document ready start and on all events that should work after document ready
 * is defined in that
 * please do not create functions and events anywhere
 *
 */
function getAdminPath() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/get-admin-path",
            success: function (response) {
                resolve(response.admin_path)
            }
        });
    });
}

function setCategoryAjax(routeUrl, selectedId='') {
    $.ajax({
        type: "POST",
        url: routeUrl,
        data: { selectedId:selectedId },
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response.success){
                $("#category").html(response.subCatData);
            } else {
                fireAlert('danger', 'Whoops !', 'An Unexpected error has been occured !')
            }
        },
        error: function(){
            fireAlert('', 'Whoops !', 'An Unexpected error has been occured !')
        }
    });
}

function removeSingleData(routeUrl, htmlText, dataId) {
    Swal.fire({
        icon: 'warning',
        title: 'Are you sure ?',
        html: '<i><b>Note :</b> ' + htmlText + '</i>',
        showCancelButton: true,
        confirmButtonText: 'Delete',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type : "DELETE",
                url : routeUrl,
                dataType: 'json',
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                data : { dataId: dataId },
                success : function(response) {
                    if (response) {
                        location.reload();
                    } else {
                        fireAlert('danger', 'Whoops !', 'An Unexpected error has been occured !')
                    }
                },
                error: function(){
                    fireAlert('', 'Whoops !', 'Seems like you don\'t have permission to remove.')
                }
            });
        }
    })
}

async function removeMultipleData(exportType, selectedIds) {
    const admin_path  = await getAdminPath();
    const ajaxUrl = '/' + admin_path + '/' + exportType + '/removeMultiple';

    $.ajax({
        type : "DELETE",
        dataType: 'json',
        url: ajaxUrl,
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        data : {
            exportType: exportType,
            selectedIds: selectedIds
        },
        success : function(response) {
            if (response) {
                location.reload();
            } else {
                fireAlert('danger', 'Whoops !', 'An Unexpected error has been occured !')
            }
        },
        error: function(){
            fireAlert('', 'Whoops !', 'Seems like you don\'t have permission to remove.')
        }
    });
}

async function selectState(countryId, selectedState = '') {
    const admin_path  = await getAdminPath();
    $.ajax({
        type: "POST",
        url: "/" + admin_path + "/general/getState",
        data: {
            countryId: countryId ,
            selectedState: selectedState
        },
        beforeSend: function () {
            $("#state").html("<option>Please Wait...</option>")
            $("#state").prop("disabled", true)
        },
        success: function (response) {
            $("#state").html(response)
            $("#state").prop("disabled", false)
        }
    });
}

async function exportData(exportType, formData, selectedIds = "") {
    const admin_path  = await getAdminPath();
    const url = "/" + admin_path + "/" + exportType + "/export-data?exportType=" + exportType + "&selectedIds=" + selectedIds + "&" + formData;
    window.location.href = url
}

async function exportAllData(exportType) {
    const admin_path  = await getAdminPath();
    const url = "/" + admin_path + "/" + exportType + "/export-data?exportType=" + exportType + "&exportAll=Yes";
    window.location.href = url
}

function fireAlert(icon, title, note) {
    Swal.fire({
        icon: icon,
        title: title,
        html: '<b>Note :</b> ' + note,
        showCancelButton: false,
        confirmButtonText: 'Okay',
        allowOutsideClick: false
    })
}

/**
 * Note :: Product Option Modal JS
 */

function renderProductOptionHtml(name, price, randomCode = '') {
    if (! randomCode){
        var randomCode = Date.now() + Math.floor(Math.random() * 100000);
    }
    return `<div class="row option-row-${randomCode}">
                <div class="col-md-5">
                    <div class="form-group">
                        <input readonly type="text" autocomplete="off" name="option_name[]" value="${name}" class="option-name-${randomCode} form-control">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input readonly type="text" autocomplete="off" name="option_price[]" value="${price}" class="option-value-${randomCode} form-control">
                    </div>
                </div>
                <div class="col-md-1"><span onclick="editOptionForm(${randomCode})" class="btn btn-sm btn-success"><i class="fa fa-pen"></i></span></div>
                <div class="col-md-1"><span onclick="removeOptionForm(${randomCode})" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></span></div>
            </div>`;
}

function saveOptionForm() {
    var name = $(".option-name").val();
    var price = $(".option-price").val();
    var renderHtml = "";
    $(".option-error").hide();

    if(name == "" || price == "" || ! $.isNumeric(price)) {
        $(".option-error").show();
    } else {
        $(".no-option-text").hide();
        renderHtml = renderProductOptionHtml(name, price);
        $(".option-input").append(renderHtml);
        $("#modal-options").modal("hide");
    }
}

function updateOptionForm() {
    var name = $(".option-name").val();
    var price = $(".option-price").val();
    var optionboxid = $(".submit-optionmodal").attr("data-optionboxid");
    $(".option-error").hide();

    if(name == "" || price == "" || ! $.isNumeric(price)) {
        $(".option-error").show();
    } else {
        renderHtml = renderProductOptionHtml(name, price, optionboxid);
        $(".option-row-" + optionboxid).html(renderHtml);
        $("#modal-options").modal("hide");
    }
}

function editOptionForm(optionId) {
    $(".option-name").val( $(".option-name-" + optionId).val())
    $(".option-price").val( $(".option-value-" + optionId).val())
    showOptionModal("Edit", optionId)
}

function showOptionModal(mode = "Add", optionBoxId = '') {
    var optionModal = $("#modal-options");
    if (mode == "Edit") {
        $(".submit-optionmodal").attr("onclick", "updateOptionForm()");
        $(".submit-optionmodal").attr('data-optionBoxId', optionBoxId);
    } else {
        $(".submit-optionmodal").attr("onclick", "saveOptionForm()");
        $(".option-name").val("");
        $(".option-price").val("");
    }
    optionModal.modal("show");
}

function removeOptionForm(optionId) {
    $(".option-row-" + optionId).html("");
}

function changeTimingSection(value) {
    if (value != "daily") {
        $(".customTimingBox").show();
    } else {
        $(".customTimingBox").hide();
    }
}

$(document).ready(function(){

    $(".select-all-cb").click(function(){
        if ($(this).prop('checked') == true){
            $('.data-cb').prop('checked', true);
            $(".export-section").show();
        } else {
            $('.data-cb').prop('checked', false);
            $(".export-section").hide();
        }
    });

    $(".data-cb").change(function(){
        anyChecked = false;

        if($(this).is(':checked')) {
            $(".export-section").show();
        } else {
            $('.data-cb').each(function() {
                if($(this).is(':checked')) {
                    selectedIds.push($(this).attr('data-id'));
                }
            });
            $(".export-section").hide();
        }
    })

    $('.data-cb').each(function() {
        if($(this).is(':checked')) {
            selectedIds.push($(this).attr('data-id'));
        }
    });

    $("#selectAllPermission").click(function () {
        if ($(this).is(':checked')) {
            $('.selectPermissions').select2('destroy').find('option').prop('selected', 'selected').end().select2();
        } else {
            $('.selectPermissions').select2('destroy').find('option').prop('selected', false).end().select2();
        }
    });

    $(".export-data").click(function() {
        var exportType = $(this).attr("data-exportType");
        var filterForm = $("#filter-form").serialize();
        var selectedIds = [];

        $('.data-cb').each(function() {
            if($(this).is(':checked')) {
                selectedIds.push($(this).attr('data-id'));
            }
        });
        exportData(exportType, filterForm, selectedIds)
    })

    $(".export-all-data").click(function() {
        var exportType = $(this).attr("data-exportType");
        exportAllData(exportType)
    })

    $(".delete-all-data").click(function() {
        var exportType = $(this).attr("data-deletetype");
        var selectedIds = [];
        $('.data-cb').each(function() {
            if($(this).is(':checked')) {
                selectedIds.push($(this).attr('data-id'));
            }
        });

        Swal.fire({
            icon: 'warning',
            title: 'Are you sure ?',
            html: '<i><b>Note :</b> This will remove selected '+ selectedIds.length +' data</i>',
            showCancelButton: true,
            confirmButtonText: 'Delete',
        }).then((result) => {
            if (result.isConfirmed) {
                removeMultipleData(exportType, selectedIds)
            }
        })
    })

    $(".daySelectionCB").change(function(){
        var isChecked = $(this).is(':checked');
        var dataDay = $(this).attr('data-day');
        if(isChecked) {
            $("." + dataDay + "-box").slideDown();
        } else {
            $("." + dataDay + "-box").slideUp();
        }
    });
})
