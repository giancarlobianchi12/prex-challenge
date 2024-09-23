<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteStoreRequest;
use App\Repositories\Favorite\FavoriteRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    protected $favoriteRepository;

    public function __construct(
        FavoriteRepositoryInterface $favoriteRepository
    ) {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function store(FavoriteStoreRequest $request)
    {
        $favorite = $this->favoriteRepository->create([
            ...$request->validated(),
            'user_id' => Auth::user()->id,
        ]);

        return response()->json(new JsonResource($favorite), Response::HTTP_CREATED);
    }
}
