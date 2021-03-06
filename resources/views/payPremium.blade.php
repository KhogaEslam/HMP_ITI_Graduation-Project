@extends('layouts.vendor')
@section('title')
    Vendor | Subscribe
    @endsection
@section('content')
    <style type="text/css">
        .db-bk-color-one {
            background-color: #4db6ac;
        }
        .db-bk-color-two {
            background-color: #009688;
        }
        .db-bk-color-three {
            background-color: #00796b;
        }
        .db-bk-color-six {
            background-color: #F59B24;
        }
        .db-padding-btm {
            padding-bottom: 50px;
        }
        .db-button-color-square {
            color: #fff;
            background-color: rgba(0, 0, 0, 0.50);
            border: none;
            border-radius: 0px;
            font-size: 16px;
        }
        .db-button-color-square:hover {
            color: #fff;
            border: none;
        }
        .db-pricing-eleven {
            margin-bottom: 30px;
            margin-top: 50px;
            text-align: center;
            box-shadow: 0 0 5px rgba(0, 0, 0, .5);
            color: #fff;
            line-height: 30px;
        }
        .db-pricing-eleven ul {
            list-style: none;
            margin: 0;
            text-align: center;
            padding-left: 0px;
        }
        .db-pricing-eleven ul li {
            padding-top: 10px;
            padding-bottom: 10px;
            cursor: pointer;
        }
        .db-pricing-eleven ul li i {
            margin-right: 5px;
        }
        .db-pricing-eleven .price {
            /*background-color: rgba(0, 0, 0, 0.5);*/
            padding: 40px 20px 20px 20px;
            font-size: 60px;
            font-weight: 900;
            color: #FFFFFF;
        }
        .db-pricing-eleven .price small {
            color: white;
            display: block;
            font-size: 12px;
            margin-top: 22px;
        }
        .db-pricing-eleven .type {
            background-color: #ffca2b;
            padding: 30px 10px;
            font-weight: 900;
            text-transform: uppercase;
            font-size: 26px;
        }
        .db-pricing-eleven .pricing-footer {
            padding: 10px;
        }
        .db-pricing-eleven.popular {
            margin-top: 10px;
        }
        .db-pricing-eleven.popular .price {
            padding-top: 50px;
        }
    </style>
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12">
                <h3>Subscribe Now!</h3>
            </div>
        </div>

        <div class="row db-padding-btm db-attached">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="db-wrapper">
                    {!! Form::open(array('route' => 'getCheckout')) !!}
                    {!! Form::hidden('type','small') !!}
                    {!! Form::hidden('pay',10) !!}
                    <div class="db-pricing-eleven db-bk-color-one">
                        <div class="price">
                            <sup>$</sup>10
                            <small>per quarter</small>
                        </div>
                        <div class="type">
                            SMALL PLAN
                        </div>
                        <ul>
                            <li><i class="glyphicon glyphicon-print"></i>10 Products </li>
                            <li><i class="glyphicon glyphicon-time"></i>1 Featured Item/Quarter </li>
                        </ul>
                        <div class="pricing-footer">
                            <button class="btn db-button-color-square btn-lg">SUBSCRIBE</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="db-wrapper">
                    {!! Form::open(array('route' => 'getCheckout')) !!}
                    {!! Form::hidden('type','medium') !!}
                    {!! Form::hidden('pay',30) !!}
                    <div class="db-pricing-eleven db-bk-color-two popular">
                        <div class="price">
                            <sup>$</sup>30
                            <small>per quarter</small>
                        </div>
                        <div class="type">
                            MEDIUM PLAN
                        </div>
                        <ul>
                            <li><i class="glyphicon glyphicon-print"></i>30 Products </li>
                            <li><i class="glyphicon glyphicon-time"></i>3 Featured Item/Quarter </li>
                        </ul>
                        <div class="pricing-footer">
                            <button class="btn db-button-color-square btn-lg">SUBSCRIBE</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="db-wrapper">
                    {!! Form::open(array('route' => 'getCheckout')) !!}
                    {!! Form::hidden('type','advance') !!}
                    {!! Form::hidden('pay',50) !!}
                    <div class="db-pricing-eleven db-bk-color-three">
                        <div class="price">
                            <sup>$</sup>50
                            <small>per quarter</small>
                        </div>
                        <div class="type">
                            FULL PLAN
                        </div>
                        <ul>
                            <li><i class="glyphicon glyphicon-print"></i>50+ Products </li>
                            <li><i class="glyphicon glyphicon-time"></i>5 Featured Item/Quarter </li>
                        </ul>
                        <div class="pricing-footer">
                            <button class="btn db-button-color-square btn-lg">SUBSCRIBE</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection