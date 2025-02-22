<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Helpers\Common;

use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Models\Payouts;
use App\Models\Currency;
use App\Models\Country;
use App\Models\Settings;
use App\Models\PaymentMethods;
use App\Models\Payment;
use App\Models\Photo;
use App\Models\Withdraw;
use App\Models\Properties;
use App\Models\Bookings;
use App\Models\BookingDetails;
use App\Models\PropertyDates;
use App\Models\PropertyPrice;
use App\Models\Messages;
use Validator;
use DateTime;
use Session;
use Auth;
use App\Http\Controllers\EmailController;

class PaymentController extends Controller
{
    protected $helper;
    
    public function __construct()
    {
        $this->helper = new Common;
    }

    public function setup($way = 'PayPal_Express')
    {
        $paypal_data = Settings::where('type', 'PayPal')->pluck('value', 'name');
        $this->omnipay  = Omnipay::create($way);
        $this->omnipay->setUsername($paypal_data['username']);
        $this->omnipay->setPassword($paypal_data['password']);
        $this->omnipay->setSignature($paypal_data['signature']);
        $this->omnipay->setTestMode(($paypal_data['mode'] == 'sandbox') ? true : false);
        if ($way == 'Paypal_Express') {
            $this->omnipay->setLandingPage('Login');
        }
    }

