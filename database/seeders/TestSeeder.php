<?php

namespace Database\Seeders;

use App\Lib\Http\Request as CustomRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pentacam_form = [
            "name" => "pentacam form",
            "rows" =>
                [
                    [
                        "cols" => [
                            [
                                "child" =>[
                                    [
                                        "type" => "file",
                                        "element" => "input",
                                        "required" => false,
                                        "fieldSetting" => [
                                            "key" => 'ELE',
                                            "label" => "ELE_BFS_8mm .csv"
                                        ]
                                    ]
                                ],
                                "name" => "",
                            ],
                        ],
                    ],
                    [
                        "cols" => [
                            [
                                "child" =>[
                                    [
                                        "type" => "file",
                                        "element" => "input",
                                        "required" => false,
                                        "fieldSetting" => [
                                            "key" => 'CUR',
                                            "label" => "CUR .csv"
                                        ]
                                    ]
                                ],
                                "name" => "",
                            ],
                        ],
                    ],
                    [
                        "cols" => [
                            [
                                "child" =>[
                                    [
                                        "type" => "file",
                                        "element" => "input",
                                        "required" => false,
                                        "fieldSetting" => [
                                            "key" => 'PAC',
                                            "label" => "PAC .csv"
                                        ]
                                    ]
                                ],
                                "name" => "",
                            ],
                        ],
                    ],
                    [
                        "cols" => [
                            [
                                "child" =>[
                                    [
                                        "type" => "file",
                                        "element" => "input",
                                        "required" => false,
                                        "fieldSetting" => [
                                            "key" => 'SUMMARY',
                                            "label" => "SUMMARY .csv"
                                        ]
                                    ]
                                ],
                                "name" => "",
                            ],
                        ],
                    ],
                    [
                        "cols" => [
                            [
                                "child" =>[
                                    [
                                        "type" => "file",
                                        "element" => "input",
                                        "required" => false,
                                        "fieldSetting" => [
                                            "key" => 'INDEX',
                                            "label" => "INDEX .csv"
                                        ]
                                    ]
                                ],
                                "name" => "",
                            ],
                        ],
                    ],
                    [
                        "cols" => [
                            [
                                "child" =>[
                                    [
                                        "type" => "file",
                                        "element" => "input",
                                        "required" => false,
                                        "fieldSetting" => [
                                            "key" => 'CHAMBER',
                                            "label" => "CHAMBER .csv"
                                        ]
                                    ]
                                ],
                                "name" => "",
                            ],
                        ],
                    ],
                    [
                        "cols" => [
                            [
                                "child" =>[
                                    [
                                        "type" => "file",
                                        "element" => "input",
                                        "required" => false,
                                        "fieldSetting" => [
                                            "key" => 'PACHY',
                                            "label" => "PACHY .csv"
                                        ]
                                    ]
                                ],
                                "name" => "",
                            ],
                        ],
                    ],
                    [
                        "cols" => [
                            [
                                "child" =>[
                                    [
                                        "type" => "file",
                                        "element" => "input",
                                        "required" => false,
                                        "fieldSetting" => [
                                            "key" => '_4MAPS_REF',
                                            "label" => "4MAPS_REF .jpg"
                                        ]
                                    ]
                                ],
                                "name" => "",
                            ],
                        ],
                    ],
                    [
                        "cols" => [
                            [
                                "child" =>[
                                    [
                                        "type" => "multi_file",
                                        "element" => "input",
                                        "required" => false,
                                        "fieldSetting" => [
                                            "key" => 'OTHER_FILES',
                                            "label" => "other files"
                                        ]
                                    ]
                                ],
                                "name" => "",
                            ],
                        ],
                    ],
                ]
        ];

        $form = CustomRequest::post([
            'user-collection' => 'public',
            'section_id' => 11,
        ],$pentacam_form,'form_builder','/forms');

        $form_id = json_decode($form->body())->data->id;
    }
}
