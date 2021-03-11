<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Round;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app = new Appointment();
        $app->uuid = (string) Str::orderedUuid();
        $app->name = 'ตอบคำถามภาษีระหว่างประเทศ';
        $app->worker = 4;
        $app->mon = false;
        $app->fri = false;
        $app->user_id = 1;
        $app->public = true;
        $app->public_user_id = 1;
        $app->office_id = 1;
        $app->save();

        $rounds = [
            ['start' => '10:00', 'end' => '11:00','appointment_id' => $app->id],
            ['start' => '11:00', 'end' => '12:00','appointment_id' => $app->id],
            ['start' => '14:00', 'end' => '15:00','appointment_id' => $app->id],
            ['start' => '15:00', 'end' => '16:00','appointment_id' => $app->id],

        ];

        foreach ($rounds as $round) {
            Round::create($round);
        }

        $subjects = [
            ['name' => 'อนุสัญญาเพื่อการเว้นการเก็บภาษีซ้อน (Tax Treaties)','appointment_id' => $app->id],
            ['name' => 'การรายงานข้อมูลรายประเทศ (Country-By-Country Report)','appointment_id' => $app->id],
            ['name' => 'หนังสือรับรองเพื่อการรัษฎากรเป็นภาษาอังกฤษ (Tax Certificates)','appointment_id' => $app->id],
            ['name' => 'การดำเนิการเพื่อความตกลงร่วมกัน (Mutual Agreement Procedures)','appointment_id' => $app->id],

        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
