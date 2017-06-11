<?php

namespace App\Http\Controllers;

use App\PlanUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Paypal;
use App\VendorPlan;

class PaypalController extends Controller
{

    private $_apiContext;

    public function __construct()
    {
        $this->middleware(["employee.auth"]);

        $this->_apiContext = PayPal::ApiContext(
            config('services.paypal.client_id'),
            config('services.paypal.secret'));

        $this->_apiContext->setConfig(array(
            'mode' => 'sandbox',
            'service.EndPoint' => 'https://api.sandbox.paypal.com',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'FINE'
        ));

    }

    public function payPremium()
    {
        return view('payPremium');
    }

    public function getCheckout(Request $request)
    {
        $payer = PayPal::Payer();
        $payer->setPaymentMethod('paypal');

        $amount = PayPal:: Amount();
        $amount->setCurrency('USD');
        $amount->setTotal($request->input('pay'));

        $transaction = PayPal::Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription('Subscribe '.$request->input('type').' Plan on '.$request->input('pay'));

        $redirectUrls = PayPal:: RedirectUrls();
        $redirectUrls->setReturnUrl(route('getDone'));
        $redirectUrls->setCancelUrl(route('getCancel'));

        $payment = PayPal::Payment();
        $payment->setIntent('sale');
        $payment->setPayer($payer);
        $payment->setRedirectUrls($redirectUrls);
        $payment->setTransactions(array($transaction));

        $response = $payment->create($this->_apiContext);
        $redirectUrl = $response->links[1]->href;

        return redirect()->to( $redirectUrl );
    }

    public function getDone(Request $request)
    {
        $id = $request->get('paymentId');
        $token = $request->get('token');
        $payer_id = $request->get('PayerID');

        $payment = PayPal::getById($id, $this->_apiContext);

        $paymentExecution = PayPal::PaymentExecution();

        $paymentExecution->setPayerId($payer_id);
        $executePayment = $payment->execute($paymentExecution, $this->_apiContext);

//        echo "<pre>";
//        dd($executePayment->transactions[0]->amount->total);
        $planUser = new PlanUser;
        if((double)$executePayment->transactions[0]->amount->total === 10.0){
            $user = Auth::user();
            $plan = VendorPlan::find(1);
            $planUser->user()->associate($user);
            $planUser->plan()->associate($plan);
            $planUser->save();
        }
        elseif ((double)$executePayment->transactions[0]->amount->total === 30.0){
            $user = Auth::user();
            $plan = VendorPlan::find(2);
            $planUser->user()->associate($user);
            $planUser->plan()->associate($plan);
            $planUser->save();
        }
        elseif ((double)$executePayment->transactions[0]->amount->total === 50.0){
            $user = Auth::user();
            $plan = VendorPlan::find(3);
            $planUser->user()->associate($user);
            $planUser->plan()->associate($plan);
            $planUser->save();
        }
        else{
            return redirect()->route('payPremium');
        }

        return redirect()->action("VendorController@index");
    }

    public function getCancel()
    {
        return redirect()->route('payPremium');
    }
}
