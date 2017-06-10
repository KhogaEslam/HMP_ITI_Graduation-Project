<?php
$GLOBALS['commentDisabled'] = "";
if (!Auth::check())
    $GLOBALS['commentDisabled'] = "disabled";
$GLOBALS['commentClass'] = -1;
?>

<!--            comments-->
<div class="container">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="page-header">
                <h3 class="reviews">Comments</h3>
            </div>
            <div class="laravelComment" id="laravelComment-{{ $comment_item_id }}">
                <div id="{{ $comment_item_id }}-comment-0">

                    {{--Start of input comment--}}
                    @role('customer')
                    <form class="laravelComment-form form-horizontal" id="{{ $comment_item_id }}-comment-form"
                          data-parent="0"
                          data-item="{{ $comment_item_id }}">
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Comment</label>
                            <div class=" col-sm-10">
                                <textarea class="form-control" name="addComment" id="0-textarea"
                                          rows="5" {{ $GLOBALS['commentDisabled'] }}></textarea>
                                @if(!Auth::check())
                                    <small>Please <a href="{{url('customer/login')}}">Log in</a> to comment</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="myButton  text-uppercase" id="submitComment"
                                       value="Comment" {{ $GLOBALS['commentDisabled'] }}>
                            </div>
                        </div>
                    </form>
                    @endrole
                    {{--End of input comment--}}

                    {{--Comments Section--}}
                    <ul class="media-list">
                        <?php
                        $GLOBALS['commentVisit'] = array();

                        function dfs($comment){
                        $GLOBALS['commentVisit'][$comment->id] = 1;
                        $GLOBALS['commentClass']++;
                        ?>
                        <li class="media">
                            <div class="show-{{ $comment->item_id }}"
                                 id="comment-{{ $comment->id }}">

                                <a class="pull-left"  href="{{ $comment->url or '' }}">
                                    <img class="media-object img-circle" src="{{ $comment->avatar }}" alt="profile">
                                </a>
                                <div class="media-body">
                                    <div class="well well-lg">
                                        <h4 class="media-heading text-uppercase reviews"> {{ $comment->name }} </h4>
                                        <ul class="media-date text-uppercase reviews list-inline">
                                            <li class="dd">{{ $comment->updated_at->diffForHumans() }}</li>
                                        </ul>
                                        <p class="media-comment"> {{ $comment->comment }}</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    {{--End of comments section--}}

                    <?php
                    }

                    $comments = \risul\LaravelLikeComment\Controllers\CommentController::getComments($comment_item_id);
                    foreach ($comments as $comment) {
                        if (!isset($GLOBALS['commentVisit'][$comment->id])) {
                            dfs($comment);
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

