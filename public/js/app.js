var url_path = "http://localhost/web_shop/";

var addImg = document.querySelector(".add_img");
var imageFormUpload = document.querySelector("#image");
var btnDelete = document.querySelector(".btn__delete");
var imgAvatar = document.querySelector("#img");
var btnAddAvatar = document.querySelector(".btn_add_avatar");
var btnEditAvatar = document.querySelector(".btn_edit");
if (btnAddAvatar) {
    btnAddAvatar.addEventListener("click", function () {
        imgAvatar.click();
    });
}

if (addImg) {
    addImg.addEventListener("click", function () {
        imageFormUpload.click();
    });
}
const dt = new DataTransfer();
if (imgAvatar) {
    imgAvatar.addEventListener("change", function () {
        const avatar = this.files[0];
        // console.log(avatar.type.match("image"));
        if (avatar.type.match("image")) {
            const avatarReader = new FileReader();
            avatarReader.addEventListener("load", function (e) {
                const avatarFile = e.target;
                const previewImg = document.querySelector(".preview__avatar");
                previewImg.innerHTML = `
                <div class="img_container">
                <img src="${avatarFile.result}" alt="">
                <div class="edit_container">
                    <div class="btn_edit" onclick="editAvatar()">
                        <i class="fa-solid fa-pen"></i>
                    </div>
                </div>
            </div>
                `;
            });
            avatarReader.readAsDataURL(avatar);
        }
    });
}
if (imageFormUpload) {
    imageFormUpload.addEventListener("change", function () {
        if (
            window.File &&
            window.FileReader &&
            window.FileList &&
            window.Blob
        ) {
            const preview = document.querySelector(".preview_imgs");
            let imgs_upload = this.files;
            let imgs_length = imgs_upload.length;
            if (imgs_length > 0) {
                for (let i = 0; i < imgs_length; i++) {
                    if (!imgs_upload[i].type.match("image")) continue;
                    const picReader = new FileReader();
                    picReader.addEventListener("load", function (e) {
                        const picFile = e.target;
                        const img_item = document.createElement("div");
                        img_item.classList.add("img_item");
                        img_item.innerHTML = `
                <img src="${picFile.result}" alt="">  
                <div class="delete">
                <div class="btn__delete" data-name="${imgs_upload[i].name}" >
                    <i class="fa-solid fa-xmark"></i>
                </div>
                </div>
                `;
                        preview.appendChild(img_item);
                    });
                    picReader.readAsDataURL(imgs_upload[i]);
                    dt.items.add(imgs_upload[i]);
                }
            }
            this.files = dt.files;
            console.log(dt.items[0]);
        }
    });
}

