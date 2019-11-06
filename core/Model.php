<?php
  namespace Core;

  class Model {
    protected $_db, $_table, $_modelName, $_softDelete = false, $_validates = true, $_validationErrors=[];
    public $id;

    public function __construct($table) {
      $this->_db = DB::getInstance();
      $this->_table = $table;
      $this->_modelName = str_replace(' ', '', ucwords(str_replace('_',' ', $this->_table)));
    }

    public function get_columns() {
      return $this->_db->get_columns($this->_table);
    }

    public function getColumnsForSave(){
      $columns = static::get_columns();
      $fields = [];
      foreach($columns as $column){
        $key = $column->Field;
        $fields[$key] = $this->{$key};
      }
      return $fields;
    }

    protected function _softDeleteParams($params) {
      if($this->_softDelete) {
        if(array_key_exists('conditions', $params)) {
          if(is_array($params['conditions'])) {
            $params['conditions'][] = 'deleted != 1';
          } else {
            $params['conditions'] .= " AND deleted != 1";
          }
        } else {
          $params['conditions'] = "deleted != 1";
        }
      }
      return $params;
    }

    public function find($params = []) {
      $params = $this->_softDeleteParams($params);
      $resultsQuery = $this->_db->find($this->_table, $params,get_class($this));
      if(!$resultsQuery) return [];
      return $resultsQuery;
    }

    public function findFirst($params = []) {
      $params = $this->_softDeleteParams($params);
      $resultQuery = $this->_db->findFirst($this->_table, $params, get_class($this));
      return $resultQuery;
    }

    public function findById($id) {
      return $this->findFirst(['conditions'=>"id = ?", 'bind' => [$id]]);
    }

    public function save() {
      $this->validator();
      $save = false;
      if($this->_validates){
        $this->beforeSave();
        $fields = $this->getColumnsForSave();
        // determine whether to update or insert
        if($this->isNew()) {
          $save = $this->insert($fields);
          // populate object with the id
          if($save){
            $this->id = $this->_db->lastID();
          }
        } else {
          $save = $this->update($fields);
        }
        // run after save
        if($save){
          $this->afterSave();
        }
      }
      return $save;
    }

    public function insert($fields) {
      if(empty($fields)) return false;
      return $this->_db->insert($this->_table, $fields);
    }

    public function update($id, $fields) {
      if(empty($fields) || $id == '') return false;
      return $this->_db->update($this->_table, $id, $fields);
    }

    public function delete($id = '') {
      if($this->id == '' || !isset($this->id)) return false;
      $id == ($id == '') ? $this->id : $id;
      if($this->beforeDelete()) {
        if($this->_softDelete) {
          $delete = $this->update($id, ['deleted' => 1]);
        }
        $delete = $this->_db->delete($this->_table, $id);
        if($delete) {
          $this->afterDelete();
        }
      } else {
        $delete = false;
      }
      return $delete;
    }
    public function query($sql, $bind=[]) {
      foreach($result as $key => $val) {
        $this->$key = $val;
      }
    }

    public function data() {
      $data = new stdClass();
      foreach(H::getObjectProperties($this) as $column => $value) {
        $data->column = $value;
      }
      return $data;
    }

    public function assign($params, $list=[], $blackList= true) {
      foreach($params as $key => $val) {
        $whiteListed = true;
        if(sizeof($list) > 0) {
          if($blackList) {
            $whiteListed = !in_array($key,$list);
          } else {
            $whiteListed = in_array($key, $list);
          }
        }
        if(property_exists($this,$key) && $whiteListed) {
          $this->$key = $val;
        }
      }
      return $this;
    }

    protected function populateObjData($result) {
      foreach($result as $key => $val) {
        $this->$key = $val;
      }
    }

    public function validator() {

    }

    public function runValidation($validator) {
      $key = $validator->field;
      if(!$validator->success) {
        $this->_validates = false;
        $this->_validationErrors[$key] = $validator->msg;
      }

    }

    public function getErrorMessages() {
      return $this->_validationErrors;
    }

    public function validationPassed() {
      return $this->_validates;
    }


    public function addErrorMessage($field,$msg){
      $this->_validates = false;
      if(array_key_exists($field,$this->_validationErrors)){
        $this->_validationErrors[$field] .= " " . $msg;
      } else {
        $this->_validationErrors[$field] = $msg;
      }
    }

    public function beforeSave() {}
    public function afterSave() {}

    /**
    * Runs before save needs to return a boolean
    * @return boolean
    **/
    public function beforeDelete() {
      return true;
    }
    public function afterDelte(){}


    public function isNew() {
      return (property_exists($this, 'id') && !empty($this->id)) ? false : true;
    }

    public function timeStamps(){
      $dt = new \DateTime("now", new \DateTimeZone("UTC"));
      $now = $dt->format('Y-m-d H:i:s');
      $this->updated_at = $now;
      if($this->isNew()){
        $this->created_at = $now;
      }
    }
  }
