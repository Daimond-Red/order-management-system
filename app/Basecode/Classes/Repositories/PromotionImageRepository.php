<?php

namespace App\Basecode\Classes\Repositories;

class PromotionImageRepository extends Repository {

    public $model = '\App\PromotionImage';

    public $viewIndex = 'admin.promotion_images.index';
    public $viewCreate = 'admin.promotion_images.create';
    public $viewEdit = 'admin.promotion_images.edit';
    public $viewShow = 'admin.promotion_images.show';

    public $storeValidateRules = [
        'title'  => 'required',
        'image' => 'required',
    ];

    public $updateValidateRules = [
        'title'  => 'required',
//        'image' => 'required|image',
    ];

    public function parseModel($model) {
        $arr = [];

        $arr['title']         = (string)$this->prepare_field('title', $model);
        $arr['image']         = (string)$this->prepare_field('image', $model);

        return $arr;
    }
}