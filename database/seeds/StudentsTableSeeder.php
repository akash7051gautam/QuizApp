<?php


use App\Student;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::create([
            'roll_no'=>'1',
            'email'=>'abpt89@gmail.com',
            'first_name'=>'Abhishek',
            'last_name'=>'Pathania',
            'password' => Hash::make('12345678'),
            'user_id'=>'1',
            'status'=>'0'
        ]);

        Student::create([
            'roll_no'=>'2',
            'email'=>'redzx342@gmail.com',
            'first_name'=>'Red',
            'last_name'=>'Zx',
            'password' => Hash::make('12345678'),
            'user_id'=>'2',
            'status'=>'0'
        ]);
    }
}
