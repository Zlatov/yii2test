$(document).ready(function() {
    $(".ul-drop").find("li:has(ul)").prepend('<div class="drop"></div>');
    $(".ul-drop div.drop").click(function() {
        if ($(this).nextAll("ul").css('display') == 'none') {
            $(this).nextAll("ul").slideDown(400);
            $(this).css({
                'background-position': "-11px 0"
            });
        } else {
            $(this).nextAll("ul").slideUp(400);
            $(this).css({
                'background-position': "0 0"
            });
        }
    });
    $(".ul-drop").find("ul").slideUp(400).parents("li").children("div.drop").css({
        'background-position': "0 0"
    });
    $(".ul-drop").before("<span class='a-action'>развернуть</span>").prev("span").css({
        "cursor": "pointer"
    }).on('click', function() {
        if ($(this).text() == "развернуть") {
            $(this).text("свернуть").next(".ul-drop").find("ul").slideDown(400).prevAll("div.drop").css({
                'background-position': "-11px 0"
            });
        } else {
            $(this).text("развернуть").next(".ul-drop").find("ul").slideUp(400).prevAll("div.drop").css({
                'background-position': "0 0"
            });
        }
    });
});