$(document).on("click", ".btn__delete", function () {
    const img_name = $(this).attr("data-name");
    const img_id = $(this).attr("data-id");
    if (img_name) {
        const length_img = dt.items.length;
        for (let i = 0; i < length_img; i++) {
            // console.log(dt.items[i].name);
            if (img_name == dt.files[i].name) {
                dt.items.remove(i);
                $(this).closest(".img_item").remove();
            }
        }
        console.log(dt.files);
    }
    if (img_id) {
        const id = Number(img_id);
        // console.log(id);
        $(this).closest(".img_item").remove();

        $.ajax({
            url: url_path + "admin/ajax/delele_img",
            method: "GET",
            data: { id },
            success: function (data) {
                // $("#formUpdateCat").html(data);
                // console.log(data);
            },
            error: function (response) {
                console.log(response.responseJSON);
            },
        });
    }
});
$(document).ready(function () {
    $(".nav-link.active .sub-menu").slideDown();
    // $("p").slideUp();

    $("#sidebar-menu .arrow").click(function () {
        $(this).parents("li").children(".sub-menu").slideToggle();
        $(this).toggleClass("fa-angle-right fa-angle-down");
    });

    $("input[name='checkall']").click(function () {
        var checked = $(this).is(":checked");
        $(".table-checkall tbody tr td input:checkbox").prop(
            "checked",
            checked
        );
    });
    // filter
    $("#product__arrange").change(function () {
        if ($(this).val()) {
            window.location = $(this).val();
        }
    });
    $("#product__filter").change(function () {
        if ($(this).val()) {
            window.location = $(this).val();
        }
    });
    // Update BRAND
    $(".edit_brand").click(function (e) {
        let id = $(this).attr("id");
        // console.log(id);
        $.ajax({
            url: url_path + "admin/ajax/edit_brand",
            method: "GET",
            data: { id },
            success: function (data) {
                // console.log(data);
                $("#formUpdate").html(data);
            },
        });
    });
    $("#formUpdate").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var id = $("#b_title_edit").attr("data-id");
        formData.append("id", id);
        $("#err_img").text("");
        $("#err_title").text("");
        $.ajax({
            url: url_path + "admin/ajax/update_brand",
            type: "POST",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            contentType: false,
            processData: false,
            success: function (response) {
                if (response) {
                    location.reload();
                    alert("Cập nhật bản ghi thành công");
                }

                // console.log(response);
            },
            error: function (response) {
                $("#err_title").text(response.responseJSON.errors["b_title"]);
            },
        });
    });
    // Updade CATEGORY
    $(".edit_cat_product").click(function (e) {
        let id = $(this).attr("id");
        // console.log(id);
        $.ajax({
            url: url_path + "admin/ajax/edit_cat_product",
            method: "GET",
            data: { id },
            success: function (data) {
                // console.log(data);
                $("#formUpdateCat").html(data);
            },
        });
    });
    $("#formUpdateCat").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var id = $("#title_update").attr("data-id");
        formData.append("id", id);
        // console.log(formData.values);
        $("#err_title_update").text("");
        $.ajax({
            url: url_path + "admin/ajax/update_cat_product",
            type: "POST",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            contentType: false,
            processData: false,
            success: function (response) {
                if (response) {
                    location.reload();
                    alert("Cập nhật bản ghi thành công");
                }

                console.log(response);
            },
            error: function (response) {
                $("#err_title_update").text(
                    response.responseJSON.errors["title"]
                );
            },
        });
    });
    // UPDATE COLOR
    $(".edit_color").click(function () {
        let id = $(this).attr("id");
        $.ajax({
            url: url_path + "admin/ajax/edit_color_product",
            method: "GET",
            data: { id },
            success: function (data) {
                // console.log(data);
                $("#formUpdateColor").html(data);
            },
        });
    });
    $("#formUpdateColor").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var id = $("#title_update").attr("data-id");
        formData.append("id", id);
        // console.log(formData.values);
        $("#err_title_update").text("");
        $.ajax({
            url: url_path + "admin/ajax/update_color_product",
            type: "POST",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            contentType: false,
            processData: false,
            success: function (response) {
                if (response) {
                    location.reload();
                    alert("Cập nhật bản ghi thành công");
                }

                console.log(response);
            },
            error: function (response) {
                $("#err_title").text(response.responseJSON.errors["title"]);
            },
        });
    });
    $(".t_title_update").on("blur", function (e) {
        let value = e.target.innerText;
        let id = $(this).attr("id");

        $.ajax({
            url: url_path + "admin/ajax/update_title_type",
            method: "GET",
            data: {
                value,
                id,
            },
            success: function (response) {
                if (response) {
                    alert("Update Successfully");
                }
            },
        });
    });
    $(".d_title_update").on("blur", function (e) {
        let value = e.target.innerText;
        let id = $(this).attr("id");

        $.ajax({
            url: url_path + "admin/ajax/update_title_detail",
            method: "GET",
            data: {
                value,
                id,
            },
            success: function (response) {
                if (response) {
                    alert("Update Successfully");
                }
            },
        });
    });
    $(".type_status").change(function () {
        let status = $(this).find(":checked").val();
        let id = $(this).attr("data-id");

        $.ajax({
            url: url_path + "admin/ajax/update_status_type",
            method: "GET",
            data: {
                status,
                id,
            },
            success: function (response) {
                if (response) {
                    alert("Update Successfully");
                }
            },
        });
    });
    $(".detail_status").change(function () {
        let status = $(this).find(":checked").val();
        let id = $(this).attr("data-id");
        $.ajax({
            url: url_path + "admin/ajax/update_status_detail",
            method: "GET",
            data: {
                status,
                id,
            },
            success: function (response) {
                if (response) {
                    alert("Update Successfully");
                }
            },
        });
    });
    $(".type_id").change(function () {
        let type_id = $(this).find(":checked").val();
        let id = $(this).attr("data-id");
        $.ajax({
            url: url_path + "admin/ajax/update_type_id_detail",
            method: "GET",
            data: {
                type_id,
                id,
            },
            success: function (response) {
                if (response) {
                    alert("Update Successfully");
                }
            },
        });
    });
    $("#config_type").change(function () {
        let type_id = $(this).find(":checked").val();
        $.ajax({
            url: url_path + "admin/ajax/product_config",
            method: "GET",
            data: {
                type_id,
            },
            success: function (response) {
                $(".config_details").html(response);
            },
        });
    });
    $(".edit_cat_post").click(function () {
        let id = $(this).attr("id");
        $.ajax({
            url: url_path + "admin/ajax/edit_cat_post",
            method: "GET",
            data: { id },
            success: function (data) {
                // console.log(data);
                $("#formUpdateCatPost").html(data);
            },
        });
    });
    $("#formUpdateCatPost").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var id = $("#title_update").attr("data-id");
        formData.append("id", id);
        // console.log(formData.values);
        $("#err_title").text("");
        $.ajax({
            url: url_path + "admin/ajax/update_cat_post",
            type: "POST",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            contentType: false,
            processData: false,
            success: function (response) {
                if (response) {
                    location.reload();
                    alert("Cập nhật bản ghi thành công");
                }

                console.log(response);
            },
            error: function (response) {
                $("#err_title").text(response.responseJSON.errors["title"]);
            },
        });
    });
    $(".product__search").on("input", function () {
        // console.log($(this).val());
        let value = $(this).val();
        if (value) {
            $(".result__search").css("display", "block");
            $.ajax({
                url: url_path + "ajax/product__search",
                method: "GET",
                data: { value },
                success: function (data) {
                    // console.log(data);
                    $(".result__search").html(data);
                },
            });
        } else {
            $(".result__search").css("display", "none");
        }
    });
    $(document).click(function (e) {
        var results = e.target.closest(".result__search");
        if (!results) {
            $(".result__search").css("display", "none");
        }
    });

    $(".product__add_cart").click(function (e) {
        let color_element = $(".color__item.active");
        if (color_element.length > 0) {
            let color_id = color_element.attr("data-id");
            let product_id = $(this).attr("data-id");
            $.ajax({
                url: url_path + "cart/add",
                method: "GET",
                data: { product_id, color_id },
                success: function (data) {
                    // console.log(data);
                    $(".header__cart p").html(data);
                    $("#notification__cart").css("display", "flex");
                    // setTimeout(function () {
                    //     $("#notification__cart").css("display", "none");
                    // }, 1000);
                },
            });
            // console.log(product_id);
            // console.log(color_id);
        } else {
            $(".color__err").css("display", "block");
        }
    });
    $(document).on("click", ".notification__close", function () {
        $("#notification__cart").css("display", "none");
    });
    $(".product__buy").click(function (event) {
        event.preventDefault();
        let color_element = $(".color__item.active");
        if (color_element.length <= 0) {
            $(".color__err").css("display", "block");
        } else {
            const color_id = color_element.attr("data-id");
            const product_id = $(this).attr("data-id");
            const url = $(".product__buy").attr("href");

            // console.log(url);
            $.ajax({
                url: url_path + "cart/add",
                method: "GET",
                data: { product_id, color_id },
                success: function (data) {
                    // console.log(data);
                    window.location = url;
                },
            });
        }
    });
    $(".num_order").change(function () {
        console.log($(this));
    });
    $("#province").change(function () {
        let province_id = $(this).find(":checked").val();
        $.ajax({
            url: url_path + "cart/load_distric",
            method: "GET",
            data: {
                province_id,
            },
            success: function (response) {
                $("#district").html(response);
            },
            error: function (response) {
                console.log(response);
            },
        });
    });
    $("#district").change(function () {
        let district_id = $(this).find(":checked").val();
        $.ajax({
            url: url_path + "cart/load_ward",
            method: "GET",
            data: {
                district_id,
            },
            success: function (response) {
                $("#ward").html(response);
            },
            error: function (response) {
                console.log(response);
            },
        });
    });
});
var thisPage = 1;
// console.log(list);
function loadItem(selector, limit, selectPagination) {
    var list = document.querySelectorAll(selector + " .item");
    let beginItem = limit * (thisPage - 1);
    let lastItem = beginItem + limit - 1;
    list.forEach((item, key) => {
        if (key >= beginItem && key <= lastItem) {
            item.style.display = "table-row";
        } else {
            item.style.display = "none";
        }
    });
    loadCurrentPage(selector, limit, selectPagination);
}
function loadCurrentPage(selector, limit, selectPagination) {
    var list = document.querySelectorAll(selector + " .item");
    let lengthItem = list.length;
    let numPage = Math.ceil(lengthItem / limit);
    if (numPage === 1) {
        document.querySelector(selectPagination).style.display = "none";
    } else {
        document.querySelector(selectPagination).innerHTML = "";
        if (thisPage != 1) {
            let pre = document.createElement("li");
            pre.innerHTML = "PRE";
            pre.setAttribute(
                "onclick",
                `changePage(${
                    thisPage - 1
                },'${selector}',${limit},'${selectPagination}')`
            );
            document.querySelector(selectPagination).appendChild(pre);
        }
        for (let i = 1; i <= numPage; i++) {
            // console.log(i);
            let newPage = document.createElement("li");
            newPage.innerHTML = i;
            if (i === thisPage) {
                newPage.classList.add("active");
            }
            newPage.setAttribute(
                "onclick",
                `changePage(${i},'${selector}',${limit},'${selectPagination}')`
            );
            document.querySelector(selectPagination).appendChild(newPage);
        }
        if (thisPage >= 1 && thisPage < numPage) {
            let next = document.createElement("li");
            next.innerHTML = "NEXT";
            next.setAttribute(
                "onclick",
                `changePage(${
                    thisPage + 1
                },'${selector}',${limit},'${selectPagination}')`
            );
            document.querySelector(selectPagination).appendChild(next);
        }
    }
    // console.log(numPage);
}
function changePage(i, selector, limit, selectPagination) {
    thisPage = i;
    loadItem(selector, limit, selectPagination);
}
var increase_eles = document.querySelectorAll(".increase");
var decrease_eles = document.querySelectorAll(".decrease");
if (increase_eles) {
    increase_eles.forEach((ele) => {
        ele.addEventListener("click", function (e) {
            let product_id = e.target.getAttribute("data-id");
            let qty = parseInt(
                document.querySelector(`.product_${product_id}`).value
            );
            qty += 1;
            document.querySelector(`.product_${product_id}`).value = qty;
            $.ajax({
                url: url_path + "cart/update",
                method: "GET",
                data: { product_id, qty },
                success: function (data) {
                    $(".sub_total_" + product_id).html(data.cart[product_id]);
                    $(".cart__total-span").html(data["total"] + "Đ");
                    $(".header__cart p").html(data["count"]);
                },
            });
        });
    });
}

if (decrease_eles) {
    decrease_eles.forEach((ele) => {
        ele.addEventListener("click", function (e) {
            let product_id = e.target.getAttribute("data-id");
            let qty = parseInt(
                document.querySelector(`.product_${product_id}`).value
            );
            if (qty > 1) {
                qty -= 1;
                document.querySelector(`.product_${product_id}`).value = qty;
                $.ajax({
                    url: url_path + "cart/update",
                    method: "GET",
                    data: { product_id, qty },
                    success: function (data) {
                        $(".sub_total_" + product_id).html(
                            data.cart[product_id]
                        );
                        $(".cart__total-span").html(data["total"] + "Đ");
                        $(".header__cart p").html(data["count"]);
                        // console.log(data);
                    },
                });
            }
        });
    });
}
function editAvatar() {
    imgAvatar.click();
}
loadItem(".list", 10, ".listPage");
loadItem(".listType", 5, ".listPaginationType");
loadItem(".listDetail", 10, ".listPageDetailConfiguration");
