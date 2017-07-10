<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FacebookHelper;

class FacebookController extends Controller
{
    private $fb;

    // public function __construct(FacebookHelper $fb){
    // 	$this->$fb = $fb;
    // }

    public function index(FacebookHelper $fb){
    	return $fb->getPosts();
    }

    public function show($id, FacebookHelper $fb){
    	return $fb->getPost($id);
    }

    public function store(Request $request, FacebookHelper $fb){
    	return $fb->createPost($request);
    }
}
