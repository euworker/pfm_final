
<?php 

class UsersController  {

    private $userModel;
    private $helper;
    private $isAuthorized;
    
    public $userIsAdmin;
  
    public $menuProducts;

    public function __construct() {
        $this->userModel = new User();
        $this->helper = new Helper();
        $this->isAuthorized = $this->userModel->checkIfUserAuthorized();
        global $menuProducts;
        $this->menuProducts = $menuProducts;
   
    }


    public function actionReg(){
        $h1 = 'Регистрация';
        $title = 'Регистрация';
        

        $errors = [];
        include_once("functions.php");

        if (isset($_POST['user_email'])) {
            $email = clean($_POST['user_email']);
            $password = clean($_POST['user_password']);
            $passwordRepeat = clean($_POST['user_password_repeat']);

            if (email_check($email) === 1 || check_length($email,5,100)) {
                $errors[] = "Не корректные данные в поле 'email'";

            } else {
                
                if (($password !== $passwordRepeat) || (empty($password) || empty($passwordRepeat)) || password_check($password) === 1) {
                    $errors[] = "Пароли не совпадают, пусты или не корректны ";

            } else {
                $count = $this->userModel->checkIfUserExists($email);

                if ($count === "1") {
                    $errors[] = "Такой email уже зарегистрирован";
                }

                if (empty($errors)) {
                    $hashedPassword = md5($password);
                    $this->userModel->register($email,$hashedPassword);
                    $userInfo = $this->userModel->getUserInfo($email,$hashedPassword);

                    $token = $this->helper->generateToken();
                    $tokenTime = time() + 30 * 60;
                    $userId = $userInfo['user_id'];

                    $this->userModel->auth($userId, $token, $tokenTime) ;
                    
                    setcookie("uid", $userInfo['user_id'], time() + 2 * 24 * 3600, path:'/');
                    setcookie("t", $token, time() + 2 * 24 * 3600, path:'/');
                    setcookie("tt", $tokenTime, time() + 2 * 24 * 3600, path:'/');
                    header("Location: " . FULL_SITE_ROOT . 'cart');

                    } 
                }
                
            }

    
        }

        include_once("views/users/reg.html");


    }

    public function actionAuth(){
        $h1 = 'Авторизация';
        $title = 'Авторизация';
$errors = [];
     // подключаем файл с проверками
     include_once("functions.php");

if (isset($_POST['user_email'])) {
    $email = clean($_POST['user_email']);
    $password = clean($_POST['user_password']);
    
    // проверки
    if (email_check($email) === 1 || check_length($email,5,100)) {
        $errors[] = "Не корректные данные в поле 'email'";
    } else {
    if (empty($password) || password_check($password) === 1) {
        $errors[] = "Пароль не корректен";
    } else {
        $hashedPassword = md5($password);
        $userInfo = $this->userModel->getUserInfo($email,$hashedPassword);
        if ($userInfo['count'] === "0")  {
            $errors[] = "Такой связки email/пароль не существует";
        }
        // если ошибок нет
        if (empty($errors)) {
            $token = $this->helper->generateToken();
            $tokenTime = time() + 30 * 60;
            $userId = $userInfo['user_id'];            
            $this->userModel->auth($userId, $token, $tokenTime);

            // назвение куки, value, время жизни 2 дня, доступен на всем сайте
            setcookie("uid", $userInfo['user_id'], time() + 2 * 24 * 3600, path:'/');
            //кука для токена
            setcookie("t", $token, time() + 2 * 24 * 3600, path:'/');
            // кука токентайма
            setcookie("tt", $tokenTime, time() + 2 * 24 * 3600, path:'/');
            if ($this->userModel->checkIfUserIsAdmin($email) == 1) {
                setcookie("ad", "1", time() + 2 * 24 * 3600, path:'/');
            }


            header("Location: " . FULL_SITE_ROOT . 'cart');

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
        if (isset($_COOKIE["ad"])) {
            setcookie("ad", "", time() + 2 * 24 * 3600, path:'/');
        }
        
        

        header("Location: " . FULL_SITE_ROOT );
    }



}

?>

