function getAdminPath() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/getAdminPath",
            success: function (response) {
                resolve(response.admin_path)
            }
        });
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

async function exportData(exportType, formData) {
    const admin_path  = await getAdminPath();
    const url = "/" + admin_path + "/" + exportType + "/export-data?exportType=" + exportType + "&" + formData;
    window.location.href = url
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

    $("#selectAllPermission").click(function () {
        if ($(this).is(':checked')) {
            $('.selectPermissions').select2('destroy').find('option').prop('selected', 'selected').end().select2();
        } else {
            $('.selectPermissions').select2('destroy').find('option').prop('selected', false).end().select2();
        }
    });

    $(".export-data").click(function() {
        exportType = $(this).attr("data-exportType");
        filterForm = $("#filter-form").serialize();
        exportData(exportType, filterForm)
    })

})
