(function () {
    var loaderText = document.getElementById("loading-msg");
    loaderText.innerHTML = "กำลังดาวน์โหลดข้อมูล";
})();

$(function (e) {
    $(".preloader").hide();
    $("body").css("overflow-y", "scroll");
});
