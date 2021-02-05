<?php
class CSRF
{
    // Generate the characters
    public function GenString($length = 100) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ:-!=/#';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // Create a security token for a current situation
    public function CreateToken()
    {
        $current_url = $_SERVER['HTTP_X_FORWARDED_PROTO']."://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        $expire_to = 15 * 60; // Expires in 15 minutes
        $time_expire = time() + $expire_to;
        $token = CSRF::GenString();
       
        $GLOBALS['DB']->Insert('csrf', ['token' => $token, 'ip' => $ip, 'url' => $current_url, 'expire_time' => $time_expire]);
        return $token;
    }
    
    // Verify the token
    public function VerifyToken($csrf_token)
    {
        $referer_url = $_SERVER['HTTP_REFERER'];
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        $current_time = time();
        
        if ($GLOBALS['DB']->Count('csrf', ['token' => $csrf_token]) == 1)
        {
            $token_info = $GLOBALS['DB']->GetContent('csrf', ['token' => $csrf_token])[0];
            if ($token_info['ip'] == $ip && $current_time < $token_info['expire_time'] && $token_info['url'] == $referer_url)
            {
                $GLOBALS['DB']->Delete('csrf', ['id' => $token_info['id']]);
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    
    // Check that the action comes from ajax
    public function isAjaxRequest()
    {
        return (boolean)((isset($_SERVER['HTTP_X_REQUESTED_WITH'])) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
    }
}
?>