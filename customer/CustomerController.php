<?php
require_once '../model/Database.php';
require_once '../util/secure_conn.php';
require_once '../model/ProductTable.php';
require_once '../model/CustomerTable.php';
require_once '../model/RegistrationTable.php';
require_once '../util/Util.php';

class CustomerController {
    private $action;
    
    public function __construct() {
        $this->action = '';
        $this->startSession();
        $this->db = new Database();
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
            case 'customer_login':
                $this->processCustomerLogin();
                break;
            case 'get_customer':
                $this->processGetCustomer();
                break;
            case 'show_registration':
                $this->processShowRegistration();
                break;
            case 'register_product':
                $this->processRegisterProduct();
                break;
            case 'logout':
                $this->processLogout();
                break;
            default:
                $this->processCustomerLogin();
                break;
        }
    }
    
    /****************************************************************
     * Process Request
     ***************************************************************/
    private function processCustomerLogin() {
        //Check if user already logged in
        if(!empty( $_SESSION['loggedin'])){
            $customer = $_SESSION['customer'];
            $product_table = new ProductTable($this->db);
            $products = $product_table->get_products();
            include '../view/customer/product_register.php';
        }else{
            $email = '';
            $password = '';
            include '../view/customer/customer_login.php';
        }
    }

    private function processGetCustomer() {
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        $customer_table = new CustomerTable($this->db);
        $validationResult = $customer_table->isValidLogin($email, $password);
        if ($validationResult !== false) {
            $customer = $customer_table->get_customer($validationResult);
            $_SESSION['loggedin'] = true;
            $_SESSION['customer'] = $customer;
            $product_table = new ProductTable($this->db);
            $products = $product_table->get_products();
            $success = "You are logged in as $email";
            include '../view/customer/product_register.php';
        } else {
            $error = 'Invalid username or password';
            include '../view/customer/customer_login.php';
        } 
    }
    
    private function processRegisterProduct() {
        $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_VALIDATE_INT);
        $product_code = filter_input(INPUT_POST, 'product_code');
        $registration_table = new RegistrationTable($this->db);
        $registration_table->add_registration($customer_id, $product_code);
        $message = "Product ($product_code) was registered successfully.";
        include '../view/customer/product_register.php';
    }
    
    private function processLogout() {
        $_SESSION = array();   
        session_destroy();     
        $logout= 'You have been successfully logged out.';
        $email = '';
        $password = '';
        include '../view/customer/customer_login.php';
    }
    
    private function startSession() {
        session_start();
    }
}

?>