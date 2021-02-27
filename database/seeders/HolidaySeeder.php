<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $holidays = [
            ['date' => Carbon::create(2021,1,1)->format('Y-m-d'), 'detail' => 'วันขึ้นปีใหม่'],
            ['date' => Carbon::create(2021,1,12)->format('Y-m-d'), 'detail' => '(วันตรุษจีน) *เพิ่มเป็นกรณีพิเศษ*'],
            ['date' => Carbon::create(2021,1,26)->format('Y-m-d'), 'detail' => 'วันมาฆบูชา'],
            ['date' => Carbon::create(2021,3,26)->format('Y-m-d'), 'detail' => '(วันหยุดราชการประจำภาคเหนือ ประเพณีไหว้พระธาตุประจำปี)'],
            ['date' => Carbon::create(2021,4,6)->format('Y-m-d'), 'detail' => 'วันจักรี'],
            ['date' => Carbon::create(2021,4,12)->format('Y-m-d'), 'detail' => 'วันสงกรานต์ *เพิ่มเป็นกรณีพิเศษ'],
            ['date' => Carbon::create(2021,4,13)->format('Y-m-d'), 'detail' => 'วันสงกรานต์'],
            ['date' => Carbon::create(2021,4,14)->format('Y-m-d'), 'detail' => 'วันสงกรานต์'],
            ['date' => Carbon::create(2021,4,15)->format('Y-m-d'), 'detail' => 'วันสงกรานต์'],
            ['date' => Carbon::create(2021,5,4)->format('Y-m-d'), 'detail' => 'วันฉัตรมงคล'],
            ['date' => Carbon::create(2021,5,10)->format('Y-m-d'), 'detail' => 'วันพืชมงคล (วันหยุดราชการประจำภาคตะวันออกเฉียงเหนือ ประเพณีงานบุญบั้งไฟ)'],
            ['date' => Carbon::create(2021,5,26)->format('Y-m-d'), 'detail' => 'วันวิสาขบูชา'],
            ['date' => Carbon::create(2021,6,3)->format('Y-m-d'), 'detail' => 'วันเฉลิมพระชนมพรรษา สมเด็จพระนางเจ้าฯ พระบรมราชินี'],
            ['date' => Carbon::create(2021,7,26)->format('Y-m-d'), 'detail' => 'วันหยุดชดเชยวันอาสาฬหบูชา'],
            ['date' => Carbon::create(2021,7,27)->format('Y-m-d'), 'detail' => 'วันหยุดชดเชยวันเข้าพรรษา *เพิ่มเป็นกรณีพิเศษ*'],
            ['date' => Carbon::create(2021,7,28)->format('Y-m-d'), 'detail' => 'วันเฉลิมพระชนมพรรษา พระบาทสมเด็จพระวชิรเกล้าเจ้าอยู่หัว'],
            ['date' => Carbon::create(2021,8,12)->format('Y-m-d'), 'detail' => 'วันแม่แห่งชาติ'],
            ['date' => Carbon::create(2021,9,24)->format('Y-m-d'), 'detail' => '(วันหยุดราชการกรณีพิเศษเนื่องในวันมหิดล) *เพิ่มเป็นกรณีพิเศษ*'],
            ['date' => Carbon::create(2021,10,6)->format('Y-m-d'), 'detail' => '(วันหยุดราชการประจำภาคใต้ ประเพณีสารทเดือนสิบ)'],
            ['date' => Carbon::create(2021,10,13)->format('Y-m-d'), 'detail' => 'วันคล้ายวันสวรรคต พระบาทสมเด็จพระบรมชนกาธิเบศร มหาภูมิพลอดุลยเดชมหาราช บรมนาถบพิตร'],
            ['date' => Carbon::create(2021,10,21)->format('Y-m-d'), 'detail' => '(วันหยุดราชการประจำภาคกลาง ประเพณีเทศกาลออกพรรษา)'],
            ['date' => Carbon::create(2021,10,22)->format('Y-m-d'), 'detail' => '(วันหยุดชดเชยวันปิยมหาราช)'],
            ['date' => Carbon::create(2021,12,6)->format('Y-m-d'), 'detail' => '(วันหยุดชดเชยวันคล้ายวันพระบรมราชสมภพ พระบาทสมเด็จพระบรมชนกาธิเบศร มหาภูมิพลอดุลยเดชมหาราช บรมนาถบพิตร)'],
            ['date' => Carbon::create(2021,12,10)->format('Y-m-d'), 'detail' => 'วันรัฐธรรมนูญ'],
            ['date' => Carbon::create(2021,12,31)->format('Y-m-d'), 'detail' => 'วันสิ้นปี'],
        ];

        foreach ($holidays as $holiday) {
            Holiday::create($holiday);
        }
    }
}
