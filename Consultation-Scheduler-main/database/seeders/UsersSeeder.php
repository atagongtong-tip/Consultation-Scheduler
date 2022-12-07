<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{ User, Industry, SoftSkill };
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Helpers\Utils;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $password = '09071995';
        $verified = Carbon::now();

        $data = [
            [
                'is_super' => 1,
                'role_id' => 1,
                'status' => 'Active',
                'first_name' => 'Test',
                'last_name' => 'Admin',
                'photo' => null,
                'email' => 'admin@gmail.com',
                'password' => Hash::make($password),
                'email_verified_at' => $verified,
            ],
            [
                'role_id' => 2,
                'status' => 'Active',
                'first_name' => $faker->firstNameMale,
                'last_name' => $faker->lastName,
                'gender' => 'Male',
                'contact_no' => '1234567890',
                'date_of_birth' => '2000-01-01 00:00:00',
                'city' => 'Makati',
                'province' => 'Metro Manila',
                'photo' => null,
                'email' => 'teacher@gmail.com',
                'password' => Hash::make($password),
                'email_verified_at' => $verified,
            ],
            [
                'role_id' => 2,
                'status' => 'Active',
                'first_name' => $faker->firstNameMale,
                'last_name' => $faker->lastName,
                'gender' => 'Male',
                'contact_no' => '1234567890',
                'date_of_birth' => '2000-01-01 00:00:00',
                'city' => 'Makati',
                'province' => 'Metro Manila',
                'photo' => null,
                'email' => 'teacher1@gmail.com',
                'password' => Hash::make($password),
                'email_verified_at' => $verified,
            ],
            [
                'role_id' => 2,
                'status' => 'Active',
                'first_name' => $faker->firstNameMale,
                'last_name' => $faker->lastName,
                'gender' => 'Male',
                'contact_no' => '1234567890',
                'date_of_birth' => '2000-01-01 00:00:00',
                'city' => 'Makati',
                'province' => 'Metro Manila',
                'photo' => null,
                'email' => 'teacher2@gmail.com',
                'password' => Hash::make($password),
                'email_verified_at' => $verified,
            ],
            [
                'role_id' => 2,
                'status' => 'Active',
                'first_name' => $faker->firstNameMale,
                'last_name' => $faker->lastName,
                'gender' => 'Male',
                'contact_no' => '1234567890',
                'date_of_birth' => '2000-01-01 00:00:00',
                'city' => 'Makati',
                'province' => 'Metro Manila',
                'photo' => null,
                'email' => 'teacher3@gmail.com',
                'password' => Hash::make($password),
                'email_verified_at' => $verified,
            ],
            [
                'role_id' => 2,
                'status' => 'Active',
                'first_name' => $faker->firstNameMale,
                'last_name' => $faker->lastName,
                'gender' => 'Male',
                'contact_no' => '1234567890',
                'date_of_birth' => '2000-01-01 00:00:00',
                'city' => 'Makati',
                'province' => 'Metro Manila',
                'photo' => null,
                'email' => 'teacher4@gmail.com',
                'password' => Hash::make($password),
                'email_verified_at' => $verified,
            ],
            [
                'role_id' => 3,
                'status' => 'Active',
                'first_name' => $faker->firstNameMale,
                'last_name' => $faker->lastName,
                'gender' => 'Male',
                'contact_no' => '1234567890',
                'date_of_birth' => '2000-01-01 00:00:00',
                'city' => 'Makati',
                'province' => 'Metro Manila',
                'photo' => null,
                'email' => 'student@gmail.com',
                'password' => Hash::make($password),
                'email_verified_at' => $verified,
            ],
        ];

        for ($i = 0; $i < count($data); $i++) {
            $user = User::create($data[$i]);
            if ($user->role_id === 2 && $user->id !== 2) {
                $user->teacherProfile()->create([
                    'about' => 'lorem ipsum dolor sit amet consectetur adipiscing elit',
                    'expertise' => 'Doctor of Engineering'
                ]);
                $user->courses()->syncWithoutDetaching([1,2,3]);
            }
        }
    }
}
