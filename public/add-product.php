<?php include_once('private/db.php'); ?>
<?php


use App\ProductType\Book;
use App\ProductType\DVD;
use App\ProductType\Furniture;

$errors = validate_inputs();

if(isset($_POST['submit']) && empty($errors)){
  $result = '';
  $args = [];
  $args['sku'] = $_POST['sku'] ?? NULL;
  $args['name'] = $_POST['name'] ?? NULL;
  $args['price'] = $_POST['price'] ?? NULL;
  $args['weight'] = $_POST['weight'] ?? NULL;
  $args['size'] = $_POST['size'] ?? NULL;
  $args['width'] = $_POST['width'] ?? NULL;
  $args['length'] = $_POST['length'] ?? NULL;
  $args['height'] = $_POST['height'] ?? NULL;

  if ($_POST['weight'] != NULL) {
    $book = new Book($args);
    $result = $book->saveBook();
  }

  if ($_POST['size'] != NULL) {
    $dvd = new DVD($args);
    $result = $dvd->saveDVD();
  }

  if ($_POST['width'] != NULL && $_POST['length'] != NULL && $_POST['height'] != NULL) {
    $furniture = new Furniture($args);
    $result = $furniture->save(); 
  }

  if ($result === true) {
    header('Location: /');
    exit;
  }
}

?>
<?php $page_title = 'Product Add'; ?>
<?php include('public/shared/head.php'); ?>
<body>
  <header>
    <div>
      <nav>
        <h1>Product Add</h1>
        <div>
          <button name="submit" class="btn" form='product_form'>SAVE</button>
          <button class="btn"><a href="/">CANCEL</a></button>
        </div>
      </nav>
    </div>
  </header>
  <main>
    <div class="container">
      <form action="" id='product_form' method='POST'>
        <?= $errors ;?>
        <div>
          <label for="sku">SKU</label>
          <input type="text" name="sku" id='sku' maxlength='9' placeholder="ABCD1234" value="<?= $_POST['sku'] ?? '';  ?>">
        </div>
        <div>
          <label for="name">Name</label>
          <input type="text" name='name' id='name' maxlength="30" placeholder='Product Name' value="<?= $_POST['name'] ?? ''; ?>">
        </div>
        <div>
          <label for="price">Price ($)</label>
          <input type="text" name='price' id='price' placeholder="0.00" value="<?= $_POST['price'] ?? ''; ?>">
        </div>
        <div>
          <label for="productType">Type Switcher</label>
          <select name="typeSwitcher" id="productType">
            <option value="dvd" id='DVD' <?= get_selected_type('dvd'); ?> >DVD</option>
            <option value="book" id='Book' <?= get_selected_type('book'); ?> >Book</option>
            <option value="furniture" id='Furniture' <?= get_selected_type('furniture'); ?> >Furniture</option>
          </select>
        </div>
        <div id='size-container'>
          <p>Please provide size.</p>
          <label for="size">(MB)</label>
          <input type="text" name='size' id='size' placeholder='0' maxlength='5' value="<?= $_POST['size'] ?? ''; ?>">
        </div>
        <div id='weight-container'>
          <p>Please provide weight.</p>
          <label for="weight">(KG)</label>
          <input type="text" name='weight' id='weight' placeholder='0' maxlength='2' value="<?= $_POST['weight'] ?? ''; ?>">
        </div>
        <section id='dimensions-container'>
          <br>
          <p style="text-align: center;">Please provide dimensions in HxWxL format.</p>
          <br>
          <div>
            <label for="height">Height (CM)</label>
            <input type="text" name='height' id='height' placeholder='0' maxlength='5' value="<?= $_POST['height'] ?? ''; ?>">
          </div>
          <br>
          <div>
            <label for="width">Width (CM)</label>
            <input type="text" name='width' id='width' placeholder='0' maxlength='5' value="<?= $_POST['width'] ?? ''; ?>">
          </div>
          <br>
          <div>
            <label for="length">Length (CM)</label>
            <input type="text" name='length' id='length' placeholder='0' maxlength='5' value="<?= $_POST['length'] ?? ''; ?>">
          </div>
        </section>
      </form>
    </div>
  </main>
<?php include('public/shared/footer.php'); ?>
</body>
</html>
