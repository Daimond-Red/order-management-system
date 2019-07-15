<?php

namespace App\Http\Controllers\Api;

use App\Basecode\Classes\Repositories\BookingRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;
use App\Basecode\Classes\Transformers\BookingTrans;
use App\Basecode\Classes\Transformers\DriverTrans;
use App\Basecode\Classes\Repositories\UserRepository;
use App\Booking;
use App\BookingBid;
use App\AssignVehicleDriver;
use App\RatingReview;
use App\User;
use App\ContactUs;
use App\BookingAllocate;

class BookingController extends ApiController
{
    public $repository, $userRepository, $permission;

    function __construct(Repository $repository, Permission $permission, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->repository = $repository;
        $this->permission = $permission;
    }

    public function index() {

        if(! $this->permission->index() ) return noAuth();
        
        if( !in_array(auth()->user()->type, [User::VENDOR, User::DRIVER]) ) return appError('Invalid user'); 
        
        $collection = $this->repository->getCollection();
        
        if(auth()->user()->is_set_location) {
            
            $startCities = $this->userRepository->getVehicleStartCityList();
            $endCities = $this->userRepository->getVehicleEndCityList();

            $collection =  $collection->whereIn('city_id', $startCities);

            if(count($endCities) > 0) $collection = $collection->whereIn('drop_location_city_id', $endCities);
        }

        if( request('withPagination') ) {
            $collection = $collection->paginate(5);
            $collection = [
                'page'      => $collection->currentPage(),
                'count'     => $collection->total(),
                'perPage'   => 5,
                'data'      => $this->repository->parseCollection($collection)
            ];
        } else {
            $collection = ( new BookingTrans )->parseCollection($collection->get());
        }
        
        return appData($collection);

    }

    public function vendorBookings() {

        if(! $this->permission->index() ) return noAuth();
        
        if( !in_array(auth()->user()->type, [User::VENDOR, User::DRIVER]) ) return appError('Invalid user'); 

        $collection = $this->repository->getCollection()->whereNotIn('status', [Booking::EXPIRED])->get();
            // ->whereIn('status', [Booking::PENDING, Booking::BOOKING_HAS_BID]);
        $data = [];
        if(count($collection)) {
            foreach ($collection as $model) {
                $checkVendorRel = false;

                if($model->vendor_id == auth()->user()->id) {
                    $checkVendorRel = true;
                } else {
                    $bidModel = $model->bookingBidRel()->where('booking_bids.vendor_id', auth()->user()->id)
                        ->first();

                    if($bidModel) $checkVendorRel = true;
                }

                if($checkVendorRel) $data[] = ( new BookingTrans )->parseModel($model);
            }
        }
        
        return appData($data);

    }

    public function customersBooking() {
        
        if( !in_array(auth()->user()->type, [User::INDIVIDUAL_CUSTOMER, User::COMMERCIAL_CUSTOMER]) ) return appError('Invalid user');

        $collection = $this->repository->getCollection()
            ->where('customer_id', auth()->user()->id)
            ->get();

        return appData( ( new BookingTrans )->parseCollection($collection) );
        
    }

    public function store() {

        if(! $this->permission->create() ) return noAuth();

        if( $err = cvalidate( getValidationRules($this->repository->storeValidateRules)) ) return appError($err->first());

        if( !in_array(auth()->user()->type, [User::INDIVIDUAL_CUSTOMER, User::COMMERCIAL_CUSTOMER]) ) return appError('Invalid user');

        if(auth()->user()->status != 1) return appError('Your account is verified yet.');
            
        $model = $this->repository->save($this->repository->getAttrs());

        $vendorIds = User::where('type', User::VENDOR)
            ->where('city_id', $model->city_id)
            ->pluck('id')
            ->toArray();
        if(count($vendorIds) > 0 ) {
            
            $msg = str_replace('{pickup_city}', optional($model->cityRel)->title, _t('quote_request_11'));
            $msg = str_replace('{drop_city}', optional($model->dropLocationCityRel)->title, $msg);

            sendPushNotification($vendorIds, [
                'booking_id'    => $model->id,
                'category'      => 'booking_create',
                'body'          => $msg,
                'title'         => _t_title('quote_request_11')
            ]);
        }
        

        return appModelData( ( new BookingTrans )->parseModel($model), $this->repository->create_msg);

    }

