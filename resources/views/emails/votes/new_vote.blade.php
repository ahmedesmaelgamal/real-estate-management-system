@component('mail::message')
# إشعار تصويت جديد 🗳️

مرحبًا {{ $owner->name }}،

تم فتح تصويت جديد يخص الجمعية الخاصة بك.

**نسبة التصويت المطلوبة:** {{ $vote->vote_percentage }}%

يمكنك المشاركة في التصويت قبل تاريخ: **{{ \Carbon\Carbon::parse($voteDetail->end_date)->format('Y-m-d') }}**

@component('mail::button', ['url' => url('/')])
اذهب إلى الموقع
@endcomponent

شكرًا لك،  
{{ config('app.name') }}
@endcomponent
