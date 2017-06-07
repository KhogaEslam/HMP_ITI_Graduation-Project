$(document).on('submit', '.laravelComment-form', function(){
    var parent = $(this).data('parent');
    var item_id = $(this).data('item');
    var comment = $('textarea#'+parent+'-textarea').val();

    if(comment !== '') {
        $.ajax({
            method: "get",
            url: "/laravellikecomment/comment/add",
            data: {parent: parent, comment: comment, item_id: item_id},
            dataType: "json"
        })
            .done(function (msg) {
                var newComment = '<li class="media">'+
                    '<div class="show--" id="comment-'+msg.id+'">'+
                    '<a class="pull-left"  href="">'+
                    '<img class="media-object img-circle" src="'+msg.userPic+'" alt="profile">'+
                    '</a>'+
                    '<div class="media-body">'+
                    '<div class="well well-lg">'+
                    '<h4 class="media-heading text-uppercase reviews">'+msg.userName+'</h4>'+
                    '<ul class="media-date text-uppercase reviews list-inline">'+
                    '<li class="dd">1 SECOND AGO</li>'+
                    '</ul>'+
                    '<p class="media-comment">'+msg.comment+'</p>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</li>';

                $('.media-list').prepend(newComment);
                $('textarea#'+parent+'-textarea').val('');
            })
            .fail(function (msg) {
                alert("Error!", msg);
            });
    }
        return false;
});