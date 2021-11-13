<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Helpers\CollectionHelper;
use App\Http\Resources\ParentCategoriesResource;
use App\ParentCategories;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    //
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [
            'all',
            'consultantCategories'
        ]]);
    }

    public function all()
    {
        try {
            $data = ParentCategories::all();
            $response =  ParentCategoriesResource::collection($data);
            return response()->json([
                'code' => 200,
                'data' => $response
            ],200);
        }catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => $e
            ],404);
        }
    }

    public function consultantCategories() {
        try {
            $data = Categories::all();
            return response()->json([
                'code' => 200,
                'data' => $data
            ],200);
        }catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => $e
            ],404);
        }
    }

    public function random()
    {
        try {
            $data = Categories::inRandomOrder()->limit(5)->get();
            return response()->json([
                'code' => 200,
                'data' => $data
            ]);
        }  catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => $e
            ],404);
        }
    }

    public function city($city)
    {
        try {
            $data = DB::table('consultants')
                ->leftJoin('categories', 'consultants.category_id', '=', 
                'categories.id')
                ->select('consultants.id', 'consultants.name', 
                'categories.name AS position','consultants.likes_total',
                'consultants.city', 'consultants.photo')
                ->where('consultants.city', 'LIKE', '%' . $city . '%')
                ->paginate(10);
            // $paginated = CollectionHelper::paginate($data, 10);
            return response()->json([
                'code' => 200,
                'data' => $data
            ]);
        } catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => $e
            ],404);
        }
    }

    public function consultant($id)
    {
        try {
            $data = DB::table('consultants')
                        ->leftJoin('categories', 'consultants.category_id', '=', 
                        'categories.id')
                        ->select('consultants.id', 'categories.id AS category_id',
                        'consultants.name', 'categories.name AS position', 
                        'consultants.city', 'consultants.photo')
                        ->where('consultants.category_id', '=', $id)
                        ->paginate(5);
                        
            // $paginated = CollectionHelper::paginate($data, 10);
            return response()->json([
                'code' => 200,
                'data' => $data
            ]);
        } catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => $e
            ],404);
        }
    }
}
