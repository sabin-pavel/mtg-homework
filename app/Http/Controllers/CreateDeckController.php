<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller;

class CreateDeckController extends Controller
{
    private array $rules = [
        'name'        => 'required|string|unique:decks,name',
        'description' => 'string',
    ];

    /**
     * @throws ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $this->validate($request, $this->rules);

        Log::debug(__METHOD__, $request->toArray());

        /** @var Deck $action */
        $deck = Deck::create($request->toArray());

        return new JsonResponse($deck->toArray());
    }
}
