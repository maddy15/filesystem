<?php

namespace App\Http\Controllers\Checkout;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;
use App\Http\Requests\Checkout\FreeCheckoutRequest;
use App\Sale;
use App\Jobs\Checkout\CreateSale;
use Stripe\Charge;

class CheckoutController extends Controller
{
    public function free(FreeCheckoutRequest $request,File $file)
    {
        if(!$file->isFree())
        {
            return back();
        }

        dispatch(new CreateSale($file,$request->email));

        
        return back()->withSuccess('We\'ve emailed your download link yo you');
    }

    public function payment(Request $request,File $file)
    {
        try{
            $charge = Charge::create([
                'amount' => $file->price * 100,
                'currency' => 'PHP',
                'source' => $request->stripeToken,
                'application_fee' => $file->calculateCommission() * 100
            ],[
                'stripe_account' => $file->user->stripe_id
            ]);

            
        }
            
       catch(\Exception $e)
       {
           return back()->withError('Something went wrong when processing payment.');
       }

       dispatch(new CreateSale($file,$request->stripeEmail));

        return back()->withSuccess('Payment Complete,We\'ve emailed your download link yo you');
    }
}
