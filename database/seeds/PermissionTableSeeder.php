<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function getModels($path)
    {
        $models = [];
        $files = scandir($path);
        foreach ($files as $filename) {
            if ($filename === '.' or $filename === '..') continue;
            if (substr($filename,-4)=='.php') {
                $models[] = substr($filename,0,-4);
            }
        }
        return $models;
    }
    public function run()
    {
        $permissions=$this->getModels(app_path());
           foreach($permissions as $permission){
               Permission::firstOrCreate(['name'=>'view '.strtolower($permission)]);
               Permission::firstOrCreate(['name'=>'create '.strtolower($permission)]);
               Permission::firstOrCreate(['name'=>'edit '.strtolower($permission)]);
               Permission::firstOrCreate(['name'=>'delete '.strtolower($permission)]);
           }
    }
}
