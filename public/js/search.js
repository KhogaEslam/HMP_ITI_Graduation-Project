$(document).ready(function() {
    $("input[name=search_name]").keyup(function(e) {
        if(this.value.length > 0) {
            console.log(this.value);
            $.ajax({
                "url": "/api/search/",
                "method": "get",
                "dataType": "json",
                "data": {"prefix": this.value},
                "success": function(res) {
                    console.log(res);
                    var n = res.length;
                    if($(".results").is(":hidden")) {
                        $(".results").fadeOut(200, function () {
                            $(".results").empty();
                            for (var i = 0; i < n; i++) {
                                $(".results").append("<li><a id='search_result_" + i + "' class='search_result'><span>" + res[i] + "</span></a></li>");
                            }
                            $(".results").slideDown();
                        });
                    }
                    else {
                        $(".results").empty();
                        for (var i = 0; i < n; i++) {
                            $(".results").append("<li><a id='search_result_" + i + "' class='search_result'><span>" + res[i] + "</span></a></li>");
                        }
                    }
                },
                "error": function(jqXHR, status, errorThrown) {
                    console.log("xhr", jqXHR);
                    console.log("status", status);
                    console.log("err", errorThrown);
                }
            })
        }
        else {
            $(".results").slideUp(200, function() {
                $(".results").hide();
            });
        }
    });
});