//outstock search condition
$(document).ready(function () {
    $("#out_search_btn").click(function () {

        let query_string = "";

        if ($("#consumer_code").val().length != 0) {
            query_string += "consumer_code=" + $("#consumer_code").val();
            query_string += "&";
        }

        /*         if ($("#consumer_name").val().length != 0) {
                    query_string += "consumer_name=" + $("#consumer_name").val();
                    query_string += "&";
                } */

        if ($("#computer_barcode").val().length != 0) {
            query_string += "computer_barcode=" + $("#computer_barcode").val();
            query_string += "&";
        }

        if ($("#nick_name").val().length != 0) {
            query_string += "nick_name=" + $("#nick_name").val();
            query_string += "&";
        }

        if (query_string.lastIndexOf("&") + 1 === query_string.length) {
            query_string = query_string.substr(0, query_string.length - 1);
        }

        let uri = window.location.href.split('list')[0] + 'list';

        window.location.href = uri + (query_string.length == 0 ? "" : "?" + query_string);
    });

    $("#out_reset_btn").click(function () {
        $("#consumer_code").val("");
        $("#consumer_name").val("");
        $("#computer_barcode").val("");
        $("#nick_name").val("");
    });
});
