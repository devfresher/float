<?php
class Language {

	function __construct() {

    	$this->invalid_credentials = "Invalid Credentials";
    	$this->invalid_amount = "Enter a valid amount";
    	$this->otp_sent = "OTP has been sent on your email";
    	$this->user_not_found = 'User not found';
    	$this->user_verified = 'Your account has been verified';
    	$this->account_not_verified = 'Account not verified. Check email to verify';
    	$this->account_not_active = 'Account not active';
    	$this->account_suspended = 'This account has been suspended from all transactions';
    	$this->incorrect_pin = 'Incorrect transaction pin';
		$this->insufficient_fund = 'Insufficient fund';
    
    	$this->login_success = "Login successful";
    	$this->accountno_exist = "Account number already exist";
    	$this->mobile_exist = "Mobile number already exist";
    	$this->username_exist = "Username already exist";
    	$this->user_noexist = "User does not exist";
    	$this->item_exist = "Item trying to create already exists";
    	$this->item_does_not_exist = "Item(s) does not exist";
    	$this->email_exist = "User Email already exist";
    	$this->phone_exist = "User Phone Number already exist";
    	$this->staff_id_exist = "Staff Id already exist";
    	$this->pass_len_6 = "Minimum password length must be 6";
    	$this->register_success = "Registration is successful";
    	$this->pass_reset_sent = 'Reset password link sent to email provided';
    	$this->pass_reset_not_sent = 'Reset password link not sent';
    	$this->pass_reset_error = 'Password reset failed';
    	$this->pass_updated = "Password changed successfully";
    	$this->search_result_not_found = "Keyword is not found Try different keyword";
        $this->password_sent = "Password has been sent on your email";
        $this->password_not_match = "Password does not match";
        $this->defaulttransactPIN = "Default transaction pin (0000) can not be used";
        $this->curr_transactpin_not_match = "Current transaction pin does not match";
        $this->curr_newtransactpin_match = "Current transaction pin must be different from New transaction pin";
        $this->accept_terms = 'You must agree with the Terms & Conditions';
    	$this->required_fields = "Fill all required field";
    	$this->receipient_is_sender = "Sender can not be the receipient";
    
    	$this->saved = "Saved Successfully";
    	$this->created = "Created Successfully";
		$this->txn_completed = "Transaction Completed";
    	$this->updated = "Updated successfully";
    	$this->deleted = "Deleted Successfully";
    
    	$this->request_failed = "Your request failed";
    	$this->unexpected_error = 'Unexpected error occured';
    
    	$this->plan_exist = "Plan already exist";
    	$this->category_exist = "Category already exist";
    	$this->transaction_not_found = "Transaction could not be found";
	}
	
}
?>