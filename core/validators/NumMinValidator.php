<?php
namespace Core\Validators;
use Core\Validators\CustomValidator;
use Core\FH;

class NumMinValidator extends CustomValidator {

  public function runValidation(){
    $value = $this->_model->{$this->field};
    $pass = ($value >= $this->rule);
    return $pass;
  }

}
