<?php

class User {

    private $connect;
    private $helper;
        

    public function __construct(){
        $this->connect = DB::getConnection();
        $this->helper = new Helper();

    }


    public function checkIfUserExists($email) {

        $query = "SELECT COUNT(*) as `count`
                    FROM `users`
                    WHERE `user_email` = '$email';
                    ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result)['count']; 

    }

public function register($email,$hashedPassword) {

             $query = "INSERT INTO `users`
                        SET `user_email` = '$email',
                            `user_password` = '$hashedPassword',
                            `user_is_admin` = 0;
                        ";
            return mysqli_query($this->connect, $query);
}



public function getUserInfo($email,$hashedPassword) {

        $query = "SELECT COUNT(*) as `count`, `user_id`
                    FROM `users`
                    WHERE `user_email` = '$email' AND `user_password`= '$hashedPassword'
                    ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result);
   
}

public function checkIfUserIsAdmin($email) {

    $query = "SELECT `user_is_admin`
                FROM `users`
                WHERE `user_email` = '$email'
                ";
    $result = mysqli_query($this->connect, $query);
    $res = mysqli_fetch_assoc($result);

    if (array_shift($res) == 1 ) {
        return 1;
    } else {
        return 0;
    }
      
}


public function auth($userId, $token, $tokenTime) {
                $query = "INSERT INTO `connects`
                            SET 
                            `connect_user_id` = $userId,
                            `connect_token` = '$token',
                            `connect_token_time` = FROM_UNIXTIME($tokenTime);
                            ";
           return mysqli_query($this->connect,$query);
}

public function checkIfUserAuthorized() {

    if (!isset($_COOKIE['uid']) || !isset($_COOKIE['t']) || !isset($_COOKIE['tt'])) {
        return false;
    }
    $userId = htmlentities($_COOKIE['uid']);
    $token = htmlentities($_COOKIE['t']);
    $tokenTime = htmlentities($_COOKIE['tt']);
    $query = "SELECT `connect_id`
                FROM `connects`
                WHERE `connect_user_id` = $userId
                AND `connect_token` = '$token'
                LIMIT 1
                ";
    $result = mysqli_query($this->connect,$query);

    if (mysqli_num_rows($result) === 0) {
        return false;    
    }
    if ($tokenTime < time()) {
        $newToken = $this->helper->generateToken();
        $newTokenTime = time() + 30 * 60;
                setcookie("uid", $userId, time() + 2 * 24 * 3600, path:'/');
                setcookie("t", $newToken, time() + 2 * 24 * 3600, path:'/');
                setcookie("tt", $newTokenTime, time() + 2 * 24 * 3600, path:'/'); 
        $result = mysqli_fetch_assoc($result) ;
        $connectId = $result['connect_id'];
                $query = "UPDATE `connects`
                            SET `connect_token` = '$newToken',
                                `connect_token_time` = FROM_UNIXTIME($tokenTime)
                            WHERE `connect_id` = $connectId
                            "; 
                mysqli_query($this->connect,$query); 
    }
    return true;
}

public function logout() {
    if (isset($_COOKIE['uid']) && isset($_COOKIE['t'])) {
        $userId = htmlentities($_COOKIE['uid']);
        $token = htmlentities($_COOKIE['t']);
        $query = "DELETE FROM `connects`
                    WHERE `connect_user_id` = $userId
                    AND `connect_token` = '$token'
                    ";
                    return mysqli_query($this->connect,$query); 
    }
}

}