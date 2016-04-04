<?php 

class Ajax extends Public_Controller 
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        echo 'Hello from the Ajax index method';
    }
    
    public function submit()
    {
        echo 'Hello from the Ajax submit method';
    }
}