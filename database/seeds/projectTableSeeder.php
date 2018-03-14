<?php

use Illuminate\Database\Seeder;

class projectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['tamp1','temp1','temp1','t'],
            ['tamp2','temp2','temp2','s'],
            ['tamp3','temp3','temp3','s'],
            ['tamp4','temp4','temp4','s'],
            ['tamp5','temp5','temp5','s'],
            ['tamp6','temp6','temp6','s']
        ];
 
        foreach($users as $user){
            DB::table('users')->insert([
                'user_id'       => array_get($user, 0);
                'user_password' => array_get($user, 1);
                'user_name'     => array_get($user, 2);
                'user_division' => array_get($user, 3);;
            ]);
        }

        DB::table('groups')->insert([
            'group_name'    => 'group1';
            'user_t_num'    => 0;
        ]);

        for($user_num = 1 ; $user_num < 6 ; $user_num++){
            DB::table('group_students')->insert([
                'group_num'           => 0;
                'user_num'            => $user_num;
                'group_student_state' => 'a';
            ]);
        }
    }
}
