@component('mail::message')
# การมอบหมาย

หัวข้อ : <span style="color: blue">{{ $booking->appointment->name }}</span><br>
หมายเลขผู้เสียภาษี: <span style="color: blue">{{ $booking->nid }}</span><br>
ชื่อผู้เสียภาษี: <span style="color: blue">{{ $booking->name }}</span><br>
เรื่องที่เกี่ยวข้อง: <br>
@foreach ($booking->subjects as $item)
<span style="color: blue">{{ $item->name }} </span><br>
@endforeach
<br>
รายละเอียด: <span style="color: blue">{{ $booking->detail }}</span><br>
เบอร์โทรศัพฑ์: <span style="color: blue">{{ $booking->phone }}</span><br>
อีเมล์: <span style="color: blue">{{ $booking->email }}</span><br>
Facebook: <span style="color: blue">{{ $booking->facebook }}</span><br>
Line: <span style="color: blue">{{ $booking->line_id }}</span><br>
วันที่นัด: <span style="color: blue">{{ $booking->date }}</span><br>
เวลา: <span style="color: blue">{{ substr($booking->round->start,0,5) }} - {{ substr($booking->round->end,0,5) }}
</span><br>
@if ( $booking->employee)
เจ้าหน้าที่ผู้รับผิดชอบ: <span style="color: green">{{  $booking->employee->first_name }}
    {{ $booking->employee->last_name }} (<a
        href="{{ $booking->employee->email }}">{{ $booking->employee->email }}</a>)</span><br>
@endif

@component('mail::button', ['url' => 'https://interapp2.rd.go.th/e-appointment/public/login-employee'])
เข้าสู่ระบบปรับปรุงสถานะ เมื่อแล้วเสร็จ
@endcomponent

ด้วยความนับถือ<br>
<a href="https://interapp2.rd.go.th/e-appointment">{{ config('app.name') }}</a>
@endcomponent

