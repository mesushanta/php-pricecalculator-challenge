<?php
    require 'includes/header.php';
    $home = new HomeController();
?>

<section class="w-full max-w-screen-xl mx-auto my-20">
    <ul class="w-full my-12">
        <?php foreach($home->getCategories() as $category): ?>
        <li class="list-none inline-block mr-2">
            <a href="?category=<?php echo $category['id'] ?>">
                <button class="mr-2 px-6 h-10 bg-red-400">
                    <?php echo $category['name'] ?>
                </button>
            </a>
        </li>
<?php endforeach; ?>
    </ul>
    <form class="grid grid-cols-7 gap-4" method="post">
        <div class="col-span-2">
            <select name="customer_id" class="w-full px-4 h-12 border border-gray-400">
                <?php foreach($home->getCustomers() as $customer) { ?>
                    <option value="<?php echo $customer['id']; ?>" <?php if(isset($_POST['customer_id']) && $_POST['customer_id'] == $customer['id']) echo 'selected'; ?>><?php echo $customer['firstname']; ?> <?php echo $customer['lastname']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-span-2">
            <select name="product_id" class="w-full px-4 h-12 border border-gray-400">
                <?php foreach($home->getProducts() as $product) { ?>
                <option value="<?php echo $product['id']; ?>" <?php if(isset($_POST['product_id']) && $_POST['product_id'] == $product['id']) echo 'selected'; ?>><?php echo $product['name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-span-2">
            <input name="quantity" type="number" min="1" value="<?php if(isset($_POST['quantity'])) echo $_POST['quantity']; else echo '1'; ?>" class="w-full px-4 h-12 border border-gray-400">

        </div>

        <div class="col-span-1">
            <button class="w-full h-12 text-center bg-blue-500 hover:bg-blue-600 border border-blue-700 text-white" type="submit" name="calculate" value="calculate">Calculate</button>
        </div>
    </form>
    <div class="mt-8">
        ** 1% discount in unit price from 50 - 99 units<br>
        ** 2% discount in the unit price from 100 and above units
    </div>

</section>
<?php if($home->isResult()): ?>
<section id="result" class="w-full max-w-screen-xl mx-auto my-20 text-xl">
    Original Unit Price: €<?php echo number_format((float) ($home->getCalculate()->getProduct()->getPrice()/100), 2, '.', ''); ?><br>
    Applied Unit Price: €<?php echo number_format((float) ($home->getCalculate()->getUnitPrice()/100), 2, '.', ''); ?><br>
    Quantity: <?php echo $_POST['quantity']; ?><br>
    Total: €<?php echo number_format((float) ($home->getCalculate()->getCalculatedPrice()/100), 2, '.', ''); ?><br>

    <div class="border-l border-gray-300 px-4 py-4 my-4">
        <span class="block text-xl font-bold"><?php echo $home->getCalculate()->getCustomer()->getFirstname();?> <?php echo  $home->getCalculate()->getCustomer()->getLastname(); ?></span>
        <span class="block text-lg">Discount: <?php if($home->getCalculate()->getCustomer()->getDiscountType() == 'fixed') { echo '€'.number_format((float) ($home->getCalculate()->getCustomer()->getDiscountValue())/100, 2, '.', '' ); } else { echo $home->getCalculate()->getCustomer()->getDiscountValue().'%'; } ?></span>
    </div>
    <div class="border-l border-gray-300 px-4 py-4 my-4">
        <span class="block text-xl font-bold"><?php echo $home->getCalculate()->getGroup()->getname();?></span>
        <span class="block text-lg">Discount: <?php if($home->getCalculate()->getGroup()->getDiscountType() == 'fixed') { echo '€'.number_format((float) ($home->getCalculate()->getGroup()->getDiscountValue())/100, 2, '.', '' ); } else { echo $home->getCalculate()->getGroup()->getDiscountValue().'%'; } ?></span>
    </div>

    <?php for($i=0; $i < $home->getCalculate()->getParentLevel(); $i++): ?>
        <div class="ml-<?php echo ($i + 1)*8 ?> border-l border-gray-200 mt-4 px-4 py-4">
            <?php
                $group_id =  $home->getCalculate()->getParentLevelArray();
                $group = new CustomerGroup($group_id[$i]);
                ?>
                <b><?php echo $group->getName() ?></b><br>
                Group Discount: <?php if($group->getDiscountType() == 'fixed') echo '€'; ?><?php echo $group->getDiscountValue(); ?><?php if($group->getDiscountType() == 'variable') echo '%'; ?><br>

        </div>

    <?php endfor; ?>

</section>
<?php endif; ?>

<?php
    require 'includes/footer.php';
?>