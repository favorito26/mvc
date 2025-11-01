<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller; // Import the Controller class from the correct namespace




class SiteController extends Controller
{
    public function home(){
        $params = [
            'name' => 'Mufaddal',
            'title' => 'Home - Welcome to Our Website' // Add title
        ];
        return $this->render('home', $params);
    }
    public function contact(){
        return $this->render('contact');
    }
    public function handleContact(){
        return 'Handling submitted data';
    }
}

?>