@extends('layouts.customer')
@section('title')
    Contact Us
@endsection
@section('content')
    <div class="contact-us">
        <div class="headl">
            <h1>Contact Us</h1>
            <h3>We're ready to lead you in the future of mobile marketing</h3></div>
    </div>
    <div class="container">
        <div class="contact-form">
            <div class="row">
                <p class="inTouch">Get in touch with us</p>
                <div class="col-md-6">
                    <form id="ajax-contact" method="post" action="/mail/contactUs" role="form">
                        <div class="messages" id="form-messages"></div>
                        <div class="controls">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_name">Firstname</label>
                                        <input id="form_name" type="text" name="first_name" class="form-control" placeholder="Please enter your firstname" required="required" data-error="Firstname is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_lastname">Lastname</label>
                                        <input id="form_lastname" type="text" name="last_name" class="form-control" placeholder="Please enter your lastname" required="required" data-error="Lastname is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_email">Email </label>
                                        <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter your email" required="required" data-error="Valid email is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_phone">Phone</label>
                                        <input id="form_phone" type="tel" name="phone" class="form-control" placeholder="Please enter your phone" required oninvalid="setCustomValidity('Plz enter your correct phone number ')" onchange="try{setCustomValidity('')}catch(e){}"> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="form_message">Message </label>
                                        <textarea id="form_message" name="message" class="form-control" placeholder="Message for me" rows="4" required="required" data-error="Please,leave us a message."></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn modalb" value="Send message"> </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <br> </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 info2">
                    <div class="info2"><img class="center-block" src="images/logo.png">
                        <hr>
                        <div class="row col1">
                            <div class="col-xs-3"> <i class="fa fa-map-marker" style="font-size:16px;"></i>   Address </div>
                            <div class="col-xs-9"> One Gateway Center, Suite 25500+, Newark 23. </div>
                        </div>
                        <div class="row col1">
                            <div class="col-sm-3"> <i class="fa fa-phone"></i>   Phone </div>
                            <div class="col-sm-9"> +(91) 123 277 4239 </div>
                        </div>
                        <div class="row col1">
                            <div class="col-sm-3"> <i class="fa fa-envelope"></i>   Email </div>
                            <div class="col-sm-9"> <a href="mailto:info@yourdomain.com">info@yourdomain.com</a>
                                <br> <a href="mailto:support@yourdomain.com">support@yourdomain.com</a> </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
@endsection