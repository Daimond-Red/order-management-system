<?php

namespace App\Basecode\Classes\Transformers;


class TransformerAbstract {

    public function gets( $fields, $data, $filterFields = [] ) {

        if(!$data) return [];

        $arr = [];

        foreach( $fields as $field ) {

            if(! isset($field['dbKey']) ) continue;

            if( $filterFields && (!in_array($field, $filterFields)) ) continue;

            if(! isset($field['key']) ) {
                $key = $field['dbKey'];
            } else {
                $key = $field['key'];
            }
            if( isset($field['type']) ) {
                $type = $field['type'];
            } else {
                $type = 'string';
            }

            if( $type == 'boolean' ) {
                $arr[$key] = (boolean) $this->get($field['dbKey'], $data);
            } elseif( $type == 'date' ) {
                $arr[$key] = (string) getDateValue($this->get($field['dbKey'], $data));
            } elseif( $type == 'datetime' ) {
                $arr[$key] = (string) getDateTimeValue($this->get($field['dbKey'], $data));
            } else {
                $arr[$key] = (string) $this->get($field['dbKey'], $data);
            }

        }

        return $arr;
    }

    public function get($field, $data){
        $value = '';
        if( is_array($data) ) {

            if( array_key_exists($field, $data) && $data[$field] ) {
                $value = $data[$field];
            } else {
                $value = '';
            }

        } else {
            if( isset($data->$field) && $data->$field ) {
                $value = $data->$field;
            } else {
                $value = '';
            }

        }
        return $value;
    }

    public function parseModel($model, $fields = []) {
        return $model;
    }

    public function parseCollection( $collection, $fields = [] ) {
        $data = [];
        foreach($collection as $model) $data[] = $this->parseModel($model, $fields);
        return $data;
    }

    public function parseManagerModel( $model ) {

        if(! $model ) return new \stdClass();

        $arr = [];
        $arr['user_id']             = (string)($this->get('id', $model));
        $arr['name']                = (string)$this->get('name', $model);
        $arr['emp_id']              = (string)$this->get('emp_id', $model);
        $arr['email']               = (string)$this->get('email', $model);
        $arr['image']               = (string)getImageUrl($this->get('image', $model));

        $arr['department']['id']    = (string) $model->getRoleDepartmentIds();
        $arr['designation']['id']   = (string) $model->getDesignationName();
        $arr['department']['name']  = (string) $model->getRoleDepartmentDisplayNames();
        $arr['designation']['name'] = (string) $model->getDesignationDisplayName();

        return $arr;
    }

}
