
<?php 

class UsersController {

    private $userModel;
    private $helper;
    private $isAuthorized;

    public function __construct() {
        $this->userModel = new User();
        $this->helper = new Helper();
        $this->isAuthorized = $this->userModel->checkIfUserAuthorized();
    }


    public function actionReg(){

        

        $errors = [];
        // пераписать под ООП functions
        include_once("functions.php");

        if (isset($_POST['user_email'])) {
        // написать проверки что это емаеил - регулярками
            $email = clean($_POST['user_email']);
            $password = clean($_POST['user_password']);
            $passwordRepeat = clean($_POST['user_password_repeat']);
            // проверки

            if (email_check($email) === 1 || check_length($email,5,100)) {
                $errors[] = "Не корректные данные в поле 'email'";
            } else {
            if (($password !== $passwordRepeat) || (empty($password) || empty($passwordRepeat)) || password_check($password) === 1) {
                $errors[] = "Пароли не совпадают, пусты или не корректны ";
            } else {
                $count = $this->userModel->checkIfUserExists($email);
                //    проверяем наличие емаил 
                if ($count === "1") {
                    $errors[] = "Такой email уже зарегистрирован";
                }
                // если ошибок нет
                if (empty($errors)) {
                    // шифруем пароль
                    $hashedPassword = md5($password);
                    $this->userModel->register($email,$hashedPassword);

                    // _________________________________________ повторяю данные из авторизации 

                    //________________ переписать под ооп??? в отдельном классе или в файл functions? Есть же новый
                    // $query = "
                    // SELECT COUNT(*) as `count`, `user_id`
                    // FROM `users`
                    // WHERE `user_email` = '$email' AND `user_password`= '$hashPassword';
                    // ";
                    // $result = mysqli_query($connect, $query);
                    // $userInfo = mysqli_fetch_assoc($result);


                    // $token = generateToken();
                    // // нужно пересоздавать токен чаще
                    // $tokenTime = time() + 30 * 60;
                    // $userId = $userInfo['user_id'];

                    // $query = "
                    // INSERT INTO `connects`
                    // SET 
                    // `connect_user_id` = $userId,
                    // `connect_token` = '$token',
                    // `connect_token_time` = FROM_UNIXTIME($tokenTime);
                    // ";
                    // mysqli_query($connect,$query);
                    

                    // // назвение куки, value, время жизни 2 дня, доступен на всем сайте
                    // setcookie("uid", $userInfo['user_id'], time() + 2 * 24 * 3600, path:'/');
                    // //кука для токена
                    // setcookie("t", $token, time() + 2 * 24 * 3600, path:'/');
                    // // кука токентайма
                    // setcookie("tt", $tokenTime, time() + 2 * 24 * 3600, path:'/');

                    // // _________________________________________________________ конец функциональности из авторизации  

                    // mysqli_close($connect);
                    //________________ всё, что выше переписать под ооп, в отдельном классе или в файл functions


                    header("Location: " . FULL_SITE_ROOT . "manufacturers");

                    }

                }
            }

    
        }

        include_once("views/users/reg.html");


    }

    public function actionAuth(){

$errors = [];
     // пераписать под ООП functions
     include_once("functions.php");

if (isset($_POST['user_email'])) {
// написать проверки что это емаеил - регулярками
    $email = clean($_POST['user_email']);
    $password = clean($_POST['user_password']);
    
    // проверки
    if (email_check($email) === 1 || check_length($email,5,100)) {
        $errors[] = "Не корректные данные в поле 'email'";
    } else {
    if (empty($password) || password_check($password) === 1) {
        $errors[] = "Пароли не совпадают, пусты или не корректны ";
    } else {
        $hashedPassword = md5($password);

        // $connect = connect();
        // $query = "
        // SELECT COUNT(*) as `count`, `user_id`
        // FROM `users`
        // WHERE `user_email` = '$email' AND `user_password`= '$hashedPassword';
        // ";
        // $result = mysqli_query($connect, $query);
        // $userInfo = mysqli_fetch_assoc($result);
        // $count = $userInfo['count']; 
        //    проверяем наличие емаил 


        $userInfo = $this->userModel->getUserInfo($email,$hashedPassword);
        if ($userInfo['count'] === "0")  {
            $errors[] = "Такой связки email/пароль не существует";
        }
        // если ошибок нет
        if (empty($errors)) {
            $token =$this->helper->generateToken();
            // нужно пересоздавать токен чаще
            $tokenTime = time() + 30 * 60;
            $userId = $userInfo['user_id'];

            // $query = "
            // INSERT INTO `connects`
            // SET 
            // `connect_user_id` = $userId,
            // `connect_token` = '$token',
            // `connect_token_time` = FROM_UNIXTIME($tokenTime);
            // ";
            // mysqli_query($connect,$query);
            $this->userModel->auth($userId, $token, $tokenTime);

            // назвение куки, value, время жизни 2 дня, доступен на всем сайте
            setcookie("uid", $userInfo['user_id'], time() + 2 * 24 * 3600, path:'/');
            //кука для токена
            setcookie("t", $token, time() + 2 * 24 * 3600, path:'/');
            // кука токентайма
            setcookie("tt", $tokenTime, time() + 2 * 24 * 3600, path:'/');

            header("Location: " . FULL_SITE_ROOT . "manufacturers");

        }

    }

    
}


}


        include_once("views/users/auth.html");
        
    }

    public function actionLogout() {

        $this->userModel->logout();
        //удаляем значения из кук
        setcookie("uid", "", time() - 2 * 24 * 3600, path:'/');
        //кука для токена
        setcookie("t", "", time() - 2 * 24 * 3600, path:'/');
        // кука токентайма
        setcookie("tt", 0, time() - 2 * 24 * 3600, path:'/');

        header("Location: " . FULL_SITE_ROOT . "manufacturers");
    }



}

?>

