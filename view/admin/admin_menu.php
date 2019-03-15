<?php include '../view/shared/header.php'; ?>
<main>
    <h2>Admin Menu</h2>
    <nav>
    <ul>
        <li><a href="?action=list_products">Manage Products</a></li>
        <li><a href="?action=under_construction">Manage Technicians</a></li>
        <li><a href="?action=customer_search">Manage Customers</a></li>
        <li><a href="?action=under_construction">Create Incident</a></li>
        <li><a href="?action=under_construction">Assign Incident</a></li>
        <li><a href="?action=under_construction">Display Incidents</a></li>
    </ul>
    </nav>
    <h2>Login Status</h2>
        <p><?php echo $successMessage; ?></p>
      
         <form action="." method="post" id="aligned">
            <input type="hidden" name="action" 
                   value="logout">
            <input type="hidden" name="username" 
                   value="<?php echo htmlspecialchars($admin['username']); ?>">
            <input type="submit" value="Logout" />
        </form>
</main>
<?php include '../view/shared/footer.php'; ?>
