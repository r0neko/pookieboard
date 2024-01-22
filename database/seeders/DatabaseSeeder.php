<?php

namespace Database\Seeders;

use App\PookieBoard\Modules\ModuleManager;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ModuleManager $m)
    {
        foreach($m->getModuleSeeders() as $seeder) {
            (new $seeder())->run();
        }
    }
}
