<?php

abstract class BaseController {

    public $answer;

    public function showAnswer(){
        header("HTTP/1.1 200 OK");
        echo json_encode($this->answer, JSON_UNESCAPED_UNICODE);

    }
 
    public function showNotFound(){
        header("HTTP/1.1 404 Not found");
        // дописать вьюхи 
            //  в конце ошибки должно быть exit;
    }

    public function showUnauthorized(){
        header("HTTP/1.1 403 Unauthorized");
    }

    public function showBadRequest(){
        header("HTTP/1.1 401 Bad request");
        echo json_encode($this->answer, JSON_UNESCAPED_UNICODE);
    }

}

?>