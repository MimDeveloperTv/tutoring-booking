<?php

namespace Database\Seeders;

use App\Lib\Http\Request as CustomRequest;
use App\Models\ServiceCategory;
use App\Models\ServiceModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $surgeryCategory = ServiceCategory::create([
            'type' => 'PRESCRIPTION',
            'name' => 'جراحی'
        ]);
        $corneaSurgeryCategory = ServiceCategory::create([
            'type' => 'PRESCRIPTION',
            'parent_id' => $surgeryCategory->id,
            'name' => 'Cornea Surgery',
        ]);
        ServiceModel::create([
            'service_category_id' => $corneaSurgeryCategory->id,
            'name' => 'Cataract Surgery',
            'items' => 'od,os',
            'created_by' => 'SYSTEM'
        ]);
        ServiceModel::create([
            'service_category_id' => $corneaSurgeryCategory->id,
            'name' => 'Pupilloplasty',
            'items' => 'od,os',
            'created_by' => 'SYSTEM'
        ]);
        ServiceModel::create([
            'service_category_id' => $corneaSurgeryCategory->id,
            'name' => 'Pterygium',
            'items' => 'od,os',
            'created_by' => 'SYSTEM'
        ]);
        $refractiveSurgeryCategory = ServiceCategory::create([
            'type' => 'PRESCRIPTION',
            'parent_id' => $corneaSurgeryCategory->id,
            'name' => 'Refractive Surgery',
        ]);
        ServiceModel::create([
            'service_category_id' => $refractiveSurgeryCategory->id,
            'name' => 'PRK',
            'condition' => 'refractive_prk',
            'calculation' => 'pek',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        ServiceModel::create([
            'service_category_id' => $refractiveSurgeryCategory->id,
            'name' => 'TRANS-PRK',
            'condition' => 'refractive_transprk',
            'calculation' => 'trans_prk',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        ServiceModel::create([
            'service_category_id' => $refractiveSurgeryCategory->id,
            'name' => 'Lasik',
            'condition' => 'refractive_lasik',
            'calculation' => 'lasik',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        ServiceModel::create([
            'service_category_id' => $refractiveSurgeryCategory->id,
            'name' => 'FemtoLasik',
            'condition' => 'refractive_femtolasik',
            'calculation' => 'femtolasik',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        ServiceModel::create([
            'service_category_id' => $refractiveSurgeryCategory->id,
            'name' => 'Smile',
            'condition' => 'refractive_smile',
            'calculation' => 'smile',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        ServiceModel::create([
            'service_category_id' => $refractiveSurgeryCategory->id,
            'name' => 'RLE',
            'condition' => 'refractive_rle',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        ServiceModel::create([
            'service_category_id' => $refractiveSurgeryCategory->id,
            'name' => 'PIOL',
            'condition' => 'refractive_piol',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        ServiceModel::create([
            'service_category_id' => $refractiveSurgeryCategory->id,
            'name' => 'Multifocal-Toric IOL',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        $kcnSurgeryCategory = ServiceCategory::create([
            'type' => 'PRESCRIPTION',
            'parent_id' => $corneaSurgeryCategory->id,
            'name' => 'KCN Surgery',
        ]);
        $cxlCategory = ServiceCategory::create([
            'parent_id' => $kcnSurgeryCategory->id,
            'name' => 'Cxl',
        ]);
        ServiceModel::create([
            'service_category_id' => $cxlCategory->id,
            'name' => 'Standard',
            'condition' => 'kcn_cxl',
            'calculation' => 'cxl',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        ServiceModel::create([
            'service_category_id' => $cxlCategory->id,
            'name' => 'Hypotonic',
            'condition' => 'kcn_cxl',
            'calculation' => 'cxl',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        ServiceModel::create([
            'service_category_id' => $cxlCategory->id,
            'name' => 'Accelerates',
            'condition' => 'kcn_cxl',
            'calculation' => 'cxl',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        $ringCategory = ServiceCategory::create([
            'type' => 'PRESCRIPTION',
            'parent_id' => $kcnSurgeryCategory->id,
            'name' => 'Ring',
        ]);
        ServiceModel::create([
            'service_category_id' => $ringCategory->id,
            'name' => 'Intacts',
            'condition' => 'kcn_ring_intacs',
            'calculation' => 'kcn_ring_intacs',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        ServiceModel::create([
            'service_category_id' => $ringCategory->id,
            'name' => 'Intacts-SK',
            'condition' => 'kcn_ring_intacsSK',
            'calculation' => 'kcn_ring_intacs_sk',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        ServiceModel::create([
            'service_category_id' => $ringCategory->id,
            'name' => 'Keraring',
            'condition' => 'kcn_ring_keraring',
            'calculation' => 'kcn_ring_keraring',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        ServiceModel::create([
            'service_category_id' => $ringCategory->id,
            'name' => 'Feraring',
            'condition' => 'kcn_ring_ferrara',
            'calculation' => 'kcn_ring_feraring',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        ServiceModel::create([
            'service_category_id' => $ringCategory->id,
            'name' => 'Myoring',
            'condition' => 'kcn_ring_Myoring',
            'calculation' => 'kcn_ring_myoring',
            'created_by' => 'SYSTEM',
            'items' => 'od,os',
        ]);
        $keratoplastyCategory = ServiceCategory::create([
            'type' => 'PRESCRIPTION',
            'parent_id' => $kcnSurgeryCategory->id,
            'name' => 'Keratoplasty',
        ]);
        ServiceModel::create([
            'service_category_id' => $keratoplastyCategory->id,
            'name' => 'PK',
            'items' => 'od,os',
            'created_by' => 'SYSTEM',
        ]);
        ServiceModel::create([
            'service_category_id' => $keratoplastyCategory->id,
            'name' => 'Anterior',
            'items' => 'od,os',
            'created_by' => 'SYSTEM',
        ]);
        ServiceModel::create([
            'service_category_id' => $keratoplastyCategory->id,
            'name' => 'Posterior',
            'items' => 'od,os',
            'created_by' => 'SYSTEM',
        ]);
        ServiceModel::create([
            'service_category_id' => $keratoplastyCategory->id,
            'name' => 'Large-Graft',
            'items' => 'od,os',
            'created_by' => 'SYSTEM'
        ]);
        ServiceCategory::create([
            'type' => 'PRESCRIPTION',
            'parent_id' => $surgeryCategory->id,
            'name' => 'Eyelid and Plastic Surgery',
        ]);
        ServiceCategory::create([
            'type' => 'PRESCRIPTION',
            'parent_id' => $surgeryCategory->id,
            'name' => 'Glaucoma Surgery',
        ]);
        ServiceCategory::create([
            'type' => 'PRESCRIPTION',
            'parent_id' => $surgeryCategory->id,
            'name' => 'Retina Surgery',
        ]);
        $examinationCategory = ServiceCategory::create([
            'type' => 'PRESCRIPTION',
            'name' => 'معاینه'
        ]);
       $examination = ServiceModel::create([
            'service_category_id' => $examinationCategory->id,
            'name' => 'معاینه عمومی چشم',
            'non_prescription' => 1,
            'created_by' => 'SYSTEM'
        ]);
        $optometry = ServiceModel::create([
            'service_category_id' => $examinationCategory->id,
            'name' => 'اپتومتری',
            'non_prescription' => 1,
            'created_by' => 'SYSTEM'
        ]);
        $imagingCategory = ServiceCategory::create([
            'type' => 'PRESCRIPTION',
            'name' => 'تصویربرداری'
        ]);
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


 /* disable  form_builder Service Seeder */

//        $form = CustomRequest::post([
//            'user-collection' => 'public',
//            'section_id' => 11,
//        ],$pentacam_form,'form_builder','/forms');
//        $form_id = json_decode($form->body())->data->id;
//
//        ServiceModel::create([
//            'service_category_id' => $imagingCategory->id,
//            'name' => 'pentacam',
//            'items' => 'od,os',
//            'form_id' => $form_id,
//            'created_by' => 'SYSTEM'
//        ]);
//
//
//        ServiceModel::create([
//            'service_category_id' => $imagingCategory->id,
//            'name' => 'eyesys',
//            'items' => 'od,os',
//            'created_by' => 'SYSTEM'
//        ]);



        foreach (ServiceModel::all() as $serviceModel){
            if($serviceModel->id != $examination->id && $serviceModel->id != $optometry->id){
                $serviceModel->serviceModelItems()->create([
                    'label' => 'od'
                ]);
                $serviceModel->serviceModelItems()->create([
                    'label' => 'os'
                ]);
            }else{
                $serviceModel->serviceModelItems()->create([
                    'label' => ' '
                ]);
            }
        }


//         Service::create([
//            'service_model_id' => 1,
//            'user_collection_id' => 1,
//            'form_id' => 36,
//            'default_price' => 460000,
//            'default_duration' => 20,
//            'default_break' => 3,
//            'default_capacity' => 2
//         ]);
//
//         Service::create([
//            'service_model_id' => 2,
//            'user_collection_id' => 1,
//            'form_id' => 21,
//            'default_price' => 55000,
//            'default_duration' => 15,
//            'default_break' => 1,
//            'default_capacity' => 3
//         ]);
//
//         Service::create([
//            'service_model_id' => 3,
//            'user_collection_id' => 1,
//            'form_id' => 25,
//            'default_price' => 120000,
//            'default_duration' => 10,
//            'default_break' => 2,
//            'default_capacity' => 1
//         ]);
//
//         Service::create([
//            'service_model_id' => 4,
//            'user_collection_id' => 1,
//            'form_id' => 20,
//            'default_price' => 3000000,
//            'default_duration' => 50,
//            'default_break' => 10,
//            'default_capacity' => 1
//         ]);
    }
}
