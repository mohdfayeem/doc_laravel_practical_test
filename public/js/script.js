var subcategoryFieldCount = 1;
$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $(document).on("click", ".add-subcategory-fields-btn", function (e) {
        e.preventDefault();
        var appendContent = `
            <div class="row" id="subcategory-fields-${subcategoryFieldCount}">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="subcategoryname" class="form-label">Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="subcategoryname[]" placeholder="Enter Subcategory Name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="subcategoryemail" class="form-label">Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="subcategoryemail[]" placeholder="Enter Subcategory Email">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3 mt-4 pt-1">
                        <button type="button" class="btn btn-danger delete-subcategory-fields-btn" data-target="#subcategory-fields-${subcategoryFieldCount}">-</button>
                    </div>
                </div>
            </div>
        `;
        $("#append_subcategory_container").append(appendContent);
        subcategoryFieldCount++;
    });
    $(document).on("click", ".delete-subcategory-fields-btn", function (e) {
        e.preventDefault();
        var deleteId = $(this).data("target");
        $(deleteId).remove();
        if (subcategoryFieldCount < 2) {
            subcategoryFieldCount = 1;
        } else {
            subcategoryFieldCount--;
        }
    });
    $("#add_category_form").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            image: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please enter category name",
            },
            email: {
                required: "Email is required",
                email: "Please enter valid email address",
            },
            image: {
                required: "Please select image",
            },
        },
        errorElement: "span",
        errorClass: "invalid-feedback",
        errorPlacement: function (error, element) {
            element.closest(".error-wrapper").append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid");
            $(element).removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass);
            $(element).removeClass("is-invalid");
            $(element).addClass("is-valid");
        },
    });
    $("#edit_category_form").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            image: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please enter category name",
            },
            email: {
                required: "Email is required",
                email: "Please enter valid email address",
            },
            image: {
                required: "Please select image",
            },
        },
        errorElement: "span",
        errorClass: "invalid-feedback",
        errorPlacement: function (error, element) {
            element.closest(".error-wrapper").append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid");
            $(element).removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass);
            $(element).removeClass("is-invalid");
            $(element).addClass("is-valid");
        },
    });
    // remove-subcategory-btn
    $(document).on("click", ".remove-btn", function (e) {
        e.preventDefault();
        let data_id = $(this).data("id");
        let data_url = $(this).data("url");
        $.ajax({
            method: "post",
            url: data_url,
            data: { id: data_id },
            success: function (data) {
                alert(data["message"]);
                if (data["status"] === "Success") {
                    window.location.reload();
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });
});
