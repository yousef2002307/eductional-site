<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Answer;
/**
 * @group answer endpoint
 * 
 * APIs for answer
 */
class AnsController extends BaseController
{


     public function __construct()
    {
        $this->middleware(AdminMiddleware::class)->only(['store', 'update', 'destroy']);
    }
        /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /**
         * @OA\Get(
         *     path="/answer",
         *     summary="Get answers",
         *     description="Get answers by question id",
         *     operationId="getAnswers",
         *     tags={"answer"},
         *     @OA\Parameter(
         *         description="question id",
         *         in="query",
         *         name="question_id",
         *         required=true,
         *         example="1",
         *         @OA\Schema(
         *             type="integer",
         *             format="int64"
         *         )
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="successful operation"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Not Found"
         *     )
         * )
         */
        return Answer::where('question_id', $request->question_id)->get()->toArray() ?? response('Not Found', 404);
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
         *     path="/answer",
         *     summary="create answer",
         *     description="create answer",
         *     operationId="createAnswer",
         *     tags={"answer"},
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             type="object",
         *             @OA\Property(
         *                 property="answer_text",
         *                 type="string",
         *                 example="answer text"
         *             ),
         *             @OA\Property(
         *                 property="question_id",
         *                 type="integer",
         *                 format="int64",
         *                 example=1
         *             ),
         *             @OA\Property(
         *                 property="is_correct",
         *                 type="boolean",
         *                 example=true
         *             )
         *         )
         *     ),
         *     @OA\Response(
         *         response=201,
         *         description="created"
         *     ),
         *     @OA\Response(
         *         response=400,
         *         description="Bad Request"
         *     )
         * )
         */
        $request->validate([
            'answer_text' => 'required | string',
            'question_id' => 'required | numeric | exists:questions,id',
            "is_correct" => 'required | boolean',

        ]);
        return Answer::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /**
         * @OA\Get(
         *     path="/answer/{id}",
         *     summary="get answer by id",
         *     description="get answer by id",
         *     operationId="getAnswerById",
         *     tags={"answer"},
         *     @OA\Parameter(
         *         description="answer id",
         *         in="path",
         *         name="id",
         *         required=true,
         *         example="1",
         *         @OA\Schema(
         *             type="integer",
         *             format="int64"
         *         )
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="successful operation"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Not Found"
         *     )
         * )
         */
        $que = Answer::find($id);
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
         * @OA\Put(
         *     path="/answer/{id}",
         *     summary="update answer",
         *     description="update answer",
         *     operationId="updateAnswer",
         *     tags={"answer"},
         *     @OA\Parameter(
         *         description="answer id",
         *         in="path",
         *         name="id",
         *         required=true,
         *         example="1",
         *         @OA\Schema(
         *             type="integer",
         *             format="int64"
         *         )
         *     ),
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             type="object",
         *             @OA\Property(
         *                 property="answer_text",
         *                 type="string",
         *                 example="answer text"
         *             ),
         *             @OA\Property(
         *                 property="question_id",
         *                 type="integer",
         *                 format="int64",
         *                 example=1
         *             ),
         *             @OA\Property(
         *                 property="is_correct",
         *                 type="boolean",
         *                 example=true
         *             )
         *         )
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="successful operation"
         *     ),
         *     @OA\Response(
         *         response=400,
         *         description="Bad Request"
         *     )
         * )
         */
        $request->validate([
            'answer_text' => 'string',
            'question_id' => 'numeric | exists:questions,id',
            "is_correct" => 'boolean',

        ]);
        $newque = Answer::find($id);
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
         *     path="/answer/{id}",
         *     summary="delete answer",
         *     description="delete answer",
         *     operationId="deleteAnswer",
         *     tags={"answer"},
         *     @OA\Parameter(
         *         description="answer id",
         *         in="path",
         *         name="id",
         *         required=true,
         *         example="1",
         *         @OA\Schema(
         *             type="integer",
         *             format="int64"
         *         )
         *     ),
         *     @OA\Response(
         *         response=204,
         *         description="No Content"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Not Found"
         *     )
         * )
         */
        return Answer::destroy($id);
    }
}
