<?php

namespace Database\Seeders;

use App\Models\BusinessSetting;
use App\Models\MailSetting as ModelsMailSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Mail;

class MailSetting extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BusinessSetting::create([
            'mail_transport'                =>'smtp',
            'mail_host'                     =>'sandbox.smtp.mailtrap.io',
            'mail_port'                     =>'2525',
            'mail_username'                 =>'12cbb68c65f692',
            'mail_password'                 =>'08cc51ed67046b',
            'mail_encryption'               =>'tls',
            'mail_from'                     =>'anujsingh854282@gmail.com',

        ]);
    }
}