    public function bidStore() {

        $rules = [
            'booking_id' => 'required|exists:bookings,id', 
            'amount' => 'required',
            'date' => 'required',
            'time' => 'required'
        ];

        if( $err = cvalidate($rules) ) return appError($err->first());

        if( !in_array(auth()->user()->type, [User::VENDOR]) ) return appError('Invalid user');

        $bookingModel = $this->repository->getModel()
            ->where('id', \request('booking_id'))
            ->first();

        if(!$bookingModel) return appError('Invalid booking.');

        if( !in_array($bookingModel->status, [Booking::PENDING, Booking::BOOKING_HAS_BID])) return appError('Bad Request.');


        $vendorId = (!\request('vendor_id')) ? auth()->user()->id : \request('vendor_id');

        $allocateModel = BookingAllocate::where('booking_id', $bookingModel->id)
            ->where('vendor_id', $vendorId)->first();

        if(!$allocateModel) return appError('You are not allowed to bid on this order.');

        $model = BookingBid::where('booking_id', $bookingModel->id)
            ->where('vendor_id', $vendorId)
            ->first();

        if($model) return appModelData([], 'You already have a bid on this order.');

        $model = new BookingBid;

        $model->booking_id = $bookingModel->id;
        $model->customer_id = $bookingModel->customer_id;
        $model->amount = \request('amount');
        $model->vendor_id = $vendorId;
        
        if( ( $date = \request('date') ) && ( $time = \request('time')) ) $model->pickup_date_time = date('Y-m-d', strtotime($date)). ' '. date('H:i:s', strtotime($time));

        $model->save();

        if($bookingModel->status == Booking::PENDING){
            $bookingModel->status = Booking::BOOKING_HAS_BID;
            $bookingModel->save();
        }

        $this->repository->saveBookingLog($bookingModel, $vendorId);
        $msg = str_replace('{order_no}', $bookingModel->order_no, _t('you_have_received_a_bid_6'));
        
        
        sendPushNotification($bookingModel->customer_id, [
            'booking_id'    => $bookingModel->id,
            'category'      => 'booking_bid',
            'body'          => $msg,
            'title'         => _t_title('you_have_received_a_bid_6')
        ]);

        return appModelData($model, 'Bid submited successfully.');

    }

    public function bidIndex() {

        if( $err = cvalidate(['booking_id' => 'required|exists:bookings,id']) ) return appError($err->first());

        if( !in_array(auth()->user()->type, [User::INDIVIDUAL_CUSTOMER, User::COMMERCIAL_CUSTOMER]) ) return appError('Invalid user');

        $collection = BookingBid::where('booking_id', \request('booking_id'))->get();

        return appData( ( new BookingTrans )->parseBidCollection($collection) ); 
    }

    public function confirmBid() {

        if( $err = cvalidate(['bid_id' => 'required|exists:booking_bids,id']) ) return appError($err->first());

        if( !in_array(auth()->user()->type, [User::INDIVIDUAL_CUSTOMER, User::COMMERCIAL_CUSTOMER]) ) return appError('Invalid user');

        $model = BookingBid::where('id', \request('bid_id'))->first();

        if(!$model) return appError('Bad Request.');

        $model->status = BookingBid::ACCEPTED;

        $model->save();

        BookingBid::where('booking_id', $model->booking_id)
            ->where('id', '!=', \request('bid_id'))
            ->update(['status' => BookingBid::CANCEL]);

        $bookingModel = $this->repository->getModel()->where('id', $model->booking_id)->first();

        $bookingModel->status = Booking::BID_CONFIRM;
        $bookingModel->vendor_id = $model->vendor_id;
        $bookingModel->booking_amount = $model->amount;

        $bookingModel->save();
        
        
        $msg = str_replace('{order_no}', $bookingModel->order_no, _t('bid_confirmed_14'));
        
        sendPushNotification($bookingModel->vendor_id, [
            'booking_id'    => $bookingModel->id,
            'category'      => 'confirm_vendor',
            'body'          => $msg,
            'title'         => _t_title('bid_confirmed_14')
        ]);

        $this->repository->saveBookingLog($bookingModel, $model->vendor_id);

        return appModelData( ( new BookingTrans)->parseBidModel($model), 'Bid confirmed');
    }

