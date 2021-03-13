@component('mail::message')
# ยินดีต้อนรับ ระบบนัดหมายตอบคำถามภาษี (e-Appointment)

ขอขอบคุณที่ท่านลงทะเบียนใช้งาน

@component('mail::button', ['url' => 'https://interapp2.rd.go.th/e-appointment/public/login'])
เข้าสู่ระบบ
@endcomponent

ด้วยความนับถือ<br>
{{ config('app.name') }}
@endcomponent
