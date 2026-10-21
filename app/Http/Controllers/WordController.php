<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWordRequest;
use App\Http\Requests\UpdateWordRequest;
use App\Models\Category;
use App\Models\Word;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index(Request $request): JsonResponse{
        $query = Word::with('category');
        if ($request->has('category_id')) {
            $query->where('category_id', $request->query('category_id'));
        }
         return response()->json($query->get());
    }

    public function store(StoreWordRequest $request){
        $word = Word::create($request->validated());
        return response()->json([
            'message' => 'Word created successfully!',
            'data'    => $word,
        ], 201);
    }

    public function show(Word $word): JsonResponse{
        return response()->json($word->load('category'));
    }

    public function update(UpdateWordRequest $request, Word $word) :JsonResponse{
        $word->update($request->validated());
        return response()->json([
            'message' => 'Word updated successfully!',
            'data'    => $word,
        ], 201);
    }

    public function destroy(Word $word) :JsonResponse{
        $word->delete();
        return response()->json([
            'message' => 'Word deleted successfully!',
        ]);
    }
}