    public function index(Request $request)
    {
        $special_offer_id = '';

        $data['paypal_status'] = Settings::where('name', 'paypal_status')
                                 ->where('type', 'PayPal')
                                 ->first();

        $data['stripe_status'] = Settings::where('name', 'stripe_status')
                                 ->where('type', 'Stripe')
                                 ->first();
        if ($_GET) {
            Session::put('payment_property_id', $request->property_id);
            Session::put('payment_checkin', date('d-m-Y', strtotime($request->checkin)));
            Session::put('payment_checkout', date('d-m-Y', strtotime($request->checkout)));
            Session::put('payment_number_of_guests', $request->number_of_guests);
            Session::put('payment_booking_type', 'instant');
            
            $id               = Session::get('payment_property_id');
            $checkin          = Session::get('payment_checkin');
            $checkout         = Session::get('payment_checkout');
            $number_of_guests = Session::get('payment_number_of_guests');
            $booking_type     = Session::get('payment_booking_type');
        } elseif ($_POST) {
            Session::put('payment_property_id', $request->id);
            Session::put('payment_checkin', $request->checkin);
            Session::put('payment_checkout', $request->checkout);
            Session::put('payment_number_of_guests', $request->number_of_guests);
            Session::put('payment_booking_type', $request->booking_type);
            
            $id               = Session::get('payment_property_id');
            $checkin          = Session::get('payment_checkin');
            $checkout         = Session::get('payment_checkout');
            $number_of_guests = Session::get('payment_number_of_guests');
            $booking_type     = Session::get('payment_booking_type');
        } else {
            $id               = Session::get('payment_property_id');
            $number_of_guests = Session::get('payment_number_of_guests');
            $checkin          = Session::get('payment_checkin');
            $checkout         = Session::get('payment_checkout');
            $booking_type     = Session::get('payment_booking_type');
        }
        
        if ( !$_POST && ! $checkin) {
            return redirect('properties/'.$request->id);
        }

        $data['result']           = Properties::find($id);
        $data['property_id']      = $id;
    
        $data['number_of_guests'] = $number_of_guests;
        $data['booking_type']     = $booking_type;
        $data['checkin']          = setDateForDb($checkin);
        $data['checkout']         = setDateForDb($checkout);
        
        $from                     = new DateTime(setDateForDb($checkin));
        $to                       = new DateTime(setDateForDb($checkout));
        $data['nights']           = $to->diff($from)->format("%a");
        $travel_credit = 0;

        $data['price_list']    = json_decode($this->helper->get_price($data['property_id'], $data['checkin'], $data['checkout'], $data['number_of_guests']));
        Session::put('payment_price_list', $data['price_list']);

        if (@$data['price_list']->status == 'Not available') {
            $this->helper->one_time_message('success', trans('messages.error.property_available_error'));
            return redirect('properties/'.$id);
        }
        $data['currencyDefault']  = $currencyDefault = Currency::where('default', 1)->first();

    
        $data['price_eur']        = $this->helper->convert_currency($data['result']->property_price->code, $currencyDefault->code, $data['price_list']->total);
        $data['price_rate']       = $this->helper->currency_rate($data['result']->property_price->currency_code, $currencyDefault->code);
        $data['country']          = Country::all()->pluck('name', 'short_name');
        $data['title']            = 'Pay for your reservation';

        return view('payment.payment', $data);
    }
    public function createBooking(Request $request)
    {
        $paypal_credentials = Settings::where('type', 'PayPal')->pluck('value', 'name');
        $currencyDefault    = Currency::where('default', 1)->first();
        
        $price_list     = json_decode($this->helper->get_price($request->property_id, $request->checkin, $request->checkout, $request->number_of_guests));

        $amount         = $this->helper->convert_currency($request->currency, $currencyDefault->code, $price_list->total);
        $country = $request->payment_country;
        $message_to_host = $request->message_to_host;
        $purchaseData   =   [
                            'testMode'  => ($paypal_credentials['mode'] == 'sandbox') ? true : false,
                            'amount'    => $amount,
                            'currency'  => $currencyDefault->code,
                            'returnUrl' => url('payments/success'),
                            'cancelUrl' => url('payments/cancel')
                            ];

        Session::put('amount', $amount);
        Session::put('payment_country', $country);
        Session::put('message_to_host_'.Auth::user()->id, $message_to_host);
        
        Session::save();
        
        if ($request->payment_method == 'stripe') {
            return redirect('payments/stripe');
        } else {
            $this->setup();
        }

        if ($amount) {
            $response = $this->omnipay->purchase($purchaseData)->send();
            if ($response->isSuccessful()) {
                $result = $response->getData();

                $data = [
                        'property_id'      => $request->property_id,
                        'checkin'          => $request->checkin,
                        'checkout'         => $request->checkout,
                        'number_of_guests' => $request->number_of_guests,
                        'transaction_id'   => $result['TRANSACTIONID'],
                        'price_list'       => $price_list,
                        'paymode'          => 'Credit Card',
                        'first_name'       => $request->first_name,
                        'last_name'        => $request->last_name,
                        'postal_code'      => $request->zip,
                        'country'          => $request->payment_country
                        ];

                $code = $this->store($data);
                
                $this->helper->one_time_message('success', trans('messages.success.payment_success'));
                return redirect('booking/requested?code='.$code);
            } elseif ($response->isRedirect()) {
                $response->redirect();
            } else {
                $this->helper->one_time_message('error', $response->getMessage());
                return redirect('payments/book/'.$request->property_id);
            }
        } else {
            $data = [
                    'property_id'      => $request->property_id,
                    'checkin'          => $request->checkin,
                    'checkout'         => $request->checkout,
                    'number_of_guests' => $request->number_of_guests,
                    'transaction_id'   => '',
                    'price_list'       => $price_list,
                    'paymode'          => 'PayPal',
                    'first_name'       => $request->first_name,
                    'last_name'        => $request->last_name,
                    'postal_code'      => $request->zip,
                    'country'          => $request->payment_country
                    ];

            $code = $this->store($data);
            $this->helper->one_time_message('success', trans('messages.success.payment_success'));
            return redirect('booking/requested?code='.$code);
        }
    }

