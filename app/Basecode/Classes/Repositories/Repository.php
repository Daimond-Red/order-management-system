<?php

namespace App\Basecode\Classes\Repositories;

class Repository {

    public $viewIndex = '';
    public $viewCreate = '';
    public $viewEdit = '';
    public $viewShow = '';

    public $storeValidateRules = [];
    public $updateValidateRules = [];

    public $model = '';

    public $create_msg = 'Successfully created!';
    public $update_msg = 'Successfully updated!';
    public $delete_msg = 'Successfully deleted!';
    public $not_found  = 'No matching records found';

    public static  function getInstance() {
        return new self;
    }

    public function getCollection($withFilters = true) {
        $model = new $this->model;
        $model = $model->orderBy('created_at', 'desc');
        return $model;
    }

    public function getModel() {
        $model = new $this->model;
        return $model;
    }

    public function getPaginated( $ele = 20 ) {
        return $this->getCollection()->paginate( $ele );
    }

    public function find( $id ) {
        $model = $this->model;
        $model = $model::find($id);
        return $model;
    }

    public function getValueArray($attrs) {
        $arr = [];
        foreach( $attrs as $index => $value ) {
            if($value != null) $arr[$index] = $value;
        }
        return $arr;
    }

    public function save( $attrs ) {

        $attrs = $this->getValueArray($attrs);

        $model = new $this->model;
        $model->fill($attrs);
        $model->save();
        return $model;
    }

    public function update($model, $attrs = null) {
        if(! $attrs ) $attrs = $this->getAttrs();
        $model->fill($attrs);
        $model->update();
        return $model;
    }

    public function delete($model) {
        $model->delete();
    }

    public function getAttrs() {
        $attrs = request()->all();

        $uploads = ['image'];

        if (filter_var(request('image'), FILTER_VALIDATE_URL)) {
            $attrs['image'] = $this->download_image(request('image'));
        } else {
            foreach ( $uploads as $upload ) {
                if( request()->hasFile($upload) ){
                    $attrs[$upload] = self::upload_file($upload);
                } elseif( $attrs && count($attrs) && array_key_exists($upload, $attrs) ) {
                    unset($attrs[$upload]);
                }
            }
        }

        return $attrs;
    }

    public function uploadFileToS3($image) {
        try {
            $request = request();
            $image = $request->file($image);
            $imageFileName = time() . '.' . $image->getClientOriginalExtension();
            $s3 = \Storage::disk('s3');
            $filePath = $imageFileName;
            $s3->put($filePath, file_get_contents($image), 'public');
            return $imageFileName;
        } catch ( \Exception $e ) {
            //echo $e->getMessage(); die;
            return '';
        }

    }

    public function upload_file($file, $folder = 'images') {
        try {
            $imageName =  generateOTP(). time().'.'.request()->$file->getClientOriginalExtension();

            request()->$file->move(public_path('uploads/'.$folder), $imageName);

            return 'uploads/'.$folder.'/'. $imageName;
        } catch (\Exception $e) {
            return '';
        }
    }

    public function download_image( $image_url ) {

        $info = pathinfo( $image_url );

        if(! $info && isset($info['extension']) ) return '';

        $extension = $info['extension'];
        $arr = explode('?', $extension);

        if( isset($arr[0]) ) $extension = $arr[0];

        $file_name = generateOTP(). time().'.'.$extension;

        $url = public_path(). '/uploads/social_image/'. $file_name;

        try {

            file_put_contents( $url, fopen($image_url, 'r'));

            return 'uploads/social_image/'. $file_name;

        } catch (Exception $e) {
            return '';
        }

    }


    public function redirectBackWithSuccess( $msg, $routeName = null ) {
        if(request('isAjax')) return ['status' => true, 'msg' => $msg];
        if( $routeName ) return redirect()->route($routeName)->withSuccess($msg);
        return redirect()->back()->withSuccess($msg);
    }

    public function redirectBackWithErrors( $msg, $routeName = null ) {
        if(request('isAjax')) return ['status' => false, 'msg' => $msg];
        if( $routeName ) return redirect()->route($routeName)->withErrors($msg);
        return redirect()->back()->withErrors($msg);
    }

    public function parseModel($model) {
        return $model;
    }

    public function parseCollection( $collection ) {
        $data = [];
        foreach($collection as $model) $data[] = $this->parseModel($model);
        return $data;
    }

    public function prepare_fields( $fields, $data ) {

        if(!$data) return [];

        $arr = [];

        foreach( $fields as $field ) {

            if( is_array($data) ) {

                if( array_key_exists($field, $data) && $data[$field] ) {
                    $arr[$field] = $data[$field];
                } else {
                    $arr[$field] = '';
                }

            } else {

                if( $data->$field ) {
                    $arr[$field] = $data->$field;
                } else {
                    $arr[$field] = '';
                }

            }

        }

        return $arr;
    }

    public function prepare_field($field, $data){
        $value = '';
        if( is_array($data) ) {

            if( array_key_exists($field, $data) && $data[$field] ) {
                $value = $data[$field];
            } else {
                $value = '';
            }

        } else {

            if( $data->$field ) {
                $value = $data->$field;
            } else {
                $value = '';
            }

        }
        return $value;
    }

    public function import() {

    }

    public function exportCsv()
    {
        exportCsv();
        die;
    }

}
