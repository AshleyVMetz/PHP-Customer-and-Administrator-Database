<?php include '../view/shared/header.php'; ?>
<main>

    <!-- display a table of customer information -->
    <h2>View/Update Customer</h2>
    <form action="." method="post" id="aligned">
        <input type="hidden" name="action" value="update_customer">
        <input type="hidden" name="customer_id" 
               value="<?php echo htmlspecialchars($customer['customerID']); ?>">

        <label>First Name:</label>
        <input type="text" name="first_name" 
               value="<?php echo htmlspecialchars($customer['firstName']); ?>"><br>

        <label>Last Name:</label>
        <input type="text" name="last_name" 
               value="<?php echo htmlspecialchars($customer['lastName']); ?>"><br>

        <label>Address:</label>
        <input type="text" name="address" 
               value="<?php echo htmlspecialchars($customer['address']); ?>" 
               size="50"><br>

        <label>City:</label>
        <input type="text" name="city" 
               value="<?php echo htmlspecialchars($customer['city']); ?>"><br>

        <label>State:</label>
        <input type="text" name="state" 
               value="<?php echo htmlspecialchars($customer['state']); ?>"><br>

        <label>Postal Code:</label>
        <input type="text" name="postal_code" 
               value="<?php echo htmlspecialchars($customer['postalCode']); ?>"><br>

        <label>Country Code:</label>
		<input type="text" name="country_code" 
               value="<?php echo htmlspecialchars($customer['countryCode']); ?>"><br>
        
        <label>Phone:</label>
        <input type="text" name="phone" 
               value="<?php echo htmlspecialchars($customer['phone']); ?>"><br>

        <label>Email:</label>
        <input type="text" name="email" 
               value="<?php echo htmlspecialchars($customer['email']); ?>" 
               size="50"><br>

        <label>Password:</label>
        <input type="text" name="password" 
               value="<?php echo htmlspecialchars($customer['password']); ?>"><br>

        <label>&nbsp;</label>
        <input type="submit" value="Update Customer"><br>
    </form>
    <p><a href=".?action=customer_search">Search Customers</a></p>

</main>
<?php include '../view/shared/footer.php'; ?>