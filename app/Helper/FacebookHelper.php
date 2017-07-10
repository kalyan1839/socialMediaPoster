<?php
// namespace App;

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\FileUpload\FacebookFile;

class FacebookHelper{

	private $fb;

	public function __construct(){

		$this->fb = new Facebook([
			'app_id' => env('facebook_app_id'),
			'app_secret' => env('facebook_app_secret'),
			'default_graph_version' => 'v2.9',
			'default_access_token' => env('facebook_access_token')
		]);
	}

	public function getPosts(){
		try {
		  $response = $this->fb->get('/me/feed?fields=id,message,actions,picture,likes,comments,shares,created_time');
		} catch(FacebookResponseException $e) {
		  return $e->getMessage();
		} catch(FacebookSDKException $e) {
		  return $e->getMessage();
		}

		return response()->json($response->getGraphEdge()->asArray());
	}

	public function getPost($id){
		try {
		  $response = $this->fb->get('/'.$id.'?fields=id,message,actions,picture,likes,comments,shares,created_time');
		} catch(FacebookResponseException $e) {
		  return $e->getMessage();
		} catch(FacebookSDKException $e) {
		  return $e->getMessage();
		}

		return response()->json($response->getGraphNode()->asArray());
	}

	public function createPost($request){
		$url = '/me/feed';
		$data = array();

		if($request->has('message')){
			$data['message'] = $request->message;
		}

		if($request->hasFile('image')){
			$data['source'] = $this->fb->fileToUpload($request->image);
			$url = '/me/photos';
		}

		try {
		  $response = $this->fb->post($url, $data);
		} catch(FacebookResponseException $e) {
		  return $e->getMessage();
		} catch(FacebookSDKException $e) {
		  return $e->getMessage();
		}

		return response()->json($response->getGraphNode()->asArray());
	}

}