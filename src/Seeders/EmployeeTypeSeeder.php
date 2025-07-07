<?php

namespace Hanafalah\ModuleEmployee\Seeders;

use Illuminate\Database\Seeder;

class EmployeeTypeSeeder extends Seeder{
    protected $__employee_types = [
        [
            'name' => 'PKWT',
            'note' => 'Perjanjian Kerja Waktu Tertentu'
        ],
        [
            'name' => 'PHL',
            'note' => 'Pegawai Harian Lepas'
        ],
        [
            'name' => 'Kontrak',
            'note' => 'Pegawai Kontrak'
        ],
        [
            'name' => 'Probation',
            'note' => 'Pegawai Probation'
        ],
        [
            'name' => 'Magang',
            'note' => 'Pegawai Magang'
        ],
        [
            'name' => 'Tetap',
            'note' => 'Pegawai Tetap'
        ],
        [
            'name' => 'Outsourcing',
            'note' => null
        ],
        [
            'name' => 'Intern',
            'note' => null
        ],
        [
            'name' => 'Freelance',
            'note' => null
        ]
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $model = app(config('database.models.EmployeeType'));
        foreach ($this->__employee_types as $employee_type) {
            $model->updateOrCreate([
                'name' => $employee_type['name'],
                'note' => $employee_type['note'] ?? null
            ]);
        }
    }
}