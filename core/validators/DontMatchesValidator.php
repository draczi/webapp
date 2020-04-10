<?php
namespace Core\Validators;
use Core\Validators\CustomValidator;

class DontMatchesValidator extends CustomValidator {

  public function runValidation(){
    $value = $this->_model->{$this->field};
    return !($value == $this->rule);
  }
}