    public function assignVehicleDriver() {
        $rules = [
            'booking_id' => 'required',
            'drivers' => 'required',
            'vehicles' => 'required' 
        ];

        if( $err = cvalidate($rules) ) return appError($err->first());

        if( !in_array(auth()->user()->type, [User::VENDOR]) ) return appError('Invalid user');

        $driverIds = explode(',', \request('drivers'));

        $vehicleIds = explode(',', \request('vehicles'));

        if(count($driverIds) != count($vehicleIds)) return appError('Bad Request.');

        $bookingModel = $this->repository->getModel()
            ->where('id', \request('booking_id'))
            ->whereIn('status', [Booking::BID_CONFIRM])
            ->first();

        if(!$bookingModel) return appError('Bad Request.');

        foreach ($driverIds as $key => $value) {

            $model = new AssignVehicleDriver;

            $model->booking_id = $bookingModel->id;
            $model->driver_id = $value;
            $model->vehicle_id = $vehicleIds[$key];

            $model->save();
        }

        $bookingModel->status = Booking::ASSIGN_DRIVER_VEHICLE;
        $bookingModel->save();

        $this->repository->saveBookingLog($bookingModel, $bookingModel->vendor_id);

        // $msg = "Assign vehicle and driver for the order(". $bookingModel->order_no .")";

        $vehicleDriverRel = $bookingModel->vehicleDriverRel()->first();


        $msg = str_replace('{order_no}', $bookingModel->order_no, _t('order_update_10'));
        // $msg = str_replace('{vendor_name}', optional($bookingModel->vendorRel)->name, $msg);
        $msg = str_replace('{vehicle_no}', optional($vehicleDriverRel->vehicleRel)->vehicle_num, $msg);
        $msg = str_replace('{driver_name}', optional($vehicleDriverRel->driverRel)->name, $msg);
        // Case when multiple drivers and vehicle assigned.
        
        sendPushNotification($bookingModel->customer_id, [
            'booking_id'    => $bookingModel->id,
            'category'      => 'assign_vehicle_driver',
            'body'          => $msg,
            'title'         => _t_title('order_update_10')
        ]);

        return appModelData( [], 'Vehicle and driver assigned successfully.');

    }

    public function outForDelivery() {

        if( $err = cvalidate(['booking_id' => 'required|exists:bookings,id']) ) return appError($err->first());

        if( !in_array(auth()->user()->type, [User::DRIVER, User::VENDOR]) ) return appError('Invalid user');

        $bookingModel = $this->repository->getModel()
            ->where('id', \request('booking_id'))
            ->first();

        $bookingModel->status = Booking::OUT_FOR_DELIVERY;

        $bookingModel->save();

        $this->repository->saveBookingLog($bookingModel, $bookingModel->vendor_id);


        $msg = str_replace('{order_no}', $bookingModel->order_no, _t('order_update_7'));
        $msg = str_replace('{order_status}', 'OUT FOR DELIVERY', $msg);

        sendPushNotification([$bookingModel->customer_id, $bookingModel->vendor_id], [
            'booking_id'    => $bookingModel->id,
            'category'      => 'out_for_delivery',
            'body'          => $msg,
            'title'         => _t_title('order_update_7')
        ]);

        return appModelData([], 'Driver has reached out for delivery.');
    }

    public function requestForCompleteBooking() {
        
        try {

            if( $err = cvalidate(['booking_id' => 'required|exists:bookings,id']) ) return appError($err->first());

            if( !in_array(auth()->user()->type, [User::DRIVER, User::VENDOR]) ) return appError('Invalid user');

            $bookingModel = $this->repository->getModel()
                ->where('id', \request('booking_id'))
                ->first();

            $bookingModel->otp = sendOtp(optional($bookingModel->customerRel)->mobile_no);
            $bookingModel->otp_created_at = date('Y-m-d H:i:s');

            $bookingModel->save();

            $msg = "The Driver has reached the destination. Please confirm with OTP ( " . $bookingModel->otp . ")";
            
            sendPushNotification($bookingModel->customer_id, [
                'booking_id'    => $bookingModel->id,
                'category'      => 'otp_send',
                'body'          => $msg,
                'title'         => 'Request For Complete'
            ]);

            return appModelData([], 'OTP sent successfully');
        } catch(Exception $e) {
            return '';
        }
    }

