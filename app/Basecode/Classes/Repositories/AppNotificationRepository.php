<?php

namespace App\Basecode\Classes\Repositories;

class AppNotificationRepository extends Repository {

    public $model = '\App\AppNotification';

    public $viewIndex = 'admin.appNotifications.index';
    public $viewCreate = 'admin.appNotifications.create';
    public $viewEdit = 'admin.appNotifications.edit';
    public $viewShow = 'admin.appNotifications.show';

    public $storeValidateRules = [
        'title' => 'required',
    ];

    public $updateValidateRules = [
        'title' => 'required',
    ];

    public function getCollection($withfilter = true) {
        $model = new $this->model;
        $model = $model->orderBy('created_at', 'desc');

        $whereLikefields = ['title'];

        foreach ($whereLikefields as $field) {
            if( $value = request($field) ) $model = $model->where($field, 'like', '%'.$value.'%');
        }

        return $model;
    }

    public function parseModel($model) {
        $arr = [];

        $arr['notification_id'] = (string) $this->prepare_field('id', $model);
        $arr['title'] = (string) $this->prepare_field('title', $model);
        $arr['message'] = (string) $this->prepare_field('message', $model);
        $arr['created_at'] = (string) $this->prepare_field('created_at', $model);

        return $arr;
    }

    public function save( $attrs ) {

        $attrs = $this->getValueArray($attrs);

        $model = new $this->model;
        $model->fill($attrs);
        $model->save();

        if( $val = request('users') ) {

            $userIds = explode(',', $val);

            $model->users()->sync( $userIds );

            sendPushNotification($userIds, [
                'notification_id'       => $model->id,
                'category'              => 'create_notification',
                'body'                  => request('message'),
                'title'                 => request('title')
            ]);

        }


        return $model;
    }

}