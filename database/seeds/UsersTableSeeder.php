<?php

use Illuminate\Database\Seeder;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->novo('Desafio Softcom', 'desafio@softcom.com.br', 'softcom');
    }

    function novo(string $nome, string $email, string $senha) {
        if (User::where('email', $email)->first() != null)
            return;

        $user = new User();

        $user->name = $nome;
        $user->email = $email;
        $user->password = bcrypt($senha);

        $user->save();
    }
}