    public function markAsCompleted() {

        $rules = [
            'booking_id' => 'required|exists:bookings,id',
            'otp' => 'required|exists:bookings,otp',
            'signature' => 'required'
        ];

        if( $err = cvalidate($rules) ) return appError($err->first());

        if( !in_array(auth()->user()->type, [User::DRIVER, User::VENDOR]) ) return appError('Invalid user');

        $bookingModel = $this->repository->getModel()
            ->where('id', \request('booking_id'))
            ->where('otp', \request('otp'))
            ->first();

        if(!$bookingModel) return appError('Bad request.');

        $bookingModel->status = Booking::COMPLETED;
        $bookingModel->otp = null;
        $bookingModel->otp_created_at = null;
        $bookingModel->signature = \request('signature');

        $bookingModel->save();

        $this->repository->saveBookingLog($bookingModel, $bookingModel->vendor_id);

        $msg = str_replace('{order_no}', $bookingModel->order_no, _t('order_delivered_9'));

        sendPushNotification([$bookingModel->customer_id, $bookingModel->vendor_id], [
            'booking_id'    => $bookingModel->id,
            'category'      => 'booking_completed',
            'body'          => $msg,
            'title'         => _t_title('order_delivered_9')
        ]);

        return appModelData([], 'Booking completed successfully.');
    }

    public function ratingReview() {
        
        $rules = [
            'booking_id' => 'required|exists:bookings,id',
            'user' => 'required|in:customer,vendor',
            'rating' => 'required|in:1,2,3,4,5',
        ];

        if( $err = cvalidate($rules) ) return appError($err->first());

        $model = $this->repository->getModel()
            ->where('id', \request('booking_id'))
            ->where('status', Booking::COMPLETED)
            ->first();

        if(!$model) return appError('Bad Request.');

        if(\request('user') == 'customer') {
            
            $model->is_rated_by_customer = 1;
            $model->vendor_rating = \request('rating');

            if($val = \request('title')) $model->customer_review_title = $val;

            if($val = \request('review')) $model->customer_review = $val;

        } else if(\request('user') == 'vendor') {

            $model->is_rated_by_vendor = 1;
            $model->customer_rating = \request('rating');

            if($val = \request('title')) $model->vendor_review_title = $val;

            if($val = \request('review')) $model->vendor_review = $val;

        } else {
            return appError('Bad Request.');
        }
        
        $model->save();
        
        return appModelData([], 'Thanks for giving your review.');
    }


    public function customerHistory() {
        $collection = $this->repository->getCollection()
            ->whereIn('status', [Booking::PENDING, Booking::COMPLETED, Booking::CANCEL])
            ->where('customer_id', auth()->user()->id)
            ->get();

        return appData( ( new BookingTrans )->parseCollection($collection) );
    }

    public function vendorHistory() {
        $collection = $this->repository->getCollection()
            ->whereIn('status', [Booking::COMPLETED, Booking::CANCEL])
            ->where('vendor_id', auth()->user()->id)
            ->get();

        return appData( ( new BookingTrans )->parseCollection($collection) );
    }

    public function cancelBooking() {
        
        if( $err = cvalidate(['booking_id' => 'required|exists:bookings,id']) ) return appError($err->first());

        if(!in_array(auth()->user()->type, [User::INDIVIDUAL_CUSTOMER, User::COMMERCIAL_CUSTOMER, User::VENDOR]) ) return appError('Invalid User.');

        $model = $this->repository->getModel()
            ->where('id', \request('booking_id'))
            ->first();
        
        if( $model->status > 3) return $this->error([], 'You cannot cancel the request');

        if(!$model) return appError('Bad Request.');

        $model->status = Booking::CANCEL;

        $model->save();

        $this->repository->saveBookingLog($model, $model->vendor_id);

        // $msg = "";

        // sendPushNotification([$model->customer_id], [
        //     'booking_id'    => $model->id,
        //     'category'      => 'booking_cancel',
        //     'body'          => $msg
        // ]);

        return appModelData( ( new BookingTrans )->parseModel($model), "Booking cancelled");

        
    }

