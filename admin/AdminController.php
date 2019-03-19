<?php
require_once '../model/Database.php';
require_once '../util/secure_conn.php';
require_once '../model/ProductTable.php';
require_once '../model/CustomerTable.php';
require_once '../model/AdminTable.php';
require_once '../util/Util.php';
require('../model/fields.php');
require('../model/validate.php');

class AdminController {
    private $action;
    
    public function __construct() {
        $this->startSession();
        $this->action = '';
        $this->db = new Database();
        $this->validate = new Validate();
        if (!$this->db->isConnected()) {
            $error_message = $this->db->getErrorMessage();
            include '../view/errors/database_error.php';
            exit();
        }
    }
    
    public function invoke() {
        // get the action to be processed
        $this->action = Util::getAction($this->action);
        
        switch ($this->action) {
            case 'under_construction':
                include '../view/under_construction.php';
                break;
            case 'list_products':
                $this->processListProducts();
                break;
            case 'delete_product':
                $this->processDeleteProduct();
                break;
            case 'show_add_form':
                $this->processShowAddForm();
                break;
            case 'add_product':
                $this->processAddProduct();
                break;
            case 'customer_search':
                $this->processCustomerSearch();
                break;
            case 'display_customer':
                $this->processDisplayCustomer();
                break;
            case 'update_customer':
                $this->processUpdateCustomer();
                break;
            case 'display_customers':
                $this->processDisplayCustomers();
                break;
            case 'admin_menu':
                $this->processAdminMenu();
                break;
            case 'get_admin':
                $this->processGetAdmin();
                break;
            case 'logout':
                $this->processLogout();
                break;
            default:
                $this->processAdminLogin();
                break;
        }
    }
    
    /****************************************************************
     * Process Request
     ***************************************************************/
    private function processAdminLogin() {
            $username = '';
            $password = '';
            include '../view/admin/admin_login.php';
        }
    
    
    private function processGetAdmin() {
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        $admin_table = new AdminTable($this->db);
        $validUser = $admin_table->get_admin_by_username($username);
        if (!isset($username) || $validUser==false) {
            $error = "Invalid username";
            include('../view/admin/admin_login.php');
        } else if (!isset($password) || password_verify($password, $validUser['password']) == false) {
            $error = "Invalid password";
            include('../view/admin/admin_login.php');
        } else {
            $_SESSION['admin-loggedin'] = true;
            $_SESSION['admin'] = $validUser;
            $successMessage = "You are logged in as $username";
           include '../view/admin/admin_menu.php';
            
        }
    }
    
    private function processAdminMenu() {
        include '../view/admin/admin_menu.php';
    }
    
    private function processListProducts() {
        $product_table = new ProductTable($this->db);
        $products = $product_table->get_products();
        include '../view/admin/list_products.php';
    }
    
    private function processDeleteProduct() {
        $product_code = filter_input(INPUT_POST, 'product_code');
        $product_table = new ProductTable($this->db);
        $product_table->delete_product($product_code);
        header("Location: .?action=list_products");
    }
    
    private function processShowAddForm() {
        include '../view/admin/product_add.php';
    }
    
    private function processAddProduct() {
        $code = filter_input(INPUT_POST, 'code');
        $name = filter_input(INPUT_POST, 'name');
        $version = filter_input(INPUT_POST, 'version', FILTER_VALIDATE_FLOAT);
        $release_date = filter_input(INPUT_POST, 'release_date');
        
        
        // Validate the inputs
        if ( $code === NULL || $name === FALSE ||
            $version === NULL || $version === FALSE ||
            $release_date === NULL) {
            $error = "Invalid product data. Check all fields and try again.";
            include('../view/errors/error.php');
        } else {
            $product_table = new ProductTable($this->db);
            $product_table->add_product($code, $name, $version, $release_date);
            header("Location: .?action=list_products");
        }
    }
    
    private function processCustomerSearch() {
        $last_name = '';
        $customers = array();
        include '../view/admin/customer_search.php';
    }
    
    private function processDisplayCustomer() {
        $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_VALIDATE_INT);
        $customer_table = new CustomerTable($this->db);
        $customer = $customer_table->get_customer($customer_id);
        $countries = $customer_table->get_countries();
        include '../view/admin/customer_display.php';
    }
    
    private function processUpdateCustomer() {
        $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_VALIDATE_INT);
        $first_name = filter_input(INPUT_POST, 'first_name');
        $last_name = filter_input(INPUT_POST, 'last_name');
        $address = filter_input(INPUT_POST, 'address');
        $city = filter_input(INPUT_POST, 'city');
        $state = filter_input(INPUT_POST, 'state');
        $postal_code = filter_input(INPUT_POST, 'postal_code');
        $country_code = filter_input(INPUT_POST, 'country_code');
        $phone = filter_input(INPUT_POST, 'phone');
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        
        $fields = $this->validate->getFields();
        $fields->addField('first_name');
        $fields->addField('last_name');
        $fields->addField('address');
        $fields->addField('city');
        $fields->addField('state');
        $fields->addField('postal_code');
        $fields->addField('phone');
        $fields->addField('email');
        $fields->addField('password');
        $this->validate->setFields($fields);
        $this->validate->text('first_name', $first_name,true, 1, 51);
        $this->validate->text('last_name', $last_name,true, 1, 51);
        $this->validate->text('address', $address,true, 1, 51);
        $this->validate->text('city', $city,true, 1, 51);
        $this->validate->text('state', $state,true, 1, 51);
        $this->validate->text('postal_code', $postal_code,true, 1, 21);
        $this->validate->phone('phone', $phone,true);
        $this->validate->email('email', $email,true, 1, 51);
        $this->validate->text('password', $password,true, 6, 21);
        // Load appropriate view based on hasErrors
        if ($fields->hasErrors()) {
            $errors = array();
            foreach($fields->getFields() as $field){
                if($field->hasError()){
                    $errors[$field->getName()] = $field->getHTML();
                }
            }
            $customer_table = new CustomerTable($this->db);
            $customer = $customer_table->get_customer($customer_id);
            $countries = $customer_table->get_countries();
            include '../view/admin/customer_display.php';  
        } else {
            $customer_table = new CustomerTable($this->db);
            if($password == '******'){
                //Get the old password
                $customer = $customer_table->get_customer($customer_id);
                $password = $customer['password'];
            }else{
                $password = password_hash($password, PASSWORD_DEFAULT);        
            }
            $customer_table->update_customer($customer_id, $first_name, $last_name,
                $address, $city, $state, $postal_code, $country_code,
                $phone, $email, $password);
            $customer_table = new CustomerTable($this->db);
            $customers = $customer_table->get_customers_by_last_name($last_name);
            include '../view/admin/customer_search.php';
        }
    }
    
    private function processDisplayCustomers() {
        $last_name = filter_input(INPUT_POST, 'last_name');
        if (empty($last_name)) {
            $message = 'You must enter a last name.';
        } else {
            $customer_table = new CustomerTable($this->db);
            $customers = $customer_table->get_customers_by_last_name($last_name);
        }
        include '../view/admin/customer_search.php';
    }
    
    private function processLogout() {
        $_SESSION = array();
        session_destroy();
        $logout= 'You have been successfully logged out.';
        $username = '';
        $password = '';
        header("Location: /cs6252project2");
    }
    
    private function startSession() {
        session_start();
    }
}
?>