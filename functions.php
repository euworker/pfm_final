<?php

function connect()
{
    $connect = mysqli_connect(
        'localhost', 'root', '', 'pfm'
    );
    
    mysqli_set_charset($connect, 'utf8');
    return $connect;
}

function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    $value = htmlentities($value);
    
    return $value;
}

function  name_check($string = ""){
    if ( !preg_match("/[^а-яёА-ЯЁ_]/u",$string)) {
            return 0;
        } else {  
            return 1;
    //false есть соответствие. возможны только русские буквы префикса
        }
}
// qwer и Апр дают один и тот же результат, хотя на https://regex101.com/ резулттат разный, сдела просто регуляркой, без функции

function  price_check($string = ""){
    // не использовал
    if ( !preg_match("/[^0-9]/",$string)) {
        return 0;
    } else {
        return 1;
    }
}


function  email_check($email){
    // любая буква, любая буква через тире, и проверки доменного имени + 
    if ( preg_match("/^[a-zA-Zа-яёА-ЯЁ_\d][-a-zA-Zа-яёА-ЯЁ0-9_\.\d]*\@[a-zA-Zа-яёА-ЯЁ\d][-a-zA-Zа-яёА-ЯЁ\.\d]*\.[a-zA-Zа-яА-Я]{2,6}$/i",$email)) {

        return 0;
    } else {
        return 1;
    }
}

function  password_check($password){
    if ( preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{3,10}$/",$password)) {

        return 0;
    } else {
        return 1;
    }
}



//  Здесь, мы использовали функцию trim для удаления пробелов из начала и конца строки.
// Функция stripslashes нужна для удаления экранированных символов 
// ("Ваc зовут O\'reilly?" => "Вас зовут O'reilly?").
// Функция strip_tags нужна для удаления HTML и PHP тегов. 
// Последня функция - htmlspecialchars преобразует специальные символы в HTML-сущности 
// ('&' преобразуется в '&amp;' и т.д.) 
// htmlentities — Преобразует все возможные символы в соответствующие HTML-сущности

// <!-- Дальше, создадим функцию для проверки длинны строки: -->


function check_length($value = "",$min, $max) {
    $result =  mb_strlen($value) < $min || mb_strlen($value) > $max;
    return $result;
}


// <!-- Здесь, мы использовали функцию mb_strlen для проверки длинны строки. 
// Первый параметр, $value это строка, которую нужно проверить, второй параметр $min минимально 
// допустимая длинна строки, третий параметр $max - максимально допустимая длинна. 
// Если длинна строки будет удовлетворительна, то функция вернет TRUE иначе FALSE. -->




// генерация токена
function generateToken($size = 32) {

    $symbols = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'f'];


    $symbolsLength = count($symbols); 
    $token = "";
    for ($i = 0; $i < $size; $i++) {
        //добавляем рандомный символ
        $token .= $symbols[rand(0,$symbolsLength - 1)];
        
    } 
    return $token;    
}


function check_cookie() {
   
    if (!isset($_COOKIE['uid'])){
        header("Location: ./register.php"); 
    } else {

     $connect = connect();
        $query = "
        SELECT `connect_user_id`, `connect_token`, `connect_token_time`
        FROM `connects`
        WHERE `connect_user_id` = ".$_COOKIE['uid']."
        AND `connect_token`= '".$_COOKIE['t']."'
         ;
    ";

        // UNIX_TIMESTAMP(
        $result = mysqli_query($connect, $query);

        if($result){
            while ($data = mysqli_fetch_assoc($result)) {

                $tt = $data['connect_token_time'];
                 
            }
            if (!empty($tt) && $tt>time()) {
                return true;
            } else {

                $token = generateToken();
                // нужно пересоздавать токен чаще
                $tokenTime = time() + 30 * 60;
                $userId = $_COOKIE['uid'];
    
                $query = "
                UPDATE `connects`
                SET 
                `connect_token` = '$token',
                `connect_token_time` = FROM_UNIXTIME($tokenTime)
                WHERE `connect_user_id` = $userId
                ;
                ";
                mysqli_query($connect,$query);
    
                // назвение куки, value, время жизни 2 дня, доступен на всем сайте
                //кука для токена
                setcookie("t", $token, time() + 2 * 24 * 3600, path:'/');
                // кука токентайма
                setcookie("tt", $tokenTime, time() + 2 * 24 * 3600, path:'/');
                mysqli_close($connect);
    


            }
        } 

        
        // header("Location: ./products.php"); 

    }




    // // дописать функцию
    // $connect = connect();
    // $query = "
    // SELECT `connect_user_id`, `connect_token`, `connect_token_time`
    // FROM `connects`
    // WHERE `user_email` = '$email' AND `user_password`= '$hashPassword';
    // ";
    // $result = mysqli_query($connect, $query);
    // $userInfo = mysqli_fetch_assoc($result);
    // $count = $userInfo['count'];

    //  }
    //  else {
    //      header("Location: ./register.php"); 
    // // }
    


            
}