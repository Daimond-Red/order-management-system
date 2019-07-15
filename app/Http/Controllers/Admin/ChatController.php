<?php

namespace App\Http\Controllers\Admin;

use App\Basecode\Classes\Repositories\ChatRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class ChatController extends BackendController
{
    public $repository, $permission;

    function __construct(Repository $repository, Permission $permission)
    {
        $this->repository = $repository;
        $this->permission = $permission;
    }

    public function logStore() {

    	$chatModel = $this->repository->find(\request('chatId'));

    	if(!$chatModel) return false;

    	$model = $this->repository->saveChatLogs($chatModel);

    	$msg = \request('message');

        sendPushNotification([$chatModel->customer_id, $chatModel->vendor_id], [
            'chat_id'       => $model->chat_id,
            'category'      => 'chat',
            'body'          => $msg,
            'title'         => 'Admin Message'
        ]);

    	return true;
    }
}
