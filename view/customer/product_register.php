<?php include '../view/shared/header.php'; ?>
<main>

    <h2>Register Product</h2>
    <?php if (isset($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php else: ?>
        <form action="." method="post" id="aligned">
            <input type="hidden" name="action" 
                   value="register_product">
            <input type="hidden" name="customer_id" 
                   value="<?php echo htmlspecialchars($customer['customerID']); ?>">

            <label>Customer:</label>
            <label><?php echo htmlspecialchars($customer['firstName'] . ' ' . 
                                              $customer['lastName']) ?></label>
            <br>

            <label>Product:</label>
            <select name="product_code">
            <?php foreach ($products as $product) : ?>
                <option value="<?php echo htmlspecialchars($product['productCode']); ?>">
                    <?php echo htmlspecialchars($product['name']); ?>
                </option>
            <?php endforeach; ?>
            </select>
            <br>

            <label>&nbsp;</label>
            <input type="submit" value="Register Product" />
        </form>
     
    <?php endif; ?>
		<?php if (isset($success)) : ?>
        <p><?php echo $success; ?></p>
        <?php endif; ?>
         <form action="." method="post" id="aligned">
            <input type="hidden" name="action" 
                   value="logout">
            <input type="hidden" name="customer_id" 
                   value="<?php echo htmlspecialchars($customer['customerID']); ?>">
            <input type="submit" value="Logout" />
        </form>
</main>
<?php include '../view/shared/footer.php'; ?>