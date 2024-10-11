<?php

namespace Dev\ElasticsearchLaravel\Repositories\Eloquent;

use Exception;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

use Basemkhirat\Elasticsearch\Facades\ES;

use Dev\Base\Facades\BaseHelper;
use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Supports\Helper;
use Dev\Media\Facades\AppMedia;
use Dev\ElasticsearchLaravel\Repositories\Interfaces\PostInterface;
use Dev\Support\Repositories\Eloquent\RepositoriesAbstract;

class PostRepository extends RepositoriesAbstract implements PostInterface
{
    public function getSearch(?Request $request, int $limit = 10, int $paginate = 10)
    {
        /**
         * Initital paramater and variables
         */
        $query = BaseHelper::stringify($request->input('q'));
        $filtered = $results = $params = [];
        $limit = $request->limit ?? 15;
        $params = [
            "sort" => [],
            "track_scores" => true
        ];

        try {
            // if ($request->order_by) {
            //     list($col, $direction) = explode(" ", $request->order_by, 2);

            //     array_unshift($params["sort"], array(
            //         $col => array(
            //             "order" => $direction,
            //             "missing" => 0,
            //             "unmapped_type" => "string"
            //         )
            //     ));
            // }
            $filtered["bool"]["must"][] = [
                "term" => [
                    "status.value" => "published"
                ]
            ];

            #region search with keywords
            if ($request->q) {
                $filtered["bool"]["must"][]["multi_match"] = [
                    "query" => $request->q,
                    "fields" => [
                        "name",
                        "description"
                    ],
                    "type" => "cross_fields",
                    "operator" => "or"
                ];
            }
            #endregion search with keywords

            #region created_at filter
            if (($request->created_at == "0" || $request->created_at) && is_numeric($request->created_at) && intval($request->created_at) > -1) {
                $timeNow = time();
                if ($request->created_at == "0") {
                    $timeNow -= 3600;
                } else {
                    $timeNow -= 86400 * intval($request->created_at);
                }
                $filtered["bool"]["must"][] = [
                    "range" => [
                        "created_at" => [
                            "gte" => $timeNow
                        ]
                    ]
                ];
            }
            #endregion created_at filter

            #region featured filter
            if ($request->is_featured && is_array($request->is_featured) && count($request->is_featured) > 0) {
                $filtered["bool"]["must"][] = [
                    "terms" => [
                        "is_featured" => $request->is_featured
                    ]
                ];
            }
            #endregion featured filter

            #region category filter: please test w/ two ways
            // if ($request->categories && is_array($request->categories) && count($request->categories) > 0) {
            //     $filtered["bool"]["must"][] = [
            //         "terms" => [
            //             "categories.id" => $request->categories
            //         ]
            //     ];
            // }
            if ($request->categories) {
                $filter = [];
                foreach ($request->categories as $item) {
                    $filter[] = [
                        "term" => [
                            "categories.id" => $item
                        ]
                    ];
                }
                if (count($filter) > 0)
                    $filtered["bool"]["should"][]["bool"]["filter"] = $filter;
            }
            #endregion category filter

            #region periods filter
            if ($request->periods && is_array($request->periods) && count($request->periods) > 0) {
                foreach ($request->periods as $value) {
                    if (is_array($value)) { // [0][1000000,5000000]; [1][50000000,20000000]]
                        $filtered["bool"]["should"][]["bool"]["must"][] = [
                            "range" => [
                                "created_at" => [
                                    "gte" => intval($value[0])
                                ],
                                "created_at" => [
                                    "lte" => intval($value[1])
                                ]
                            ]
                        ];
                    }
                }
            }
            #endregion periods filter

            #region views filter
            if ($request->views && is_array($request->views) && count($request->views) > 0) {
                foreach ($request->views as $value) {
                    if (is_array($value)) { // [0][1,1000]
                        $filtered["bool"]["should"][]["bool"]["must"][] = [
                            "range" => [
                                "views" => [
                                    "gte" => intval($value[0]),
                                    "lte" => intval($value[1]),
                                    "boost" => 2 //
                                ]
                            ]
                        ];
                    }
                }
            }
            #endregion views filter

            array_unshift($params["sort"], "_score");
            if (!empty($filtered)) {
                $params["query"] = $filtered;
            }
            dump(
                'params',
                json_encode($params)
            );
            $query = app('es')->index('pkhl_post')->body($params)->select([
                "id",
                "name",
                "views",
                "author.email",
                "author.avatar",
                "categories.id",
                "categories.name"
            ]); // ->type('_doc')->skip(0)->take(10);

            $results = $query
                ->orderBy("created_at", "desc")
                ->orderBy('_score', 'desc')
                ->paginate($limit);

            return $results;
        } catch (\Throwable $th) {
            dd($th);
            return ValidationException::withMessages([
                'message' => $th->getMessage()
            ]);
        }

        return ValidationException::withMessages([
            'message' => "We're sorry. We can not find any matches for your search term."
        ]);
    }
}
