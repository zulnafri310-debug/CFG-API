<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateRequest;
use App\Services\GrammarEngineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DialogueController extends Controller
{
    public function __invoke(GenerateRequest $request, GrammarEngineService $engine) :JsonResponse
    {

        $count = $request->validated('count') ?? 1;
        $seed  = $request->validated('seed');
        $group = $request->validated('group');

        $dialogue = [];
        for($i = 0; $i < $count; $i++)
        {
            $currentSeed = ($seed !== null) ? ($seed + $i) : null;
            $dialogue[] = $engine->generate(group: $group, seed : $currentSeed);
        }

         return response()->json([
            'status'   => 'success',
            'count'    => $count,
            'seed'     => $seed,
            'group'    => $group,
            'dialogue' => $dialogue,
        ]);
    }
}
