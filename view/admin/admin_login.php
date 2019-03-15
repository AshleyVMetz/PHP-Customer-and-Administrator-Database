<?php include '../view/shared/header.php'; ?>
<main>

    <h2>Administrator Login</h2>
      <?php 
    if(!empty($error)){
        echo('<div style="color:red;">'.$error.'</div>');
    }
    ?>
    <p>You must login.</p>
    <?php if (isset($logout)) : ?>
        <p><?php echo $logout; ?></p>
          <?php endif; ?>  
    <!-- display a search form -->
    <form action="." method="post" id="aligned">
        <input type="hidden" name="action" value="get_admin">
        <label>Username:</label>
        <input type="text" name="username" 
               value="<?php echo htmlspecialchars($username); ?>"><br>
        <label>Password:</label>
        <input type="text" name="password" 
               value="<?php echo htmlspecialchars($password); ?>">
        <br>
        <label>&nbsp;</label>
        <input type="submit" value="Login">
    </form>

</main>
<?php include '../view/shared/footer.php'; ?>
