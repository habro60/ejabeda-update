
function unitChange() {
    var item_no = $('.item_no').val();
    $.ajax({
        type: "POST",
        url: "../purchase/getCashPurchase.php",
        data: {
            item_no: item_no
        },
        dataType: "text",
        success: function (response) {
            $('.item_unit').val(response);
            $(".item_unit").removeClass("loader");
        }
    });
}

function unitChangeRow(count) {
    var item_no = $('#item_no' + count).val();
    $.ajax({
        type: "POST",
        url: "../purchase/getCashPurchase.php",
        data: {
            item_no: item_no
        },
        dataType: "text",
        success: function (response) {
            $('#item_unit' + count).val(response);
        }
    });
}




