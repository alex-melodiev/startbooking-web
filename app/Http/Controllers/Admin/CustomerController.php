<?php
/**
 * Customer Controller
 *
 * Customer Controller manages Customer by admin. 
 *
 * @category   Customer
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license    
 * @version    2.7
 * @link       http://techvill.net
 * @email      support@techvill.net
 * @since      Version 1.3
 * @deprecated None
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DataTables\CustomerDataTable;
use App\DataTables\PropertyDataTable;
use App\DataTables\BookingsDataTable;
use App\DataTables\PayoutsDataTable;
use App\Models\User;
use App\Models\UsersVerification;
use App\Models\Properties;
use App\Models\SpaceType;
use App\Models\Settings;
use App\Models\Accounts;
use App\Models\Country;
use App\Models\Bookings;
use App\Http\Helpers\Common;
use App\Http\Controllers\EmailController;
use Maatwebsite\Excel\Facades\Excel;
use Twilio\Rest\Client;
use PDF;
use DB;
use Session;

use Validator;

class CustomerController extends Controller
{
    protected $helper; 

    public function __construct()
    {
        $this->helper = new Common;
    }

    public function index(CustomerDataTable $dataTable)

 
    {
        $data['from'] = isset($_GET['from'])?$_GET['from']:null;
        $data['to']   = isset($_GET['to'])?$_GET['to']:null;
      

        if (isset($_GET['customer'])) {
            $data['customers'] = User::where('users.id', $_GET['customer'] )->select('id', 'first_name', 'last_name')->get();
        } else {
            $data['customers'] = null;
        }

        if (isset($_GET['reset_btn'])) {
            $data['from']        = null;
            $data['to']          = null;
            $data['allstatus']   = '';
            $data['allcustomers']   = '';
            return $dataTable->render('admin.customers.view', $data);
        }
        $pref = Settings::where('type', 'preferences')->get();
        if (! empty($pref)) {
            foreach ($pref as $value) {
                $prefer[$value->name] = $value->value;
            }
            Session::put($prefer);
        }

        isset($_GET['customer']) ? $data['allcustomers'] = $_GET['customer'] : $data['allcustomers']    = '';
        isset($_GET['status']) ? $data['allstatus'] = $allstatus = $_GET['status'] : $data['allstatus'] = $allstatus = '';

        return $dataTable->render('admin.customers.view', $data);
    }

    public function searchCustomer(Request $request)
    {   
        $str = $request->term;
        
        if($str == null) {
            $myresult = User::select('id', 'first_name', 'last_name')->take(5)->get();
        } else {
            $myresult = User::where('users.first_name', 'LIKE', '%'.$str.'%')->orWhere('users.last_name', 'LIKE', '%'.$str.'%')->select('users.id','users.first_name', 'users.last_name')->get();  
        }

        if($myresult->isEmpty()) {
            $myArr=null;
        } else {
            $arr2 = array(
                "id"   => "",
                "text" => "All"
              );
              $myArr[] = ($arr2);
            foreach ($myresult as $result) {
                $arr = array(
                  "id"   => $result->id,
                  "text" => $result->first_name." ".$result->last_name
                );
                $myArr[] = ($arr);  
            }
        }
        return $myArr;
    }

    public function add(Request $request, EmailController $email_controller)
    {
        if (! $_POST) {
            return view('admin.customers.add');
        } elseif ($_POST) {
            $rules = array(
                'first_name'    => 'required|max:255',
                'last_name'     => 'required|max:255',
                'email'         => 'required|max:255|email|unique:users',
                'password'      => 'required|min:6'
            );

            $fieldNames = array(
                'first_name'    => 'First_name',
                'last_name'     => 'Last_name',
                'email'         => 'Email',
                'password'      => 'Password'
            );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames); 

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); 
            } else {
                $user                  = new User;
                $user->first_name      = $request->first_name;
                $user->last_name       = $request->last_name;
                $user->email           = $request->email;
                $user->password        = \Hash::make($request->password);
                $user->status          = $request->status;
                $user->profile_image   = NULL;
                $formattedPhone        = str_replace('+' . $request->carrier_code, "", $request->formatted_phone);
                $user->phone           = !empty($request->phone) ? preg_replace("/[\s-]+/", "", $formattedPhone) : NULL;
                $user->default_country = isset($request->default_country) ? $request->default_country : NULL;
                $user->carrier_code    = isset($request->carrier_code) ? $request->carrier_code : NULL;
                $user->formatted_phone = isset($request->formatted_phone) ? $request->formatted_phone : NULL;
                  $user->save();


                $user_verification           = new UsersVerification;
                $user_verification->user_id  =   $user->id;
                $user_verification->save();

                $email_controller->welcome_email($user);
                $this->helper->one_time_message('success', 'Added Successfully');

                return redirect('admin/customers');
            }
        }
    }

    public function ajaxCustomerAdd(Request $request, EmailController $email_controller)
    { 
        $data = [];
        if($_POST) {
            $rules = array(
                'first_name'    => 'required|max:255',
                'last_name'     => 'required|max:255',
                'email'         => 'required|max:255|email|unique:users',
                'password'      => 'required|min:6'
            );

            $fieldNames = array(
                'first_name'    => 'First_name',
                'last_name'     => 'Last_name',
                'email'         => 'Email',
                'password'      => 'Password'
            );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames); 

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); 
            } else  {
            $user                  = new User;
            $user->first_name      = $request->first_name;
            $user->last_name       = $request->last_name;
            $user->email           = $request->email;
            $user->password        = \Hash::make($request->password);
            $user->status          = $request->status;
            $user->profile_image   = NULL;
            $formattedPhone        = str_replace('+' . $request->carrier_code, "", $request->formatted_phone);
            $user->phone           = !empty($request->phone) ? preg_replace("/[\s-]+/", "", $formattedPhone) : NULL;
            $user->default_country = isset($request->default_country) ? $request->default_country : NULL;
            $user->carrier_code    = isset($request->carrier_code) ? $request->carrier_code : NULL;
            $user->formatted_phone = isset($request->formatted_phone) ? $request->formatted_phone : NULL;
            $user->save();

            $user_verification           = new UsersVerification;
            $user_verification->user_id  =   $user->id;
            $user_verification->save();

            $data = ['status' => 1,'user' => $user];
        }
        return $data;
     }
   }
    public function customerProperties(PropertyDataTable $dataTable, $id)
    {
        $data['properties_tab'] = 'active';
        $data['user'] = DB::table('users')->where('id',$id)->first();

        $data['from'] = isset($_GET['from']) ? $_GET['from']:null;
        $data['to']   = isset($_GET['to']) ? $_GET['to']:null;
        $data['space_type_all'] = SpaceType::all('id','name');

        
        if (isset($_GET['reset_btn'])) {
            $data['from']        = null;
            $data['to']          = null;
            $data['allstatus']   = '';
            $data['allSpaceType']   = '';
            return $dataTable->render('admin.customerdetails.properties',$data);
        }
        isset($_GET['status']) ? $data['allstatus'] = $allstatus = $_GET['status'] : $data['allstatus'] = $allstatus = '';
        isset($_GET['space_type']) ? $data['allSpaceType'] = $_GET['space_type'] : $data['allSpaceType']  = '';

        return $dataTable->render('admin.customerdetails.properties',$data);

    }

    public function customerBookings(BookingsDataTable $dataTable, $id)
    {
        $data['bookings_tab'] = 'active';
        $data['user']         = DB::table('users')->where('id',$id)->first();

        $data['from'] = isset($_GET['from'])?$_GET['from']:null;
        $data['to'] = isset($_GET['to'])?$_GET['to']:null;
        if (isset($_GET['property'])) {
            $data['properties'] = Properties::where('properties.id',$_GET['property'] )->select('id', 'name')->get();
        } else {
            $data['properties'] = null;
        }
        if (isset($_GET['reset_btn'])) {
            $data['from']        = null;
            $data['to']          = null;
            $data['allstatus']   = '';
            $data['allproperties']   = '';
            return $dataTable->render('admin.customerdetails.bookings', $data);
        }
 
        isset($_GET['property']) ? $data['allproperties'] = $_GET['property'] : $data['allproperties'] = '';
        isset($_GET['status']) ? $data['allstatus'] = $_GET['status'] : $data['allstatus'] = '';
        return $dataTable->render('admin.customerdetails.bookings', $data);

    }

    public function customerPayouts(PayoutsDataTable $dataTable, $id)
    {
        $data['payouts_tab'] = 'active';
        $data['user'] = DB::table('users')->where('id',$id)->first();

        $data['from'] = isset($_GET['from'])?$_GET['from']:null;
        $data['to'] = isset($_GET['to'])?$_GET['to']:null;
        if (isset($_GET['property'])) {
            $data['properties'] = Properties::where('properties.id',$_GET['property'] )->select('id', 'name')->get();
        } else {
            $data['properties'] = null;
        }

        if (isset($_GET['reset_btn'])) {
            $data['from']        = null;
            $data['to']          = null;
            $data['allstatus']   = '';
            $data['alltypes']   = '';
            $data['allproperties']   = '';
            return $dataTable->render('admin.customerdetails.payouts', $data);
        }
        isset($_GET['property']) ? $data['allproperties'] = $_GET['property'] : $data['allproperties'] = '';
        isset($_GET['status']) ? $data['allstatus'] = $_GET['status'] : $data['allstatus'] = '';
        isset($_GET['types']) ? $data['alltypes'] = $_GET['types'] : $data['alltypes'] = '';

        return $dataTable->render('admin.customerdetails.payouts', $data);
    }

    public function paymentMethods($id)
    {
        $data['payment_methods_tab'] = 'active';
        $data['user'] = DB::table('users')->where('id',$id)->first();

        $data['payouts']  = Accounts::where('user_id', $id)->orderBy('id','desc')->get();
        $data['country']  = Country::all()->pluck('name','short_name');

        return view('admin.customerdetails.payment_methods', $data);
    }

    public function update(Request $request)
    {    $data['user'] = DB::table('users')->where('id',$request->id)->first();
        if (! $_POST) {   
            $data['customer_edit_tab'] = 'active';
           
            return view('admin.customers.edit', $data);
        } else if($_POST) {
            $rules = array(
                'first_name'    => 'required|max:255',
                'last_name'     => 'required|max:255',
                  'email'       => 'required|max:255|email|unique:users,email,'.$data['user']->id,
            );
             $messages = array(
                'email' => 'Email already existed.',
                
            );
         

            $fieldNames = array(
                'first_name'    => 'First Name',
                'last_name'     => 'Last Name',
                 'email'        => 'Email',

            );

            $validator = Validator::make($request->all(), $rules, $messages);
            $validator->setAttributeNames($fieldNames); 

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $user                  = User::find($request->customer_id);
                $user->first_name      = $request->first_name;
                $user->last_name       = $request->last_name;
                $user->email           = $request->email;
                $user->status          = $request->status;
                $user->profile_image   = NULL;
                $formattedPhone        = str_replace('+' . $request->carrier_code, "", $request->formatted_phone);
                $user->phone           = !empty($request->phone) ? preg_replace("/[\s-]+/", "", $formattedPhone) : NULL;
                $user->default_country = isset($request->default_country) ? $request->default_country : NULL;
                $user->carrier_code    = isset($request->carrier_code) ? $request->carrier_code : NULL;
                $user->formatted_phone = isset($request->formatted_phone) ? $request->formatted_phone : NULL;
                if ($request->password != '')
                    $user->password = bcrypt($request->password);
                $user->save();

                $this->helper->one_time_message('success', 'Updated Successfully');
                return redirect('admin/customers');
            }
        }
    }
    public function delete(Request $request)
    {
        $properties = Properties::where(['host_id' => $request->id])->get()->toArray();
        $bookings   = Bookings::where(['user_id' => $request->id])->get()->toArray();
        if (env('APP_MODE', '') != 'test') {
            if ((count($properties)) && (count($bookings)) > 0) {
                $this->helper->one_time_message('danger', 'Customer have properties and bookings.Sorry can not possible to delete.');                
            } else if (count($properties) > 0) {
                $this->helper->one_time_message('danger', 'Customer have properties.Sorry can not possible to delete.'); 
            } else if (count($bookings) > 0) {  
                $this->helper->one_time_message('danger', 'Customer have bookings.Sorry can not possible to delete.'); 
            } else {
                $user = User::find($request->id);
                if (!empty($user)) {
                    $user->delete();
                    $this->helper->one_time_message('success', 'Deleted Successfully');                    
                } else {
                    $this->helper->one_time_message('success', 'Deleted Successfully');                    
                }
            }
        }

        return redirect('admin/customers');
    }

    public function customerCsv()
    {
        
        $to                 = setDateForDb($_GET['to']);
        $from               = setDateForDb($_GET['from']);
        $status             = isset($_GET['status']) ? $_GET['status'] : 'null';
        $customer           = isset($_GET['customer']) ? $_GET['customer'] : 'null';
       
     
        
        
        $query = User::orderBy('id', 'desc')->select();

        if ($from) {

            $query->whereDate('created_at', '>=', $from);             
        }
        if ($to) {
            $query->whereDate('created_at', '<=', $to); 

        }               
        if ($status) {
            $query->where('status','=',$status);
        }
        if ($customer) {
            $query->where('id','=',$customer);
        }

        $customerList = $query->get();
      
        if ($customerList->count()) {
            foreach ($customerList as $key => $value)
                {
                    $data[$key]['Name']         = $value->first_name." ".$value->last_name;
                    $data[$key]['Email']        = $value->email;
                    $data[$key]['Status']       = $value->status;
                    $data[$key]['Created At']   = dateFormat($value->created_at);
                }
        }
        else {
            $data = null;
        }
            return Excel::create('customer_sheet' . time() . '', function ($excel) use ($data)
            {
                $excel->sheet('mySheet', function ($sheet) use ($data)
                {
                    $sheet->fromArray($data);
                });
            })->download('xls');        
    }

    public function customerPdf()
    {
        $to                   = setDateForDb($_GET['to']);
        $from                 = setDateForDb($_GET['from']);
        $data['companyLogo']  = $logo  = Settings::where('name','logo')->select('value')->first();
        $customer             = isset($_GET['customer']) ? $_GET['customer'] : 'null';
       
        
        if($logo->value==null) {
            $data['logo_flag'] = 0;
        } else if (!file_exists("public/front/images/logos/$logo->value")) {
            /* if 'logo_flag' is 0 then
            in pdf there will be a default error image */
            $data['logo_flag'] = 0;
        }
        $data['status']     = $status = isset($_GET['status']) ? $_GET['status'] : 'null';
        $query= User::orderBy('id', 'desc')->select();

        if ($from) {
            $query->whereDate('created_at', '>=', $from);             
        }
        if ($to) {
            $query->whereDate('created_at', '<=', $to);             
        }               
        if($status){
            $query->where('status','=',$status);
        }
        if($customer){
            $query->where('id','=',$customer);
        }
        if($from && $to){
          $data['date_range'] = onlyFormat($from) . ' To ' . onlyFormat($to);  
        }
        $data['customerList'] = $query->get();
        $pdf = PDF::loadView('admin.customers.list_pdf', $data, [], [
            'format' => 'A3', [750, 1060]
          ]);
          
        return $pdf->download('customer_list_' . time() . '.pdf', array("Attachment" => 0));
    }



    public function getCurrentCustomerDetails(Request $request) 
    {
        $data        = [];
        $userDetails = User::find($request->customer_id)->makeHidden(['created_at', 'updated_at', 'status', 'profile_image', 'balance', 'profile_src']);
        if ($userDetails->exists()) {
            $data['status']      = true;
            $data['userDetails'] = $userDetails;
        } else {
            $data['status']      = false;
        }
        return $data;
    }
}
