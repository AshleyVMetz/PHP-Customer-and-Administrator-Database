<?php include '../view/shared/header.php'; ?>
<main>

    <!-- display a table of customer information -->
    <h2>View/Update Customer</h2>
    
    <form action="." method="post" id="aligned">
        <input type="hidden" name="action" value="update_customer">
        <input type="hidden" name="customer_id" 
               value="<?php  echo htmlspecialchars($customer['customerID']);  ?>">

        <label>First Name:</label>
        <input type="text" name="first_name" 
               value="<?php if(!empty($_POST['first_name'])){ echo($_POST['first_name']); }else{ echo htmlspecialchars($customer['firstName']); } ?>"><?php if(!empty($errors['first_name'])){  echo '<span style="color:red;">'.$errors['first_name'].'</span>';  } ?><br>

        <label>Last Name:</label>
        <input type="text" name="last_name" 
               value="<?php if(!empty($_POST['last_name'])){ echo($_POST['last_name']); }else{  echo htmlspecialchars($customer['lastName']);} ?>"><?php if(!empty($errors['last_name'])){  echo '<span style="color:red;">'.$errors['last_name'].'</span>';  } ?><br>

        <label>Address:</label>
        <input type="text" name="address" 
               value="<?php if(!empty($_POST['address'])){ echo($_POST['address']); }else{  echo htmlspecialchars($customer['address']);} ?>" size="50"><?php if(!empty($errors['address'])){  echo '<span style="color:red;">'.$errors['address'].'</span>';  } ?><br>

        <label>City:</label>
        <input type="text" name="city" 
               value="<?php if(!empty($_POST['city'])){ echo($_POST['city']); }else{  echo htmlspecialchars($customer['city']);} ?>"><?php if(!empty($errors['city'])){  echo '<span style="color:red;">'.$errors['city'].'</span>';  } ?><br>

        <label>State:</label>
        <input type="text" name="state" 
               value="<?php if(!empty($_POST['state'])){ echo($_POST['state']); }else{  echo htmlspecialchars($customer['state']);} ?>"><?php if(!empty($errors['state'])){  echo '<span style="color:red;">'.$errors['state'].'</span>';  } ?><br>

        <label>Postal Code:</label>
        <input type="text" name="postal_code" 
               value="<?php if(!empty($_POST['postal_code'])){ echo($_POST['postal_code']); }else{  echo htmlspecialchars($customer['postalCode']);} ?>"><?php if(!empty($errors['postal_code'])){  echo '<span style="color:red;">'.$errors['postal_code'].'</span>';  } ?><br>

        <label>Country Code:</label>
		<select name="country_code"> 
		    <?php 
		      foreach ( $countries as $country ) : 
		      if($country['countryCode'] == $customer['countryCode']){
		          $selected = 'selected';
		      }else{
		          $selected = '';
		      }
		    ?>
            <option value="<?php echo htmlspecialchars($country['countryCode']); ?>" <?php echo($selected); ?>>
                <?php echo $country['countryName']; ?>
            </option>
            <?php endforeach; ?>
       		</select>
            <br>
        
        <label>Phone:</label>
        <input type="text" name="phone" 
               value="<?php if(!empty($_POST['phone'])){ echo($_POST['phone']); }else{echo htmlspecialchars($customer['phone']);} ?>"><?php if(!empty($errors['phone'])){  echo '<span style="color:red;">'.$errors['phone'].'</span>';  } ?><br>

        <label>Email:</label>
        <input type="text" name="email" 
               value="<?php if(!empty($_POST['email'])){ echo($_POST['email']); }else{echo htmlspecialchars($customer['email']);} ?>"  size="50"><?php if(!empty($errors['email'])){  echo '<span style="color:red;">'.$errors['email'].'</span>';  } ?><br>

        <label>Password:</label>
        <input type="text" name="password" 
               value="<?php if(!empty($_POST['password'])){ echo($_POST['password']); }else{echo '******'; } ?>"><?php if(!empty($errors['password'])){  echo '<span style="color:red;">'.$errors['password'].'</span>';  } ?><br>

        <label>&nbsp;</label>
        <input type="submit" value="Update Customer"><br>
    </form>
    <p><a href=".?action=customer_search">Search Customers</a></p>
</main>
<?php include '../view/shared/footer.php'; ?>