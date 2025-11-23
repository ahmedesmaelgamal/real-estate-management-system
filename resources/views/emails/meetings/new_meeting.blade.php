@component('mail::message')
# إشعار اجتماع جديد 📅

مرحبًا {{ $owner->name }}،

تم إنشاء اجتماع جديد للجمعية الخاصة بك.

**تاريخ الاجتماع:** {{ \Carbon\Carbon::parse($meeting->date)->format('Y-m-d H:i') }}  
**العنوان:** {{ $meeting->address }}  

@if($meeting->agenda)
**جدول الأعمال:** {{ $meeting->agenda->title }}
@endif

@component('mail::button', ['url' => url('/')])
عرض التفاصيل
@endcomponent

شكرًا لتعاونك،  
{{ config('app.name') }}
@endcomponent
