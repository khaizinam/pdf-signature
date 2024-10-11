<?php

use Dev\AdvancedRole\Models\Role;
use Dev\AdvancedRole\Models\Member;
use Dev\AdvancedRole\Models\Team;
use Dev\AdvancedRole\Models\Permission;
use Dev\AdvancedRole\Models\Scope;
use Dev\Patient\Models\Department;
use Dev\Product\Models\Product;
use Dev\Patient\Models\Patient;
use Dev\Examination\Models\Examination;
use Dev\Examination\Models\PatientAppointment;

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true,


    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    "configs" => [
        [
            "prefix" => "member",
            "entity" => Member::class,
            'name_entity' => 'Member',
            "action" => [
                "list" => [
                    "display_name" => "Xem danh sách người dùng",
                    "alias" => ["index", "view"]
                ],
                "create" => [
                    "display_name" => "Tạo người dùng",
                    "alias" => ["store", "save"]
                ],
                "update" => [
                    "display_name" => "Cập nhật thông tin người dùng",
                    "alias" => ["edit", "update"]
                ],
                "destroy" => [
                    "display_name" => "Xóa người dùng",
                    "alias" => ["remove", "restore", "force_delete"]
                ],
            ],
        ],
        [
            "prefix" => "role",
            "entity" => Role::class,
            'name_entity' => 'Role',
            "action" => [
                "list" => [
                    "display_name" => "Xem danh sách vai trò",
                    "alias" => ["index", "view"]
                ],
                "create" => [
                    "display_name" => "Thêm vai trò",
                    "alias" => ["store", "save"]
                ],
                "update" => [
                    "display_name" => "Cập nhật thông tin vai trò",
                    "alias" => ["edit", "update"]
                ],
                "destroy" => [
                    "display_name" => "Xóa vai trò",
                    "alias" => ["remove", "restore", "force_delete"]
                ],
            ],
        ],
        [
            "prefix" => "permission",
            "entity" => Permission::class,
            'name_entity' => 'Permission',
            "action" => [
                "list" => [
                    "display_name" => "Xem thông tin quyền hạn (permission)",
                    "alias" => ["index", "view"]
                ],
                "create" => [
                    "display_name" => "Thêm quyền hạn (permission)",
                    "alias" => ["store", "save"]
                ],
                "update" => [
                    "display_name" => "Cập nhật thông tin quyền hạn (permission)",
                    "alias" => ["edit", "update"]
                ],
                "destroy" => [
                    "display_name" => "Xóa quyền hạn (permission)",
                    "alias" => ["remove", "restore", "force_delete"]
                ],
            ]
        ],
        [
            "prefix" => "scope",
            "entity" => Scope::class,
            'name_entity' => 'Scope',
            "action" => [
                "list" => [
                    "display_name" => "Xem thông tin phạm vi quyền (scope)",
                    "alias" => ["index", "view"]
                ],
                "create" => [
                    "display_name" => "Thêm phạm vi quyền (scope)",
                    "alias" => ["store", "save"]
                ],
                "update" => [
                    "display_name" => "Cập nhật thông tin phạm vi quyền (scope)",
                    "alias" => ["edit", "update"]
                ],
                "destroy" => [
                    "display_name" => "Xóa phạm vi quyền (scope)",
                    "alias" => ["remove", "restore", "force_delete"]
                ],
            ]
        ],
        [
            "prefix" => "department",
            "entity" => Department::class,
            'name_entity' => 'Department',
            "action" => [
                "list" => [
                    "display_name" => "Xem thông tin phòng ban",
                    "alias" => ["index", "view"]
                ],
                "create" => [
                    "display_name" => "Thêm phòng ban",
                    "alias" => ["store", "save"]
                ],
                "update" => [
                    "display_name" => "Cập nhật thông tin phòng ban",
                    "alias" => ["edit", "update"]
                ],
                "destroy" => [
                    "display_name" => "Xóa phòng ban",
                    "alias" => ["remove", "restore", "force_delete"]
                ],
            ]
        ],
        [
            "prefix" => "team",
            "entity" => Team::class,
            'name_entity' => 'Team',
            "action" => [
                "list" => [
                    "display_name" => "Xem thông tin team",
                    "alias" => ["index", "view"]
                ],
                "create" => [
                    "display_name" => "Thêm team",
                    "alias" => ["store", "save"]
                ],
                "update" => [
                    "display_name" => "Cập nhật thông tin team",
                    "alias" => ["edit", "update"]
                ],
                "destroy" => [
                    "display_name" => "Xóa team",
                    "alias" => ["remove", "restore", "force_delete"]
                ],
            ]
        ],
        [
            "prefix" => "product",
            "entity" => Product::class,
            'name_entity' => 'Product',
            "action" => [
                "list" => [
                    "display_name" => "Xem thông tin sản phẩm",
                    "alias" => ["index", "view"]
                ],
                "create" => [
                    "display_name" => "Thêm sản phẩm",
                    "alias" => ["store", "save"]
                ],
                "update" => [
                    "display_name" => "Cập nhật thông tin sản phẩm",
                    "alias" => ["edit", "update"]
                ],
                "destroy" => [
                    "display_name" => "Xóa sản phẩm",
                    "alias" => ["remove", "restore", "force_delete"]
                ],
            ]
        ],
        [
            "prefix" => "patient",
            "entity" => Patient::class,
            'name_entity' => 'Patient',
            "action" => [
                "list" => [
                    "display_name" => "Xem thông tin khách hàng",
                    "alias" => ["index", "view"]
                ],
                "create" => [
                    "display_name" => "Thêm khách hàng",
                    "alias" => ["store", "save"]
                ],
                "update" => [
                    "display_name" => "Cập nhật thông tin khách hàng",
                    "alias" => ["edit", "update"]
                ],
                "destroy" => [
                    "display_name" => "Xóa khách hàng",
                    "alias" => ["remove", "restore", "force_delete"]
                ],
            ]
        ],
        [
            "prefix" => "examination",
            "entity" => Examination::class,
            'name_entity' => 'Examination',
            "action" => [
                "list" => [
                    "display_name" => "Xem thông tin phiếu khám",
                    "alias" => ["index", "view"]
                ],
                "create" => [
                    "display_name" => "Thêm phiếu khám",
                    "alias" => ["store", "save"]
                ],
                "update" => [
                    "display_name" => "Cập nhật thông tin phiếu khám",
                    "alias" => ["edit", "update"]
                ],
                "destroy" => [
                    "display_name" => "Xóa phiếu khám",
                    "alias" => ["remove", "restore", "force_delete"]
                ],
            ]
        ],
        [
            "prefix" => "patient-appointment",
            "entity" => PatientAppointment::class,
            'name_entity' => 'PatientAppointment',
            "action" => [
                "list" => [
                    "display_name" => "Xem thông tin phiếu hẹn",
                    "alias" => ["index", "view"]
                ],
                "create" => [
                    "display_name" => "Thêm phiếu hẹn",
                    "alias" => ["store", "save"]
                ],
                "update" => [
                    "display_name" => "Cập nhật thông tin phiếu hẹn",
                    "alias" => ["edit", "update"]
                ],
                "destroy" => [
                    "display_name" => "Xóa phiếu hẹn",
                    "alias" => ["remove", "restore", "force_delete"]
                ],
            ]
        ]
    ]
];
