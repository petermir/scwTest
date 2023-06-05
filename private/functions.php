<?php
include_once ('db.php');

function extract_from_database_array($string) {
  $arr = ['[', ']'];
  $replaced_string = str_replace($arr, ' ', $string);
  $new_array = explode(', ', $replaced_string);
  $new_string = implode('x', $new_array);
  return $new_string;
}

// Get the selected type
function get_selected_type($type) {
  if(isset($_POST['typeSwitcher']) && $_POST['typeSwitcher'] == $type) {
  echo 'selected';
 }
}

// Display errors
function display_errors($errors=[]) {
  $output = '';
  if(!empty($errors)) {
    $output .= "<section class=\"errors\">";
    $output .= "<ul>";
    foreach($errors as $error) {
      $output .= "<li>" . $error . "</li>";
    }
    $output .= "</ul>";
    $output .= "</section>";
  }
  return $output;
}

function get_current_inputs() {
  $input_values = ['sku', 'name', 'price'];

  if($_POST['typeSwitcher'] === 'dvd') {
    $input_values[] = 'size';
  }

  if($_POST['typeSwitcher'] === 'book') {
    $input_values[] = 'weight';
  }

  if($_POST['typeSwitcher'] === 'furniture') {
    $input_values[] = 'width';
    $input_values[] = 'length';
    $input_values[] = 'height';
  }

  return $input_values;
}

// Validate inputs
function validate_inputs() {
  $errors = [];

  if (isset($_POST['submit'])) {
    $inputs = get_current_inputs();

    foreach ($inputs as $input) {
      if (empty($_POST[$input]) || trim($_POST[$input]) == '') {
        $errors[] = strtoupper($input) . " must be provided. Please, enter data of indicated type.";
      }
    }

    // Check if the input strings include special characters
    $pattern = "/^[a-zA-Z0-9]*$/";
    if (preg_match($pattern, $_POST['sku']) === 0) {
      $errors[] = "Please, include only letters, numbers or the combination of both in the SKU.";
    }

    if (preg_match($pattern, $_POST['name']) === 0) {
      $errors[] = "Please, include only letters, numbers or the combination of both in the Name.";
    }

    // Check if the sku exists in the database
    $database = new mysqli("localhost", "root", "", "scandiweb");
    
    $sql = "SELECT * FROM products ";
    $sql .= "WHERE sku='" . $_POST['sku'] . "'";
    $result = $database->query($sql);
    if (mysqli_num_rows($result) > 0) {
      $errors[] = "This SKU already exists. Please, provide a unique stock keeping unit (SKU).";
    }

    if (!empty($_POST['price']) && !is_numeric($_POST['price'])) {
      $errors[] = "Please, provide a numeric value for the price.";
    }

    if (!empty($_POST['size']) && !is_numeric($_POST['size'])) {
      $errors[] = "Please, provide a numeric value for the size.";
    }

    if (!empty($_POST['weight']) && !is_numeric($_POST['weight'])) {
      $errors[] = "Please, provide a numeric value for the weight.";
    }

    if (!empty($_POST['length']) && !is_numeric($_POST['length'])) {
      $errors[] = "Please, provide a numeric value for the length.";
    }

    if (!empty($_POST['width']) && !is_numeric($_POST['width'])) {
      $errors[] = "Please, provide a numeric value for the width.";
    }

    if (!empty($_POST['height']) && !is_numeric($_POST['height'])) {
      $errors[] = "Please, provide a numeric value for the height.";
    }


    if (!empty($errors)) {
      return display_errors($errors);
    } 
  }
}