<?php

class Zendframework {
    function index(){
        ini_set('include_path', ini_get('include_path').':'.BASEPATH.'zendframework/');
    }
}