    public function stripePayment(Request $request)
    {
        $id                       = Session::get('payment_property_id');
        $data['result']           = Properties::find($id);
        $data['property_id']      = $id;

        $checkin                  = Session::get('payment_checkin');
        $checkout                 = Session::get('payment_checkout');
        $number_of_guests         = Session::get('payment_number_of_guests');
        $booking_type             = Session::get('payment_booking_type');

        $data['checkin']          = setDateForDb($checkin);
        $data['checkout']         = setDateForDb($checkout);
        $data['number_of_guests'] = $number_of_guests;
        $data['booking_type']     = $booking_type;
        
        $from                     = new DateTime(setDateForDb($checkin));
        $to                       = new DateTime(setDateForDb($checkout));
        
        $data['nights']           = $to->diff($from)->format("%a");

        $data['price_list']       = Session::get('payment_price_list');

        $data['currencyDefault']  = $currencyDefault = Currency::where('default', 1)->first();

        $data['price_eur']        = $this->helper->convert_currency($data['result']->property_price->default_code, $currencyDefault->code, $data['price_list']->total);

        $data['price_rate']       = $this->helper->currency_rate($data['result']->property_price->currency_code, $currencyDefault->code);

        $stripe                   = Settings::where('type', 'Stripe')->pluck('value', 'name');
        $data['publishable']      = $stripe['publishable'];
        $data['title']            = 'Pay for your reservation';
        
        return view('payment.stripe', $data);
    }

    public function stripeRequest(Request $request)
    {
        $currencyDefault = Currency::where('default', 1)->first();
        
        if ($_POST) {
            if (isset($request->stripeToken)) {
                $id            = Session::get('payment_property_id');
                $result        = Properties::find($id);
                $price_list    = Session::get('payment_price_list');
                $price_eur     = $this->helper->convert_currency($result->property_price->code, $currencyDefault->code, $price_list->total);

                $stripe        = Settings::where('type', 'Stripe')->pluck('value', 'name');

                $gateway = Omnipay::create('Stripe');
                $gateway->setApiKey($stripe['secret']);
            
                $response = $gateway->purchase([
                    'amount' => $price_eur,
                    'currency' => $currencyDefault->code,
                    'token' => $request->stripeToken,
                ])->send();
                
                 
                if ($response->isSuccessful()) {
                    $token = $response->getTransactionReference();
                    $pm    = PaymentMethods::where('name', 'Stripe')->first();
                    $data  = [
                        'property_id'      => Session::get('payment_property_id'),
                        'checkin'          => Session::get('payment_checkin'),
                        'checkout'         => Session::get('payment_checkout'),
                        'number_of_guests' => Session::get('payment_number_of_guests'),
                        'transaction_id'   => $token,
                        'price_list'       => Session::get('payment_price_list'),
                        'country'          => Session::get('payment_country'),
                        'message_to_host'  => Session::get('message_to_host_'.Auth::user()->id),
                        'payment_method_id'=> $pm->id,
                        'paymode'          => 'Stripe'
                    ];
                   
                    $code = $this->store($data);

                    $this->helper->one_time_message('success', trans('messages.success.payment_complete_success'));
                    return redirect('booking/requested?code='.$code);
                } else {
                     $message = $response->getMessage();
                     $this->helper->one_time_message('success', $message);
                     return redirect('payments/book/'.Session::get('payment_property_id'));
                }
            } else {
                $this->helper->one_time_message('success', trans('messages.error.payment_request_error'));
                return redirect('payments/book/'.Session::get('payment_property_id'));
            }
        }
    }

