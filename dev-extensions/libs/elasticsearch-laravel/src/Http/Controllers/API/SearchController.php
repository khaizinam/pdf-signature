<?php

namespace Dev\ElasticsearchLaravel\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

use Basemkhirat\Elasticsearch\Facades\ES;

use Dev\Base\Facades\BaseHelper;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\ElasticsearchLaravel\Repositories\Interfaces\PostInterface;

class SearchController extends Controller
{
    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|JsonResponse
     */
    public function search(Request $request, BaseHttpResponse $response, PostInterface $postRepository)
    {
        try {
            $posts = $validator = $postRepository->getSearch($request);
            dd($posts);

            return $response
                ->setData($posts)
                ->toApiResponse();
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
