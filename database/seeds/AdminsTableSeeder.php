<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
            [
                'id'=>1,
                'name'=>'admin',
                'type'=>'admin',
                'mobile'=>'9876543210',
                'email'=>'admin@admin.com',
                'password'=>'$2y$10$O0Pck0ko6WArSSl6rzPIMOzYMZL6y/NsP4TU9Dki2Dt43ByQaGCc6',
                'image'=>'',
                'status'=>1
            ],

            [
                'id'=>2,
                'name'=>'subadmin',
                'type'=>'subadmin',
                'mobile'=>'9876543211',
                'email'=>'admin@subadmin.com',
                'password'=>'$2y$10$O0Pck0ko6WArSSl6rzPIMOzYMZL6y/NsP4TU9Dki2Dt43ByQaGCc6',
                'image'=>'',
                'status'=>1
            ],
        ];
//for multiple record
        foreach($adminRecords as $key => $record){
            \App\Admin::create($record);
        }
    }
}
