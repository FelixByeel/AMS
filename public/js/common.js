//show or hidden profile-box
$(document).ready(function () {
    $("#profileBox").mouseover(function () {
        $(this).stop();
        $(this).animate({ height: '120px' }, 200);
    });

    $("#profileBox").mouseleave(function () {
        $(this).stop();
        $(this).animate({ height: '50px' }, 200);
    });
});


/*===================== go back ===========================*/
//通过go_back()跳转页面，附上原页面地址，可以在新页面返回原页面
function go_back(destination_uri) {
    var old_uri = window.location.href;

    window.location.href = destination_uri + "?uri=" + old_uri.replace(/_do\//, "/");
}

/*===================== layUI js model ===========================*/
layui.use(['element', 'form'], function () {
    var form = layui.form;
    var element = layui.element;
    form.render();
});

