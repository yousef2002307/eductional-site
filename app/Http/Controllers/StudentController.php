<?php

namespace App\Http\Controllers;

use App\Http\Resources\stures;
use App\Http\Resources\parentcode;
use App\Http\Resources\rateres;
use Illuminate\Http\Request;
use App\Repostories\StudenRepo;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\User;
/**
 * @group Student
 *
 * APIs for student
 */
class StudentController extends Controller
{
    /**
     * Subscribe to the service
     *
     * @bodyParam amount string required The amount of money to be paid. Example: 50
     * @response 200 {
     * "message": "Subscribed Successfully"
     * }
     * @response 401 {
     * "message": "User not authenticated"
     * }
     */
    public function success(Request $request)
    {

        $userid = Auth::user()->id;
      
        $repo = new StudenRepo();
        return $repo->success($userid);
    }

    /**
     * Unsubscribe from the service
     *
     * @response 200 {
     * "message": "Unsubscribed Successfully"
     * }
     * @response 401 {
     * "message": "User not authenticated"
     * }
     */
    public function cancel()
    {
        $userid = Auth::user()->id;
        $repo = new StudenRepo();
        return $repo->cancel($userid);
    }

    /**
     * Check if the user is subscribed
     *
     * @response 200 {
     * "subscribed": true
     * }
     * @response 401 {
     * "message": "User not authenticated"
     * }
     */
    public function is_Subscribe()
    {
        $userid = Auth::user()->id;
        $repo = new StudenRepo();
        return $repo->is_Subscribe($userid);
    }

    /**
     * Get the profile data of the user
     *
     * @response 200 {
     * "id": 1,
     * "name": "John Doe",
     * "email": "john@example.com",
     * "child_id": 1,
     * "study_year": 1 or 2 or 3 , // 1 = 1st year , 2 = 2nd year , 3 = 3rd year and these values are the only accepted vals 
     * "is_subscribed": true ,
     * "is_parent": true
     * }
     * @response 401 {
     * "message": "User not authenticated"
     * }
     */
    public function profiledata()
    {
        $userid = Auth::user()->id;
        $repo = new StudenRepo();
        $user = $repo->profiledata($userid);
        return new stures($user);
    }
    /**
     * Get the parent code of the user
     *
     * @response 200 {
     * "id": 1,
     * "parent_id": 1,
     * "code": "Parent Code"
     * }
     * @response 401 {
     * "message": "User not authenticated"
     * }
     */
    public function pcode(){
        $userid = Auth::user()->id;
        $repo = new StudenRepo();
        $user = $repo->pcode($userid);
        return new parentcode($user);
    }


    
    /**
     * Generate a new parent code for the user
     *
     * @response 200 {
     * "id": 1,
     * "parent_id": 1,
     * "code": "Parent Code"
     * }
     * @response 401 {
     * "message": "User not authenticated"
     * }
     */
    public function gpcode(){
        $userid = Auth::user()->id;
        $repo = new StudenRepo();
        $user = $repo->gpcode($userid);
        return new parentcode($user);
    }

    /**
     * Generate a new parent code for the user
     *
     * @response 200 {
     * "id": 1,
     * "parent_id": 1,
     * "code": "Parent Code"
     * }
     * @response 401 {
     * "message": "User not authenticated"
     * }
     */
    public function rgpcode(){
        $userid = Auth::user()->id;
        $repo = new StudenRepo();
        $user = $repo->rgpcode($userid);
        return new parentcode($user);
    }

    public function hisrate(){
        $userid = Auth::user()->id;
        $repo = new StudenRepo();
        $user = $repo->hisrate($userid);
        return $user;
    }
    public function hisattend(){
        $userid = Auth::user()->id;
        $repo = new StudenRepo();
        $user = $repo->hisattend($userid);
        return $user;
    }
    public function hislesson(){
        $userid = Auth::user()->id;
        
        $repo = new StudenRepo();
        $user = $repo->hislesson($userid);
        return $user;
    }

}

