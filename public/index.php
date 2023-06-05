<?php

use App\ProductType\Product;

include_once('private/db.php'); 

$products = Product::select_all();

// Delete the selected items
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteId'])) {

  Product::delete();
}
 
?>

<?php $page_title = 'Product List'; ?>
<?php include('shared/head.php'); ?>
<body>
  <header>
    <div>
      <nav>
        <h1>Product List</h1>
        <div>
          <a href="/add-product"><button class="btn">ADD</button></a>
          <button form='product_list' type='submit' name='delete' class="btn">MASS DELETE</button>
        </div>
      </nav>
    </div>
  </header>
  <main>
  <div class="container">
    <form action="" id='product_list' method='POST'>
    <?php foreach ($products as $product) { ?>
      <div class='product-info'> 
        <input type="checkbox" name="deleteId[]" value="<?= $product->id ?>" class="delete-checkbox">
        <span><?= $product->sku; ?></span>
        <span><?= $product->name; ?></span>
        <span><?= $product->price . " $"; ?></span>
        <span><?php
  
          echo $product->weight > 0.0 ? "Weight: " . $product->weight . "KG" : '';
  
          echo $product->size > 0 ?  "Size: " . $product->size . "MB" : '';
  
          echo $product->dimensions > 0 ? "Dimensions: " . extract_from_database_array($product->dimensions): '';
         ?>
         </span>
     </div>
     <?php }; ?>
     </form>
  </div>
  </main>
<?php include('shared/footer.php'); ?>
</body>
</html>