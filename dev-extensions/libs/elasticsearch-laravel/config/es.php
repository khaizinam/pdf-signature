<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

$esPrefix = strtolower(Str::slug(env('APP_NAME', 'pkhl'), '_'));

return [
    /*
     * |--------------------------------------------------------------------------
     * | Default Elasticsearch Connection Name
     * |--------------------------------------------------------------------------
     * |
     * | Here you may specify which of the Elasticsearch connections below you wish
     * | to use as your default connection for all work. Of course.
     * | @see
     * | https://github.com/basemkhirat/elasticsearch
     * | https://viblo.asia/p/phan-4-elasticsearch-search-in-depth-aWj53V3el6m
     * | https://viblo.asia/p/query-dsl-trong-elasticsearch-Eb85oJq2l2G
     * |
     */

    'default' => env('ELASTIC_CONNECTION', 'default'),

    /*
      |--------------------------------------------------------------------------
      | Elasticsearch Connections
      |--------------------------------------------------------------------------
      |
      | Here are each of the Elasticsearch connections setup for your application.
      | Of course, examples of configuring each Elasticsearch platform.
      |
      */

    'connections' => [
        'default' => [
            'servers' => [
                [
                    "host" => env("ELASTIC_HOST", "127.0.0.1"),
                    "port" => env("ELASTIC_PORT", 9200),
                    'user' => env('ELASTIC_USER', ''),
                    'pass' => env('ELASTIC_PASS', ''),
                    'scheme' => env('ELASTIC_SCHEME', 'http')
                ]
            ],
            'index' => strtolower(env('ELASTIC_INDEX', 'my_index')),

            // Elasticsearch handlers
            // 'handler' => new MyCustomHandler(),

            //            'logging' => [
            //                'enabled' => env('ELASTIC_LOGGING_ENABLED', true),
            //                'level' => env('ELASTIC_LOGGING_LEVEL', 'all'),
            //                'location' => env('ELASTIC_LOGGING_LOCATION', base_path('storage/logs/elasticsearch.log'))
            //            ],
        ]
    ],

    /*
      |--------------------------------------------------------------------------
      | Elasticsearch Indices
      |--------------------------------------------------------------------------
      |
      | Here you can define your indices, with separate settings and mappings.
      | Edit settings and mappings and run 'php artisan es:index:update' to update
      | indices on elasticsearch server.
      |
      | 'my_index' is just for test. Replace it with a real index name.
      |
      */

    'indices' => [
        // "{$esPrefix}_product" => [
        //     "aliases" => [
        //         "{$esPrefix}_product_alias"
        //     ],
        //     "settings" => [
        //         'number_of_shards' => 1,
        //         'number_of_replicas' => 0,
        //         "index.mapping.ignore_malformed" => false,
        //         "analysis" => [
        //             "filter" => [
        //                 "english_stop" => [
        //                     "type" => "stop",
        //                     "stopwords" => "_english_"
        //                 ],
        //                 "english_keywords" => [
        //                     "type" => "keyword_marker",
        //                     "keywords" => ["example"]
        //                 ],
        //                 "english_stemmer" => [
        //                     "type" => "stemmer",
        //                     "language" => "english"
        //                 ],
        //                 "english_possessive_stemmer" => [
        //                     "type" => "stemmer",
        //                     "language" => "possessive_english"
        //                 ]
        //             ],
        //             "analyzer" => [
        //                 "rebuilt_english" => [
        //                     "tokenizer" => "standard",
        //                     "filter" => [
        //                         "english_possessive_stemmer",
        //                         "lowercase",
        //                         "english_stop",
        //                         "english_keywords",
        //                         "english_stemmer"
        //                     ]
        //                 ]
        //             ]
        //         ]
        //     ],
        //     "mappings" => [
        //         "_doc" => [
        //             "properties" => [
        //                 "name" => [
        //                     "type" => "text",
        //                 ],
        //                 "product_code" => [
        //                     "type" => "text",
        //                 ],
        //                 "product_code2" => [
        //                     "type" => "text",
        //                 ],
        //                 "unit" => [
        //                     "type" => "text",
        //                 ],
        //                 "unit2" => [
        //                     "type" => "text",
        //                 ],
        //                 "description" => [
        //                     "type" => "text",
        //                 ],

        //                 "created_at" => [
        //                     "type" => "date"
        //                 ],
        //                 "updated_at" => [
        //                     "type" => "date"
        //                 ]
        //             ]
        //         ]
        //     ],
        //     'makeindex' => [
        //         'models' => [
        //             'Dev\\Product\\Models\\Product' => [
        //                 'id',
        //                 'name',
        //                 'product_code',
        //                 'product_code2',
        //                 'unit',
        //                 'unit2',
        //                 'description',
        //                 'closing_stock',
        //                 'opening_stock',
        //                 'import_price',
        //                 'price',
        //                 'discount_rate',
        //                 'discount_amount',
        //                 'discount_amount_convert',
        //                 'tax_rate',
        //                 'tax_amount',
        //                 'tax_amount_convert',
        //                 'ordering',
        //                 'usage',
        //                 'barcode',
        //                 'product_category_id',
        //                 'test_category_id',
        //                 'warehouse_id',
        //                 'department_id',
        //                 'productCategory' => [
        //                     'id',
        //                     'category_code',
        //                     'name',
        //                     'description',
        //                 ],
        //                 'testCategory' => [
        //                     'id',
        //                     'test_code', // varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'MaNhom',
        //                     'name', // varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'TenNhom',
        //                     'description', // varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ghichu',
        //                     'product_category_id', // bigint(20) unsigned NOT NULL,
        //                     'product_category_code', // move từ mssql, để test, có thể xoá sau khi dùng product_category_id ổn định
        //                     'status'
        //                 ],
        //                 'department' => [
        //                     'id',
        //                     'department_code',
        //                     'name',
        //                     'product_category_id',
        //                     'status',
        //                 ],
        //                 'warehouse' => [
        //                     'id',
        //                     'warehouse_code',
        //                     'warehouse_name',
        //                     'address',
        //                 ],
        //                 'status',
        //                 'created_at',
        //                 'updated_at'
        //             ]
        //         ]
        //     ]
        // ],

        // "{$esPrefix}_patient" => [ // indices last element phải đặt giống model name
        //     "aliases" => [
        //         "{$esPrefix}_patient_alias"
        //     ],
        //     "settings" => [
        //         'number_of_shards' => 1,
        //         'number_of_replicas' => 0,
        //         "index.mapping.ignore_malformed" => false,

        //         "analysis" => [
        //             "filter" => [
        //                 "english_stop" => [
        //                     "type" => "stop",
        //                     "stopwords" => "_english_"
        //                 ],
        //                 "english_keywords" => [
        //                     "type" => "keyword_marker",
        //                     "keywords" => ["example"]
        //                 ],
        //                 "english_stemmer" => [
        //                     "type" => "stemmer",
        //                     "language" => "english"
        //                 ],
        //                 "english_possessive_stemmer" => [
        //                     "type" => "stemmer",
        //                     "language" => "possessive_english"
        //                 ]
        //             ],
        //             "analyzer" => [
        //                 "rebuilt_english" => [
        //                     "tokenizer" => "standard",
        //                     "filter" => [
        //                         "english_possessive_stemmer",
        //                         "lowercase",
        //                         "english_stop",
        //                         "english_keywords",
        //                         "english_stemmer"
        //                     ]
        //                 ]
        //             ]
        //         ]
        //     ],
        //     'mappings' => [
        //         "_doc" => [
        //             "properties" => [
        //                 "patient_code" => [
        //                     "type" => "text",

        //                 ],

        //                 "full_name" => [
        //                     "type" => "text",

        //                 ],

        //                 "gender" => [
        //                     "type" => "integer",
        //                 ],


        //                 "created_at" => [
        //                     "type" => "date",
        //                 ],
        //                 "updated_at" => [
        //                     "type" => "date"
        //                 ]
        //             ]
        //         ]
        //     ],
        //     'makeindex' => [
        //         'models' => [
        //             'Dev\\Patient\\Models\\Patient' => [
        //                 'id',
        //                 'name', // 'HoTenBN, về mặt lưu trữ, name là đủ , không cần phải fullname',
        //                 'first_name', // 'Tên BN, có thể chưa cần sử dụng',
        //                 'last_name', // 'Họ BN, có thể chưa cần sử dụng',
        //                 'patient_code', // 'MaBN, về mặt lưu trữ, code là đủ , không cần phải patient_code',
        //                 'phone1', // 'DienThoai',
        //                 'phone2', // 'DienThoai, có thể chưa cần sử dụng',
        //                 'email', // 'Email',
        //                 'description', // 'Ghi chú ngắn',
        //                 'address1', // 'DiaChi',
        //                 'address2', // 'DiaChi',
        //                 'gender', // 'GioiTinh (giới tính nam là 0 và nữ là 1, hoặc theo cccd quy định với người sinh trong thế kỷ 20, giới tính nam là số 0 và nữ là số 1. Với người sinh ở thế kỷ 21, giới tính nam là 2 và nữ là 3',
        //                 'nationality', // 'Quốc Tịch',
        //                 'ethnicity', // 'DanToc',
        //                 'dob', // 'NgaySinh',
        //                 'dob_year', // 'Năm sinh',
        //                 'occupation', // 'NgheNghiep',
        //                 'workplace', // 'NoiLamViec',
        //                 'barcode', // 'MaVach barcode',
        //                 'insurance_number', // 'SoTheBHYT',
        //                 'insurance_type', // 'DoiTuong',
        //                 'insurance_type_code', // 'Mã Nhóm: I (bắt dầu với DN, HX, CH, NN, TK, HC, XK, CA, TN HD), II (bắt dầu với HT, TH, TB, MS, XB, XN, CC, CB, KC, BT, TC, TQ, TA, TY, HG, NO), III (bắt dầu với HN, CN), IV (bắt dầu với TE), V (bắt dầu với LS, HS), VI (bắt dầu với GD, TL, XV), sử dụng mssql trigger hoặc laravel created/updated event',
        //                 'insurance_code', // 'Mã TheBHYT',
        //                 'insurance_payment_rates', // 'TyLeChiTra',
        //                 'insurance_expired_at', // 'HantheBHYT',
        //                 'insurance_place_of_initial_examination', // 'Nơi khám chữa bệnh lần đầu',
        //                 'age_in_months', // 'ThangTuoi, nếu không muốn sử dụng ngày sinh',
        //                 'weight', // 'CanNang',
        //                 'height', // 'Chiều Cao',
        //                 'author_id', // 'Liên kết truy xuất thông tin người tạo',
        //                 'author_type', // 'Dev\\Member\\Models\\Member',
        //                 'assigned_id', // 'Liên kết truy xuất thông tin người chăm sóc',
        //                 'assigned_type', // 'Dev\\Member\\Models\\Member',
        //                 'province_id', // 'TinhThanhPho',
        //                 'district_id', // 'QuanHuyen',
        //                 'ward_id', // 'XaPhuongThiTran',
        //                 'additional_data', // 'Sử dụng lưu các dữ liệu mở rộng (key/value) mà không cần tạo cột sau này nếu có',
        //                 'status', // 'published'
        //                 'province' => [
        //                     'matp',
        //                     'name',
        //                     'type',
        //                 ],
        //                 'district' => [
        //                     'maqh',
        //                     'name',
        //                     'type',
        //                     'matp'
        //                 ],
        //                 'ward' => [
        //                     'xaid',
        //                     'name',
        //                     'type',
        //                     'maqh'
        //                 ],
        //                 'created_at',
        //                 'updated_at',
        //             ]
        //         ]
        //     ]
        // ],

        // "{$esPrefix}_examination" => [ // indices last element phải đặt giống model name
        //     "aliases" => [
        //         "{$esPrefix}_examination_alias"
        //     ],
        //     "settings" => [
        //         'number_of_shards' => 1,
        //         'number_of_replicas' => 0,
        //         "index.mapping.ignore_malformed" => false,

        //         "analysis" => [
        //             "filter" => [
        //                 "english_stop" => [
        //                     "type" => "stop",
        //                     "stopwords" => "_english_"
        //                 ],
        //                 "english_keywords" => [
        //                     "type" => "keyword_marker",
        //                     "keywords" => ["example"]
        //                 ],
        //                 "english_stemmer" => [
        //                     "type" => "stemmer",
        //                     "language" => "english"
        //                 ],
        //                 "english_possessive_stemmer" => [
        //                     "type" => "stemmer",
        //                     "language" => "possessive_english"
        //                 ]
        //             ],
        //             "analyzer" => [
        //                 "rebuilt_english" => [
        //                     "tokenizer" => "standard",
        //                     "filter" => [
        //                         "english_possessive_stemmer",
        //                         "lowercase",
        //                         "english_stop",
        //                         "english_keywords",
        //                         "english_stemmer"
        //                     ]
        //                 ]
        //             ]
        //         ]
        //     ],
        //     'mappings' => [
        //         "_doc" => [
        //             "properties" => [
        //                 "exam_conclusion" => [
        //                     "type" => "text",

        //                 ],

        //                 'queue_order_number' => [
        //                     "type" => "integer"
        //                 ],

        //                 "author_id" => [
        //                     "type" => "integer"
        //                 ],

        //                 "assigned_id" => [
        //                     "type" => "integer"
        //                 ],


        //                 "created_at" => [
        //                     "type" => "date",
        //                 ],
        //                 "updated_at" => [
        //                     "type" => "date"
        //                 ]
        //             ]
        //         ]
        //     ],
        //     'makeindex' => [
        //         'models' => [
        //             'Dev\\Examination\\Models\\Examination' => [
        //                 'id',
        //                 'exam_code',
        //                 'health_type',
        //                 'author_id',  // ID của người lập phiếu
        //                 'author_type',  // Loại của người lập phiếu (đa hình)
        //                 'assigned_id',  // ID của bác sĩ khám
        //                 'assigned_type',  // Loại của bác sĩ khám (đa hình)
        //                 'patient_id',  // ID của bệnh nhân
        //                 'product_id',
        //                 'examination_room_id',  // ID của phòng khám
        //                 'exam_fee',  // Phí khám
        //                 'exam_type',  // Loại khám
        //                 'exam_payment_status',  // Trạng thái thanh toán
        //                 'exam_form_type',  // Hình thức khám
        //                 'description',  // Ghi chú hoặc lý do khám
        //                 'exam_conclusion',  // Kết luận khám
        //                 'blood_pressure',  // Huyết áp
        //                 'pulse',  // Mạch đập
        //                 'temperature',  // Nhiệt độ
        //                 'follow_up_scheduled',  // Đặt lịch tái khám
        //                 'breathing_rate',  // Tần suất thở
        //                 'weight',  // Cân nặng
        //                 'height',  // Chiều cao
        //                 'queue_order_number',  // Số thứ tự
        //                 'reason',  // Lý do khám
        //                 'pre_medical_history',  // Tiền sử bệnh
        //                 'medical_history',  // Lịch sử bệnh
        //                 'exam_diagnostics',  // Chẩn đoán chính
        //                 'exam_diagnostics2',  // Chẩn đoán phụ 1
        //                 'exam_diagnostics3',  // Chẩn đoán phụ 2
        //                 'status',  // Trạng thái
        //                 'created_at',  // Ngày tạo
        //                 'updated_at',  // Ngày cập nhật

        //                 // Thông tin liên kết với model bệnh nhân (Patient)
        //                 'patient' => [
        //                     'id',  // ID bệnh nhân
        //                     'patient_code',  // Mã bệnh nhân
        //                     'name',  // Tên đầy đủ
        //                     'address1',  // Địa chỉ
        //                     'phone1',  // Địa chỉ
        //                     'gender',  // Địa chỉ
        //                     'dob_year',  // Địa chỉ
        //                 ],

        //                 'product' => [
        //                     'id',  // ID bệnh nhân
        //                     'name',  // Mã bệnh nhân
        //                     'price',  // Tên đầy đủ
        //                 ],


        //                 // Thông tin liên kết với model phòng khám (Department)
        //                 'examinationRoom' => [
        //                     'id',  // ID phòng khám
        //                     'department_code',  // Mã phòng khám
        //                     'name',  // Tên phòng khám
        //                 ],

        //                 // Thông tin liên kết với model bác sĩ/nhân viên (Member)
        //                 'author' => [
        //                     'id',  // ID của người lập phiếu
        //                     'first_name',
        //                     'last_name',  // Tên đầy đủ của bác sĩ khám
        //                 ],

        //                 'assigned' => [
        //                     'id',  // ID của bác sĩ khám
        //                     'first_name',
        //                     'last_name',  // Tên đầy đủ của bác sĩ khám
        //                 ],
        //             ]
        //         ]
        //     ]

        // ],

        "{$esPrefix}_patientappointment" => [
            "aliases" => [
                "{$esPrefix}_patientappointment_alias"
            ],
            "settings" => [
                'number_of_shards' => 1,
                'number_of_replicas' => 0,
                "index.mapping.ignore_malformed" => false,

                "analysis" => [
                    "filter" => [
                        "english_stop" => [
                            "type" => "stop",
                            "stopwords" => "_english_"
                        ],
                        "english_keywords" => [
                            "type" => "keyword_marker",
                            "keywords" => ["example"]
                        ],
                        "english_stemmer" => [
                            "type" => "stemmer",
                            "language" => "english"
                        ],
                        "english_possessive_stemmer" => [
                            "type" => "stemmer",
                            "language" => "possessive_english"
                        ]
                    ],
                    "analyzer" => [
                        "rebuilt_english" => [
                            "tokenizer" => "standard",
                            "filter" => [
                                "english_possessive_stemmer",
                                "lowercase",
                                "english_stop",
                                "english_keywords",
                                "english_stemmer"
                            ]
                        ]
                    ]
                ]
            ],
            'mappings' => [
                "_doc" => [
                    "properties" => [
                        "patient_code" => [
                            "type" => "text",
                        ],
                        "department_id" => [
                            "type" => "integer"
                        ],
                        "author_id" => [
                            "type" => "integer"
                        ],
                        "assigned_id" => [
                            "type" => "integer"
                        ],
                        "date_appointment" => [
                            "type" => "date"
                        ],
                        "queue_order_number" => [
                            "type" => "integer"
                        ],
                        "status" => [
                            "type" => "text"
                        ],
                        "created_at" => [
                            "type" => "date"
                        ],
                        "updated_at" => [
                            "type" => "date"
                        ]
                    ]
                ]
            ],
            'makeindex' => [
                'models' => [
                    'Dev\\Examination\\Models\\PatientAppointment' => [
                        'id',
                        'patient_code',  // Mã bệnh nhân
                        'department_id',  // Phòng khám
                        'author_id',  // ID người lập
                        'assigned_id',  // ID người khám
                        'date_appointment',  // Ngày hẹn khám
                        'queue_order_number',  // Số thứ tự
                        'status',  // Trạng thái
                        'created_at',  // Ngày tạo
                        'updated_at',  // Ngày cập nhật

                        // Liên kết với model bệnh nhân
                        'patient' => [
                            'id',
                            'patient_code',
                            'name',
                            'address1',
                            'phone1',
                            'gender',
                            'dob_year'
                        ],

                        // Liên kết với phòng khám
                        'department' => [
                            'id',
                            'department_code',
                            'name'
                        ],

                        // Liên kết với người lập phiếu
                        'author' => [
                            'id',
                            'first_name',
                            'last_name'
                        ],

                        // Liên kết với người khám
                        'assigned' => [
                            'id',
                            'first_name',
                            'last_name'
                        ]
                    ]
                ]
            ]
        ],



    ],

];
