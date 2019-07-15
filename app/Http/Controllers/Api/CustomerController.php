<?php

namespace App\Http\Controllers\Api;

use App\Basecode\Classes\Repositories\CustomerRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;
use App\Basecode\Classes\Repositories\BookingRepository;
use App\Basecode\Classes\Transformers\BookingTrans;
use App\Basecode\Classes\Repositories\PromotionImageRepository;

class CustomerController extends ApiController
{
    public $repository, $permission, $bookingRepository, $promotionImageRepository;

    function __construct(Repository $repository, BookingRepository $bookingRepository, Permission $permission, PromotionImageRepository $promotionImageRepository)
    {
        $this->repository = $repository;
        $this->permission = $permission;
        $this->bookingRepository = $bookingRepository;
        $this->promotionImageRepository = $promotionImageRepository;
    }

    public function dashboard() {

    	$model = $this->bookingRepository->getModel()
    		->where('customer_id', auth()->user()->id)
    		->latest()
    		->first();

        $images = [];
        $promotionCollection = $this->promotionImageRepository->getModel()->get();

        if($promotionCollection) $images = $this->promotionImageRepository->parseCollection($promotionCollection);

        $data = [
            'booking' => ( new BookingTrans )->parseModel($model),
            'promotion_image' => $images
        ];

    	return appModelData($data);

    }
}