    public function success(Request $request)
    {
        $this->setup();
        $currencyDefault = Currency::where('default', 1)->first();

        $transaction = $this->omnipay->completePurchase(array(
            'payer_id'              => $request->PayerID,
            'transactionReference'  => $request->token,
            'amount'                => Session::get('amount'),
            'currency'              => $currencyDefault->code
        ));

        $response = $transaction->send();

        $result = $response->getData();

        if (@$result['ACK'] == 'Success') {
            $pm = PaymentMethods::where('name', 'PayPal')->first();
            $data = [
                'property_id'      => Session::get('payment_property_id'),
                'checkin'          => Session::get('payment_checkin'),
                'checkout'         => Session::get('payment_checkout'),
                'number_of_guests' => Session::get('payment_number_of_guests'),
                'transaction_id'   => @$result['PAYMENTINFO_0_TRANSACTIONID'],
                'price_list'       => Session::get('payment_price_list'),
                'country'          => Session::get('payment_country'),
                'message_to_host'  => Session::get('message_to_host_'.Auth::user()->id),
                'payment_method_id'=> $pm->id,
                'paymode'          => 'PayPal'
                ];
            
            $code = $this->store($data);

            $this->helper->one_time_message('success', trans('messages.success.payment_success'));
            return redirect('booking/requested?code='.$code);
        } else {
            $this->helper->one_time_message('success', $result['L_SHORTMESSAGE0']);
            return redirect('payments/book/'.Session::get('payment_property_id'));
        }
    }

    public function cancel(Request $request)
    {
        $this->helper->one_time_message('success', trans('messages.error.payment_process_error'));
        return redirect('payments/book/'.Session::get('payment_property_id'));
    }

