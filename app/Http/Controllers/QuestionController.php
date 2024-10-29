<?php

namespace App\Http\Controllers;

use App\Models\Aque;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Routing\Controller as BaseController;
/**
 * @group questions endpoint
 * 
 * APIs for questions
 */
class QuestionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
        $this->middleware(AdminMiddleware::class)->only(['store', 'update', 'destroy']);
    }
    public function index(Request $request)
    {
        /**
         * @OA\Get(
         *     path="/questions",
         *     summary="Get all questions by quiz id",
         *     tags={"questions"},
         *     @OA\Parameter(
         *         in="path",
         *         name="quiz_id",
         *         required=true,
         *         description="Quiz id",
         *         @OA\Schema(type="string")
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Successful response"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Not Found"
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Unauthorized"
         *     )
         * )
         */
        return Aque::where('quiz_id', $request->quiz_id)->get()->toArray() ?? response('Not Found', 404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /**
         * @OA\Post(
         *     path="/questions",
         *     summary="Store a new question",
         *     tags={"questions"},
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             type="object",
         *             @OA\Property(property="question_text", type="string", example="Question Text"),
         *             @OA\Property(property="quiz_id", type="integer", example="1")
         *         )
         *     ),
         *     @OA\Response(
         *         response=201,
         *         description="Resource Created"
         *     ),
         *     @OA\Response(
         *         response=400,
         *         description="Bad Request"
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Unauthorized"
         *     )
         * )
         */
        $request->validate([
            'question_text' => 'required | string',
            'quiz_id' => 'required | numeric | exists:quizzes,id',

        ]);
        return Aque::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /**
         * @OA\Get(
         *     path="/questions/{id}",
         *     summary="Get a question by id",
         *     tags={"questions"},
         *     @OA\Parameter(
         *         in="path",
         *         name="id",
         *         required=true,
         *         description="Question id",
         *         @OA\Schema(type="string")
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Successful response"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Not Found"
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Unauthorized"
         *     )
         * )
         */
        $que = Aque::find($id);
        if($que){
            return $que;
        }else{
            return response('Not Found', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /**
         * @OA\Patch(
         *     path="/questions/{id}",
         *     summary="Update a question by id",
         *     tags={"questions"},
         *     @OA\Parameter(
         *         in="path",
         *         name="id",
         *         required=true,
         *         description="Question id",
         *         @OA\Schema(type="string")
         *     ),
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             type="object",
         *             @OA\Property(property="question_text", type="string", example="Question Text"),
         *             @OA\Property(property="quiz_id", type="integer", example="1")
         *         )
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Successful response"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Not Found"
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Unauthorized"
         *     )
         * )
         */
        $newque = Aque::find($id);
        if($newque){
            $newque->update($request->all());
            return $newque;
        }else{
            return response('Not Found', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /**
         * @OA\Delete(
         *     path="/questions/{id}",
         *     summary="Delete a question by id",
         *     tags={"questions"},
         *     @OA\Parameter(
         *         in="path",
         *         name="id",
         *         required=true,
         *         description="Question id",
         *         @OA\Schema(type="string")
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Successful response"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Not Found"
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Unauthorized"
         *     )
         * )
         */
        return Aque::destroy($id);
    }
}
