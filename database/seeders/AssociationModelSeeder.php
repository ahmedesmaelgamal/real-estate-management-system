<?php

namespace Database\Seeders;

use App\Models\AssociationModel;
use Illuminate\Database\Seeder;

class AssociationModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AssociationModel::insert([
            [
                'title' => '{"ar":"إدارة المرافق المتكامله","en":"Integrated Facilities Management"}',
                'description' => '{"ar":"يكون هنا مزود الخدمة قادراً على تقديم غالبية الخدمات.","en":"Here, the service provider is able to provide most of the services."}',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => '{"ar":"النموذج الأساسي (عقد لكل خدمة)","en":"Basic Model (Contract per Service)"}',
                'description' => '{"ar":"يمكن هنا للجمعية التعاقد مباشرةً مع كل مزود من مزودي الخدمات.","en":"The association can contract directly with each service provider."}',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => '{"ar":"الإدارة الإجمالية للمرافق","en":"Total Facilities Management"}',
                'description' => '{"ar":"يتم إبرام عقد واحد بين الجمعية ومزود الخدمة، ويكون هنا مزود الخدمة مسؤولاً عن إدارة جميع الخدمات.","en":"A single contract is concluded between the association and the service provider, who is responsible for managing all services."}',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => '{"ar":"التشغيل الذاتي (نموذج الوكيل)","en":"Self-Operation (Agent Model)"}',
                'description' => '{"ar":"يقوم مجلس إدارة العقار بإدارة شؤون العقود ويتم التعاقد بشكل مباشر.","en":"The property board manages contracts and contracts directly."}',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
