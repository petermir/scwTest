<?php

namespace App\ProductType;
use App\ProductType\Product;

class Book extends Product {

  static protected $columns = ['id', 'sku', 'name', 'price', 'weight'];

  public function saveBook() {
    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO products (";
    $sql .= join(', ', array_keys($attributes));
    $sql .= ") VALUES (";
    $sql .= "'" . $this->sku . "', ";
    $sql .= "'" . $this->name . "', ";
    $sql .= "'" . $this->price . "', ";
    $sql .= "'" . $this->weight . "'";
    $sql .= ")";
    $result = self::$database->query($sql);
    if($result) {
      $this->id = self::$database->insert_id;
    }
    return $result;
  }
  
  public function __construct($args=[]) {
    $this->sku = $args['sku'] ?? '';
    $this->name = $args['name'] ?? '';
    $this->price = $args['price'] ?? '';
    $this->weight = $args['weight'] ?? '';
  }
}