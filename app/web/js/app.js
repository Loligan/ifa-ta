
function refreshTop() {
    $("#last_stats").text("Loading...");
    $("#pause_top").text("Loading...");
    $("#in_progress_top").text("Loading...");
    $.ajax({
        type: "POST",
        timeout: 30000,
        url: "/last_stats",
        contentType: "application/json"
    }).done(function (data) {
        $("#last_stats").removeClass("loading");
        $("#last_stats").text(
            "TR: " + data["test_range"] +
            " F: " + data["fail"] +
            " P: " + data["pass"] +
            " IP: " + data["in_progress"]
        );
    })
        .fail(function (data) {
            console.log("fail");
            $("#last_stats").text("FAIL LOADING!");
        });


    $.ajax({
        type: "POST",
        timeout: 30000,
        url: "/get_queue_number_test_pause",
        contentType: "application/json"
    }).done(function (data) {
        $("#pause_top").removeClass("loading");
        $("#pause_top").text("Pause: " + data['pause']);
    })
        .fail(function (data) {
            console.log("fail");
            $("#pause_top").text("FAIL LOADING!");
        });

    $.ajax({
        type: "POST",
        timeout: 30000,
        url: "/get_queue_number_test",
        contentType: "application/json"
    }).done(function (data) {
        $("#in_progress_top").removeClass("loading");
        $("#in_progress_top").text("In progress: " + data['in_progress']);
    })
        .fail(function (data) {
            console.log("fail");
            $("#in_progress_top").text("FAIL LOADING!");
        });

    console.log('pass');
};
refreshTop();

$("#refresh_all_top").click(function () {
    refreshTop();
});

setInterval(function() {
   refreshTop()
}, 5000);


$('.list .master.checkbox')
    .checkbox({
        // check all children
        onChecked: function() {
            var
                $childCheckbox  = $(this).closest('.checkbox').siblings('.list').find('.checkbox')
            ;
            $childCheckbox.checkbox('check');
        },
        // uncheck all children
        onUnchecked: function() {
            var
                $childCheckbox  = $(this).closest('.checkbox').siblings('.list').find('.checkbox')
            ;
            $childCheckbox.checkbox('uncheck');
        }
    })
;