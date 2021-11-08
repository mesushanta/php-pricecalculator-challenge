<?php
    require 'includes/header.php';
    $home = new HomeController();
?>

<section class="w-full max-w-screen-xl mx-auto my-20">

    <form class="grid grid-cols-7 gap-4" method="post">
        <div class="col-span-2">
            <select name="customer_id" class="w-full px-4 h-12 border border-gray-400">
                <?php foreach($home->getCustomers() as $customer) { ?>
                    <option value="<?php echo $customer['id']; ?>"><?php echo $customer['firstname']; ?> <?php echo $customer['lastname']; ?> (<?php echo $customer['fixed_discount']; ?> , <?php echo $customer['variable_discount']; ?>)</option>
                <?php } ?>
            </select>
        </div>

        <div class="col-span-2">
            <select name="product_id" class="w-full px-4 h-12 border border-gray-400">
                <?php foreach($home->getProducts() as $product) { ?>
                <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?> (<?php echo $product['price']; ?>)</option>
                <?php } ?>
            </select>
        </div>
        <div class="col-span-1">
            <button class="w-full h-12 text-center bg-blue-500 hover:bg-blue-600 border border-blue-700 text-white" type="submit" name="calculate">Calculate</button>
        </div>
    </form>
</section>

<?php
    if($home->isResult()) {
        $home->getCalculate()->calculate();
        echo $home->getCalculate()->getCalculatedPrice();
    }
?>

<?php
    require 'includes/footer.php';
?>