    public function store($data)
    { 
        $currencyDefault = Currency::where('default', 1)->first();
        $property_price_temp = PropertyPrice::where('property_id', $data['property_id'])->first();

        $booking = new Bookings;
        $booking->property_id       = $data['property_id'];
        $booking->host_id           = properties::find($data['property_id'])->host_id;
        $booking->user_id           = Auth::user()->id;
        $booking->start_date        = setDateForDb($data['checkin']);
        $checkinDate                =  onlyFormat($booking->start_date);
        $booking->end_date          = setDateForDb($data['checkout']);
        $booking->guest             = $data['number_of_guests'];
        $booking->total_night       = $data['price_list']->total_nights;
        $booking->per_night         = $this->helper->convert_currency('', $currencyDefault->code, $data['price_list']->property_price);

        $booking->custom_price_dates= isset($data['price_list']->different_price_dates_default_curr) ? json_encode($data['price_list']->different_price_dates_default_curr) : null ;
        
        $booking->base_price        = $this->helper->convert_currency('', $currencyDefault->code, $data['price_list']->subtotal);
        $booking->cleaning_charge   = $this->helper->convert_currency('', $currencyDefault->code, $data['price_list']->cleaning_fee);
        $booking->guest_charge      = $this->helper->convert_currency('', $currencyDefault->code, $data['price_list']->additional_guest);
        $booking->security_money    = $this->helper->convert_currency('', $currencyDefault->code, $data['price_list']->security_fee);
        $booking->service_charge    = $service_fee  = $this->helper->convert_currency('', $currencyDefault->code, $data['price_list']->service_fee);
        $booking->host_fee          = $host_fee     = $this->helper->convert_currency('', $currencyDefault->code, $data['price_list']->host_fee);
        $booking->total             = $total_amount = $this->helper->convert_currency('', $currencyDefault->code, $data['price_list']->total);
        
        $booking->currency_code     = $currencyDefault->code;
        $booking->transaction_id    = $data['transaction_id'];
        $booking->payment_method_id = $data['payment_method_id'];
        $booking->cancellation      = Properties::find($data['property_id'])->cancellation;
        $booking->status            = (Session::get('payment_booking_type') == 'instant') ? 'Accepted' : 'Pending';
        $booking->booking_type      = Session::get('payment_booking_type');
        if ($booking->status =='Accepted') {
            $companyName = Settings::where(['type' => 'general', 'name' => 'name'])->first(['value'])->value;
            $instantBookingConfirm = ($companyName.': ' .'Your booking is confirmed from'.' '. $booking->start_date.' '.'to'.' '.$booking->end_date );
            $instantBookingPaymentConfirm =($companyName.' ' .'Your payment is completed for'.' '.$booking->properties->name);
            
            twilioSendSms(\Auth::user()->formatted_phone, $instantBookingConfirm);
            twilioSendSms(\Auth::user()->formatted_phone, $instantBookingPaymentConfirm);
        } else {
            twilioSendSms(\Auth::user()->formatted_phone, 'Your booking is initiated, Wait for confirmation');

        }
       

        $booking->save();
        
        if ($data['paymode'] == 'Credit Card') {
            $booking_details['first_name']   = $data['first_name'];
            $booking_details['last_name ']   = $data['last_name'];
            $booking_details['postal_code']  = $data['postal_code'];
        }
        
        $booking_details['country']          = $data['country'];
        
        foreach ($booking_details as $key => $value) {
            $booking_details = new BookingDetails;
            $booking_details->booking_id = $booking->id;
            $booking_details->field = $key;
            $booking_details->value = $value;
            $booking_details->save();
        }

        do {
            $code = $this->helper->randomCode(6);
            $check_code = Bookings::where('code', $code)->get();
        } while (empty($check_code));

        $booking_code = Bookings::find($booking->id);

        $booking_code->code = $code;

        $booking_code->save();

        $days = $this->helper->get_days(setDateForDb($data['checkin']), setDateForDb($data['checkout']));
        
        
        
        for ($j=0; $j<count($days)-1; $j++) {
            $tmp_date = date('Y-m-d', strtotime($days[$j]));

            $property_data = [
                            'property_id' => $data['property_id'],
                            'status'      => 'Not available',
                            'price'       => $property_price_temp->original_price($tmp_date),
                            'date'        => $tmp_date,
                            ];

            PropertyDates::updateOrCreate(['property_id' => $data['property_id'], 'date' => $tmp_date], $property_data);
        }

        if ($booking->status == 'Accepted') {
            $payouts = new Payouts;
            $payouts->booking_id     = $booking->id;
            $payouts->user_id        = $booking->host_id;
            $payouts->property_id    = $booking->property_id;
            $payouts->user_type      = 'host';
            $payouts->amount         = $booking->original_host_payout;
            $payouts->penalty_amount = 0;
            $payouts->currency_code  = $booking->currency_code;
            $payouts->status         = 'Future';
            
            $payouts->save();
        }

        $message = new Messages;
        $message->property_id    = $data['property_id'];
        $message->booking_id     = $booking->id;
        $message->sender_id      = $booking->user_id;
        $message->receiver_id    = $booking->host_id;
        $message->message        = @$data['message_to_host'];
        $message->type_id        = 4;
        $message->read           = 0;
        $message->save();

        $email_controller = new EmailController;
        $email_controller->booking($booking->id, $checkinDate);

        Session::forget('payment_property_id');
        Session::forget('payment_checkin');
        Session::forget('payment_checkout');
        Session::forget('payment_number_of_guests');
        Session::forget('payment_booking_type');

        return $code;
    }

    public function withdraws(Request $request)
    {
        $photos = Photo::where('user_id', \Auth::user()->id)->get();
        $photo_ids = [];
        foreach ($photos as $key => $value) {
            $photo_ids[] = $value->id;
        }
        $payment_sum = Payment::whereIn('photo_id', $photo_ids)->sum('amount');
        $withdraw_sum = Withdraw::where('user_id', Auth::user()->id)->sum('amount');
        $data['total'] = $total = $payment_sum - $withdraw_sum;
        if ($_POST) {
            if ($total >= $request->amount) {
                $withdraw = new Withdraw;
                $withdraw->user_id = Auth::user()->id;
                $withdraw->amount = $request->amount;
                $withdraw->status = 'Pending';
                $withdraw->save();
                $data['success'] = 1;
                $data['message'] = 'Success';
            } else {
                $data['success'] = 0;
                $data['message'] = 'Balance exceed';
            }
            echo json_encode($data);
            exit;
        }
       
        $data['details'] = Auth::user()->details_key_value();
        $data['results'] = Withdraw::where('user_id', Auth::user()->id)->get();
        return view('payment.withdraws', $data);
    }
}
