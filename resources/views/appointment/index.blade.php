<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                @if (Auth::user()->role_id < 3)
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('appointments.create') }}">เพิ่มการนัดหมาย</a>
                    </div>
                @endif
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th>หัวข้อ</th>
                            <th>หน่วยงาน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="#">ตอบคำถามภาษีระหว่างประเทศ</a></td>
                            <td>กองวิชาการแผนภาษี</td>
                        </tr>
                        <tr class="bg-emerald-200">
                            <td><a href="#">ตอบการใช้งาน Web Service</a></td>
                            <td>กองเทคโนโลยีสารสนเทศ</td>
                        </tr>
                        <tr>
                            <td><a href="#">การยื่นแบบแสดงรายการภาษีเงินได้นิติบุคคล</a></td>
                            <td>สำนักงานสรรพากรภาต 12</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
