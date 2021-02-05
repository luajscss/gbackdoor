<?php
ini_set('session.cookie_httponly', 1);
session_start();

class Account
{
    // Authenticate the user
    public function Auth($username, $password)
    {
        if (Account::isUsernameExist($username))
        {
            $user = $GLOBALS['DB']->GetContent("users", ["username" => $username])[0];
            if(Account::isPasswordTrue($user, $password))
            {
                $_SESSION['id'] = $user["id"];
                return true;
            }
        }
        return false;
    }
    
    // Check if a user's id exists
    public function CheckID($id)
    {
        if ($GLOBALS['DB']->Count('users', ['id' => $id]) == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    // Verify if the user is authenticated
    public function isAuthentified()
    {
         return isset($_SESSION['id']);
    }
    
    // Gets the Username of the user
    public function GetUsername($id = null)
    {
        if ($id == null)
        {
            $id = $_SESSION['id'];
        }
        
        $username = Account::GetUser($id)['username'];
        return $username;
    }
    
    // Deletes a user via ID
    public function DeleteUser($user_id)
    {
        $username = Account::GetUser($user_id)['username'];
        $GLOBALS['DB']->Delete('users', ['id' => $user_id]);
        Logs::AddLogs("<p class='text-danger'>[".date('d/m/Y at H:i:s', time())."]&nbsp;<i class='fa fa-close'></i>&nbsp;Username ".$username." has been deleted</p>");
    }
    
    // Récupére un utilisateur grace à son id
    public function GetUser($user_id = null)
    {
        if ($user_id == null)
        {
            $user_id = $_SESSION['id'];    
        }
        
        return $GLOBALS['DB']->GetContent('users', ['id' => $user_id])[0];
    }
    
    // Change the password of a user.
    // Now this is some spicy shit.
    public function ChangePassword($old_password, $new_password, $confirm_new_password)
    {
        $user = $GLOBALS['DB']->GetContent('users', ['id' => $_SESSION['id']])[0];
        if (Account::isPasswordTrue($user, $old_password))
        {
               if ($new_password == $confirm_new_password)
               {
                   	$salt = sha1(dechex(mt_rand(0, 2147483647)).dechex(mt_rand(0, 2147483647)));
		            $hash_password = $new_password.$salt;
		        	for($i = 0; $i<500; $i++)
            		{
            		   $hash_password = hash('sha256', $hash_password); 
            		}
		            $password_protection = $hash_password.":".$salt;
		
                    $GLOBALS['DB']->Update('users', ['id' => $_SESSION['id']], ['password' => $password_protection]);
              
                    return "success";
               }
               else {
                   return "The new password does not match.";
               }
        }
        else {
            return "The old password is invalid.";
        }
    }
    
    // Vérifie si un nom d'utilisateur existe
    public function isUsernameExist($username)
    {
        if ($GLOBALS['DB']->Count("users", ["username" => $username]) != 0)
        {
            return true;
        }
        return false;
    }
    
    // Gets an ID by Username
    public function GetIdByUsername($username)
    {
        if (Account::isUsernameExist($username))
        {
            return $GLOBALS['DB']->GetContent("users", ["username" => $username])[0]['id'];
        }
        else
        {
            return false;
        }
    }
    
    // Check the password with the Salt
    private function isPasswordTrue($user, $password)
    {
    	$password_check = explode(":", $user["password"]);
    	$password_to_check = $password.$password_check[1];
    	for($i = 0; $i<500; $i++)
		{
		   $password_to_check = hash('sha256', $password_to_check); 
		}
		
		if ($password_check[0] == $password_to_check)
		{
		    return true;
		}
		return false;
    }
    
    // Create a User
    public function CreateUser($username, $password, $confirm_password)
    {
		if ($password != $confirm_password)
		{
			return "The password does not match.";
		}
		else if (Account::isUsernameExist($username))
		{
			return "The nickname requested and already in use.";
		}

       	$salt = sha1(dechex(mt_rand(0, 2147483647)).dechex(mt_rand(0, 2147483647)));
        $hash_password = $password.$salt;
    	for($i = 0; $i<500; $i++)
		{
		   $hash_password = hash('sha256', $hash_password); 
		}
        $password_protection = $hash_password.":".$salt;

		$GLOBALS['DB']->Insert("users", ["username" => $username, "password" => $password_protection]);

        Logs::AddLogs("<p class='text-primary'>[".date('d/m/Y at H:i:s', time())."]&nbsp;<i class='fa fa-plus'></i>&nbsp;The new user ".$username." was created</p>");

        return "success";
    }
    
    // Disconnect the user
    public function Disconnect()
    {
        session_unset();
        session_destroy();
    }
    
    // Gets the number of users
    public function GetAccountNbr()
    {
        return $GLOBALS['DB']->Count("users");
    }
    
    // Get all Accounts
    public function GetAllAccount()
    {
        return $GLOBALS['DB']->GetContent("users");
    }
    
    // Set a user's Name
    public function SetUsername($id, $username)
    {
        $GLOBALS['DB']->Update('users', ['id' => $id], ['username' => $username]);
    }
}
?>