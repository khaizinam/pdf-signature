# ImgOptimize

```bash
composer require dev-extensions\elasticsearch-laravel
```

## Installation & Basic Usage


### Usage

You should now be able to use the provider like you would regularly use Socialite (assuming you have the facade installed):

1) Facade: Support to indexing a single record only
    - app('es-makeindex')->initialize()->bulk($objects);
    - app('es-makeindex')->initialize()->setEntity($object)->setBody()->execute();
    
    - hoặc EsMakeIndexFacade::initialize()->bulk($objects);

2) Traits: đã bỏ; 

3) Using Queue: cần sử dụng để tăng tốc, việc indexing sẽ được xử lý bởi redis và chạy background
    /***
        * Support to indexing a single record or multiple records
        * Can be use like : 
        * - With queue : EsMakeindexJob::dispatch($entities, $models);
        */
    EsMakeindexJob::dispatch($entities, $models);

    /***
        * Support to indexing a single record only
        * Can be use like : 
        * - With queue : EsMakeindexJob::dispatch($entityObj);
        */
    EsMakeindexSingleJob::dispatch($entityObj);

3) Other example
    - ES::type('JmsJob')->id(intval($request->id)->delete());
    - $query = ES::type('JmsJob')->where('state', 1);
    - ES::type('JmsJob')->where('user.id', $user->id);
    - ES::type('JmsJob')->where('user.id', $user->id);
    - $countJobs = \Basemkhirat\Elasticsearch\Facades\ES::type('JmsJob')->where('state', 1)->get()->total;
    -         $jobs = \ES::type('JmsJob')->where('state', 1)
            ->where('categories.id', intval($category->id))
            ->paginate(15);
    -        $results = ES::type('JmsCompany')->where('featured', 1)
            ->where('state', 1)
            ->orderBy('_score')
            ->paginate($limit);
    -     {
        // \App\Models\Eloquents\JmsUser::where('id', '>', 0)->update([
        // 'password' => Hash::make('Abc@1234'),
        // ]);
        // # begin validation
        // return \Illuminate\Validation\ValidationException::withMessages([
        // 'message' => $th->getMessage()
        // ]);
        $limit = $request->limit ?? $limit ?: 15;

        try {
            $query = ES::type('JmsJob')->where('state', 1);

            // # searching with keywords
            if ($request->keyword) {
                $query->search($request->keyword);
            }

            if ($job->name) {
                $query->search($job->name);
            }

            $results = $query->orderBy("created_at", "DESC")
                ->orderBy('_score')
                ->paginate($limit);

            if ($results && $results->total()) {
                return $results;
            }
        } catch (\Throwable $th) {
            return \Illuminate\Validation\ValidationException::withMessages([
                'message' => $th->getMessage()
            ]);
        }

        return \Illuminate\Validation\ValidationException::withMessages([
            'message' => "We're sorry. We can not find any matches for your search term."
        ]);
    }

    -                 $query = ES::type('JmsUser');
                if ($request->keyword and is_numeric($request->keyword)) {
                    $body["query"]["bool"]["must"][] = [
                        "multi_match" => [
                            "query" => $request->keyword,
                            "fields" => [
                                "id",
                                "phone",
                                "mobile"
                            ],
                            "boost" => 1
                        ]
                    ];
                } elseif ($request->keyword and valid_email($request->keyword)) {
                    $body["query"]["bool"]["must"][] = [
                        "multi_match" => [
                            "query" => $request->keyword,
                            "fields" => [
                                "email"
                            ],
                            "boost" => 1
                        ]
                    ];
                } else {
                    if ($request->keyword) {
                        $body["query"]["bool"]["must"][] = [
                            "multi_match" => [
                                "query" => $request->keyword,
                                "fields" => [
                                    "email",
                                    "phone",
                                    "mobile",
                                    "fullname",
                                    "first_name",
                                    "last_name",
                                    "address"
                                ],
                                "boost" => 1
                            ]
                        ];
                    }
                }
                if ($request->city && is_numeric($request->city)) {
                    $body["query"]["bool"]["must"][] = [
                        "term" => [
                            "city.id" => intval($request->city)
                        ]
                    ];
                }
                if ($request->category && is_numeric($request->category)) {
                    $body["query"]["bool"]["must"][] = [
                        "term" => [
                            "categories.id" => intval($request->category)
                        ]
                    ];
                }
                if (!empty($body)) {
                    $query->body($body);
                }
                $datas = $query->paginate($limit);