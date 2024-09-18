<?php

namespace App\Http\Controllers;

use App\Http\Requests\GifSearchRequest;
use App\Services\GiphyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class GifController extends Controller
{
    protected $giphyService;

    public function __construct(GiphyService $giphyService)
    {
        $this->giphyService = $giphyService;
    }

    public function search(GifSearchRequest $request)
    {
        $gifs = $this->giphyService->searchGifs(
            $request->input('query'),
            $request->input('limit'),
            $request->input('offset')
        );

        return JsonResource::collection($gifs);
    }

    public function show($id)
    {
        $gif = $this->giphyService->getGifById($id);

        return response()->json(new JsonResource($gif), JsonResponse::HTTP_OK);
    }
}