    public function findLoad() {
        
        $userModel = User::where('id', auth()->user()->id)->first();

        if(!$userModel) return appError('Invalid User');

        $collection = $this->repository->getCollection();
        
        if($val = \request('city_id')) $collection = $collection->where('city_id', $val);

        if($val = \request('drop_location_city_id')) $collection = $collection->where('drop_location_city_id', $val);

        if($val = \request('vehicle_type_id')) $collection = $collection->where('vehicle_type_id', $val);

        $collection = $collection->take(10)->get();

        return appData( ( new BookingTrans )->parseCollection($collection) );
    }

    public function statusUpdate() {
        $rules = [
            'booking_id'    => 'required|exists:bookings,id',
            'status'    =>  'required|in:3,4,5,6,11,12'
        ];

        if($err = cvalidate($rules)) return appError($err->first());

        $booking = $this->repository->find(request('booking_id'));

        if( $booking->status > 3 && \request('status') == 3) return appError('You are not allowed to mark cancel');

        $booking->status = \request('status');

        $booking->save();

        $this->repository->saveBookingLog($booking, $booking->vendor_id);

        $msg = '';
        
        $updateMsg = str_replace('{order_no}', $booking->order_no, _t('order_update_7'));

        if( \request('status') == Booking::CANCEL ) {
            $msg = str_replace('{order_status}', 'CANCEL', $updateMsg);
        } elseif( \request('status') == Booking::BID_CONFIRM ) {
            $msg = str_replace('{order_status}', 'BID CONFIRM', $updateMsg);
        } elseif( \request('status') == Booking::LIVE ) {
            $msg = str_replace('{order_no}', $booking->order_no, _t('order_update_13'));
            
            $vehicleDriverRel = $booking->vehicleDriverRel()->first();

            $msg = str_replace('{driver_name}', optional($vehicleDriverRel->driverRel)->name, $msg);
        } elseif( \request('status') == Booking::ASSIGN_DRIVER_VEHICLE ) {
            $msg = str_replace('{order_status}', 'ASSIGN VEHICLE AND DRIVER', $updateMsg);
        } elseif( \request('status') == Booking::OUT_FOR_DELIVERY ) {
            $msg = str_replace('{order_status}', 'OUT FOR DELIVERY', $updateMsg);
        } elseif( \request('status') == Booking::COMPLETED ) {
            $msg = str_replace('{order_no}', $booking->order_no, _t('order_delivered_9'));
        }

        sendPushNotification($booking->customer_id, [
            'booking_id'    => $booking->id,
            'category'      => 'booking_status_change',
            'body'          => $msg,
            'title'         => _t_title('order_update_7')
        ]);
        
        return appData( (new BookingTrans)->parseModel($booking), 'Booking status updated', 'booking_details');
    }

    public function allocateBookingToVendor() {
        $rules = [
            'booking_id'    => 'required|exists:bookings,id',
            'vendor_id'     => 'required|exists:users,id'
        ];

        if($err = cvalidate($rules)) return appError($err->first());

        $userModel = $this->userRepository->find(\request('vendor_id'));

        if(!$userModel) return appError('Bad Request');

        $bookingModel = $this->repository->find(\request('booking_id'));
        
        if(!$bookingModel) return appError('Bad Request');

        $model = BookingAllocate::where('booking_id', \request('booking_id'))
            ->where('vendor_id', \request('vendor_id'))->first();

        if($model) return appModelData([], 'You have already allocated the booking to this vendor.');
        
        $this->repository->saveBookingAllocation();

        $this->repository->saveBookingLog($bookingModel, \request('vendor_id'));

        $msg = "Booking (".$bookingModel->order_no.") allocate to ".$userModel->name;
        
        sendPushNotification($userModel->id, [
            'booking_id'    => $bookingModel->id,
            'category'      => 'allocate_booking',
            'body'          => $msg,
            'title'         => _t_title('bid_confirmed_14')
        ]);

        return appModelData( [], "Successfully allocated" );
    }
}	
