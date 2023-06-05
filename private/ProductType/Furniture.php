<?php

namespace App\ProductType;
use App\ProductType\Product;

class Furniture extends Product {
  static protected $columns = ['id', 'sku', 'name', 'price', 'dimensions'];

  public function save() {
    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO products (";
    $sql .= join(', ', array_keys($attributes));
    $sql .= ") VALUES (";
    $sql .= "'" . $this->sku . "', ";
    $sql .= "'" . $this->name . "', ";
    $sql .= "'" . $this->price . "', ";
    $sql .= "'[" . $this->height . ", "; 
    $sql .= $this->width . ", ";
    $sql .= $this->length . "]'";
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
    $this->width = $args['width'] ?? '';
    $this->length = $args['length'] ?? '';
    $this->height = $args['height'] ?? '';
  }
}