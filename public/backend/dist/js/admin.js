$("#selectAllPermission").click(function () {
    if ($(this).is(':checked')) {
        $(".selectPermissions select > option").prop("selected", "selected");
    } else {
        $(".selectPermissions select > option").removeAttr("selected");
    }
});
