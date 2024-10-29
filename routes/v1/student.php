<?php
use Illuminate\Support\Facades\Route;

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;

use Laravel\Fortify\RoutePath;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use App\Http\Controllers\AttendController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\AdminController;

use App\Http\Middleware\IsSub;

use App\Http\Controllers\AdminOnStudentOperationsController;
use App\Http\Controllers\AdminOnParentOperationsController;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Models\User;

use App\Http\Middleware\ActiveMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnsController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\ResultController;

Route::get("/rr",function(){
// return User::find(20)->code;
// $quiz = Quiz::find(1);
// $questions = $quiz->questions;
//  return $questions;
// $que = Aque::find(1);
// return $que->answers;
// return $que->quiz;
// return Code::find(1)->user;
 });//->middleware(IsSub::class)->name("rr");
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware(ActiveMiddleware::class);
// Route::get("/deletetoken",function(){
//     $user = Auth::user();
//     if (!$user) {
//         // Handle the case where the user is not authenticated
//         return response()->json(['message' => 'User not authenticated'], 401);
//     }

//     $token = $user->tokens()->delete();

//     // Return the token or store it for later use
//     return response()->json(['token' => 'token has been deleted']);
    
// });
Route::get("/hislesson",[App\Http\Controllers\StudentController::class,"hislesson"])->middleware([ActiveMiddleware::class,IsSub::class]);
Route::post("/success",[App\Http\Controllers\StudentController::class,"success"])->middleware(ActiveMiddleware::class);
Route::post("/cancel",[App\Http\Controllers\StudentController::class,"cancel"])->middleware(ActiveMiddleware::class);
Route::get("/is_Subscribe",[App\Http\Controllers\StudentController::class,"is_Subscribe"])->middleware(ActiveMiddleware::class);
Route::get("/profile",[App\Http\Controllers\StudentController::class,"profiledata"])->middleware(ActiveMiddleware::class);
Route::get("/parentcode",[App\Http\Controllers\StudentController::class,"pcode"])->middleware(ActiveMiddleware::class);
Route::post("/generateparentcode",[App\Http\Controllers\StudentController::class,"gpcode"])->middleware(ActiveMiddleware::class);
Route::post("/regenerateparentcode",[App\Http\Controllers\StudentController::class,"rgpcode"])->middleware(ActiveMiddleware::class);
Route::get("/hisrate",[App\Http\Controllers\StudentController::class,"hisrate"])->middleware(ActiveMiddleware::class);
Route::get("/hisattend",[App\Http\Controllers\StudentController::class,"hisattend"])->middleware(ActiveMiddleware::class);
Route::post("/parentlogin",[ParentController::class,"login"])->withoutMiddleware("auth:sanctum");
Route::post("/getlast5rating",[ParentController::class,"getlast5rating"])->withoutMiddleware("auth:sanctum");
Route::post("/getlast5attendence",[ParentController::class,"getlast5attendence"])->withoutMiddleware("auth:sanctum");
Route::post("/getlast5result",[ParentController::class,"getlast5result"])->withoutMiddleware("auth:sanctum");

Route::post("/getpay",[ParentController::class,"getpay"])->withoutMiddleware("auth:sanctum");



//////////rating routes
Route::resource('rate', RateController::class)->middleware(ActiveMiddleware::class);
Route::resource('question', QuestionController::class)->middleware([ActiveMiddleware::class]);
Route::resource('quiz', QuizController::class)->middleware([ActiveMiddleware::class]);
Route::resource('response', ResponseController::class)->middleware([ActiveMiddleware::class]);
Route::resource('result', ResultController::class)->middleware([ActiveMiddleware::class]);
Route::resource('ans', AnsController::class)->middleware([ActiveMiddleware::class]);
Route::resource('attend', AttendController::class)->middleware(ActiveMiddleware::class);

Route::resource('students', AdminOnStudentOperationsController::class)->middleware([ActiveMiddleware::class,AdminMiddleware::class]);















Route::resource('parent', AdminOnParentOperationsController::class)->middleware([ActiveMiddleware::class,AdminMiddleware::class]);
Route::get('/actdis/{id}',[AdminController::class,"actdis"])->middleware([ActiveMiddleware::class,AdminMiddleware::class]);

Route::get('/getstudentstatus/{id}',[AdminController::class,"actdis2"])->middleware([ActiveMiddleware::class,AdminMiddleware::class]);
Route::get('/getpaymentsrecored',[AdminController::class,"paymentsrecords"])->middleware([ActiveMiddleware::class,SuperAdminMiddleware::class]);

Route::get('/paymentstatus/{id}',[AdminController::class,"paymentstatus"])->middleware([ActiveMiddleware::class,AdminMiddleware::class]);
Route::get('/admlessonsid/{id}',[AdminController::class,"lessonsid"])->middleware([ActiveMiddleware::class,SuperAdminMiddleware::class]);
Route::get('/admlessons',[AdminController::class,"lessons"])->middleware([ActiveMiddleware::class,SuperAdminMiddleware::class]);
Route::get('/admlessonsy/{id}',[AdminController::class,"lessonsy"])->middleware([ActiveMiddleware::class,SuperAdminMiddleware::class]);
//////fortify stuff



Route::put("/user/profile-information",function(Request $request){
    // Get the authenticated user
    $user = Auth::user();

    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422); // Unprocessable Entity
    }

    // Update user's name and email
    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();

    // Return a success response
    return response()->json([
        'message' => 'Profile updated successfully',
        'user' => $user
    ], 200); // OK
});


Route::put("/user/password",function(Request $request){
        // Get the authenticated user
        $user = Auth::user();

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // Unprocessable Entity
        }
    
        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'error' => 'Current password is incorrect.'
            ], 401); // Unauthorized
        }
    
        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();
    
        // Return a success response
        return response()->json([
            'message' => 'Password updated successfully'
        ], 200); // OK
});





Route::post(RoutePath::for('password.email', '/forgot-password'), [PasswordResetLinkController::class, 'store'])
->middleware(['guest:'.config('fortify.guard')])
->name('password.email')->withoutMiddleware("auth:sanctum");

Route::post("/register",function(Request $request){
    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        "studyyear" => 'required'
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422); // Unprocessable Entity
    }

    // Create a new user instance
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'studyyear' => $request->studyyear // Hash the password
    ]);
    $hashedemail =URL::temporarySignedRoute('verifemail', now()->addSeconds(30), ['id' => $user->id]); ;
    // $user->notify(new \App\Notifications\verifyemail($user,$hashedemail));
    // Return a success response
    return response()->json([
        'message' => 'User registered successfully',
        'user' => $user
    ], 201); // Created
})->withoutMiddleware("auth:sanctum");


