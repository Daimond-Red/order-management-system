<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Basecode\Classes\Repositories\BookingRepository;
use App\Basecode\Classes\Repositories\CustomerRepository;
use App\Basecode\Classes\Repositories\VendorRepository;
use App\Basecode\Classes\Repositories\DriverRepository;
use App\Booking;
use App\User;

class HomeController extends Controller
{
    protected $bookingRepository, $customerRepository, $vendorRepository, $driverRepository; 
    public function __construct(
        BookingRepository $bookingRepository,
        CustomerRepository $customerRepository,
        VendorRepository $vendorRepository,
        DriverRepository $driverRepository
    )
    {
        $this->bookingRepository = $bookingRepository;
        $this->customerRepository = $customerRepository;
        $this->vendorRepository = $vendorRepository;
        $this->driverRepository = $driverRepository;

        $this->middleware('admin.auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $bookingCount = Booking::whereIn('status', [\App\Booking::PENDING, \App\Booking::BOOKING_HAS_BID])->count();
        $vendorCount = User::whereIn('type', [User::VENDOR])->count(); 
        $customerCount = User::whereIn('type', [User::INDIVIDUAL_CUSTOMER, User::COMMERCIAL_CUSTOMER])->count();
        $driverCount = User::whereIn('type', [User::DRIVER])->where('vendor_id', '!=', null)->count();

        $customerCollection = $this->customerRepository->getCollection()->latest()->take(5)->get();
        $vendorCollection = $this->vendorRepository->getCollection()->latest()->take(5)->get();
        $bookingCollection = $this->bookingRepository->getCollection()
            ->whereIn('status', [\App\Booking::PENDING, \App\Booking::BOOKING_HAS_BID])
            ->latest()
            ->take(5)
            ->get();

        $ongoingBookings = $this->bookingRepository->getCollection()
            ->where('status', \App\Booking::LIVE)
            ->latest()
            ->take(5)
            ->get();
        $collection =  [];

        return view('dashboard', compact('bookingCount', 'vendorCount', 'customerCount', 'driverCount', 'customerCollection', 'vendorCollection', 'bookingCollection', 'collection', 'ongoingBookings'));
    }
}
