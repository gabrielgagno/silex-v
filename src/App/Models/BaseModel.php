<?php

namespace App\Models;

class BaseModel {

  public function set(array $options)
  {
      $_classMethods = get_class_methods($this);
      foreach ($options as $key => $value) {
          $method = 'set' . ucfirst($key);
          if (in_array($method, $_classMethods)) {
              $this->$method($value);
          } else {
              throw new Exception('Invalid method name');
          }
      }
      return $options;
  }

}
