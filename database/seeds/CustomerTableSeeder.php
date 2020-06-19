<?php

use Illuminate\Database\Seeder;
use App\Customers;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customerRecords = [
            'customer_id'=>'1','customer_name'=>'customer1','customer_mobile'=>'9876543210',
            'customer_email'=>'customer@gmail.com','customer_place'=>'Bangalore'
        ];
        Customers::insert($customerRecords);
    }
}
