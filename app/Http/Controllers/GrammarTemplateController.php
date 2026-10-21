<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrammarTemplateRequest;
use App\Http\Requests\UpdateGrammarTemplateRequest;
use App\Models\GrammarTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GrammarTemplateController extends Controller
{
    public function index(Request $request): JsonResponse{
        $query = GrammarTemplate::query();
        if ($request->has('group')) {
            $query->where('group', $request->query('group'));
        }
        return response()->json($query->get());
    }

    public function store(StoreGrammarTemplateRequest $request) :JsonResponse{
        $grammarTemplate = GrammarTemplate::create($request->validated());
        return response()->json([
            'message' => 'Grammar created successfully!',
            'data'    => $grammarTemplate,
        ], 201);
    }

    public function update(UpdateGrammarTemplateRequest $request, GrammarTemplate $grammarTemplate){
        $grammarTemplate->update($request->validated());  
        return response()->json([
            'message' => 'Grammar updated successfully!',
            'data'    => $grammarTemplate,
        ], 201);  
    }

    public function destroy(GrammarTemplate $grammarTemplate): JsonResponse{
        $grammarTemplate->delete();
        return response()->json([
            'message' => 'Template deleted successfully!',
        ]);
    }
}

