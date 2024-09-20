<?php
use common\models\Installment;
use common\models\Setting;


return [
    'daysBeforeNotiMerit' => 3,
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'keyGoogleMap' => 'AIzaSyCS0lN9X7ZYJ-Lg7WOm-lkStRnOGeoH9_c',
    'user.passwordResetTokenExpire' => 3600,
    'statusCase' => ['en'=>[1 => 'Published',0 => 'Unpublished'],'ar'=>[1 => 'منشور',0 => 'غير منشور']],
    'statusHousRent' => ['en'=>[1 => 'Rented',0 => 'Not Renter'],'ar'=>[1 => 'مؤجرة',0 => 'ليست مؤجرة']],
    'langauges' => ['en'=>['ar' => 'Arabic','en' => 'English'],'ar'=>['ar' => 'عربي','en' => 'إنجليزي']],
	'statusAccount' => ['en'=>[10 => 'Available',1 => 'Disabled'],'ar'=>[10 => 'مفعل',1 => 'غير مفعل']],
	'yesNo' => ['en'=>[1 => 'Yes',0 => 'No'],'ar'=>[1 => 'نعم',0 => 'لا']],
    'advertisertype' => ['en'=>[1 => 'Personal',0 => 'Company'],'ar'=>[1 => 'فرد',0 => 'منشأة']],
    'advertisercategory' => ['en'=>[1 => 'Owner',0 => 'Commissioner'],'ar'=>[1 => 'مالك',0 => 'مفوض']],
    'adtype' => ['en'=>[1 => 'Offer'],'ar'=>[1 => 'عرض']],
    'adsubtype' => ['en'=>[0 => 'Investing',1 => 'Selling', 2 => 'Renting'],'ar'=>[0 => 'استثمار', 1 => 'بيع', 2 => 'تأجير']],
    'statusRead' => ['en'=>[1 => 'Read',0 => 'UnRead'],'ar'=>[1 => 'مقروء',0 => 'غير مقروء']],
    'statusActive' => ['en'=>[1 => 'Open',0 => 'Closed'],'ar'=>[1 => 'مفتوح',0 => 'مغلق']],
    'gender' => ['en'=>[1 => 'Male',0 => 'Female'],'ar'=>[1 => 'ذكر',0 => 'أنثى']],
    'renterType' => ['en'=>[0 => 'residential',1 => 'commercial',2 => 'Industrial'],'ar'=>[0 => 'سكني',1 => 'تجاري', 2 => 'صناعي']],
    'months' => ['en'=>[1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December'],'ar'=> [1=> 'يناير', 2=> 'فبراير', 3=> 'مارس', 4=> 'إبريل', 5=> 'مايو', 6=> 'يونيو', 7=> 'يوليو', 8=> 'أغسطس', 9=> 'سبتمبر', 10=> 'أكتوبر', 11=> 'نوفمبر', 12=> 'ديسمبر']],
    'CommentStatus'=>['en'=>[0 => 'Publish The Comments after reviewing of adminstration',1 => 'Publish the commonts imadatialy'],'ar'=>['0'=>'نشر التعليقات بعد مراجعتها من الادمن','1'=>'النشر التلقائي للتعليقات']],
    'userType' => [
        'en'=>[
            'admin' => 'Admin',
            'admin_user' => 'Admin user',
            'estate_officer' => 'Estate Officer' ,
            'owner_estate_officer' => 'Owner Estate' ,
            'estate_officer_user' => 'Estate Officer User' ,
            'owner' => 'Owner' ,
            'maintenance_officer' => 'Maintenance Officer' ,
            'maintenance_officer_user' => 'Maintenance Officer User' ,
            'renter' => 'Renter'
        ],'ar'=>[
            'admin' => 'مدير النظام',
            'admin_user' => 'مستخدم النظام',
            'owner_estate_officer' => 'مالك عقار' ,
            'estate_officer' => 'مكتب العقار' ,
            'estate_officer_user' => 'مستخدم مكتب العقار' ,
            'owner' => 'مالك' ,
            'maintenance_officer' => 'مكتب الصيانة' ,
            'maintenance_officer_user' => 'مستخدم مكتب الصيانة' ,
            'renter' => 'مستأجر'
        ],'key'=>[
            1=>'developer',
            2=>'admin',
            3=>'admin_user',
            4=>'estate_officer',
            5=>'estate_officer_user',
            6=>'owner',
            7=>'maintenance_officer',
            8=>'maintenance_officer_user',
            9=>'renter',
            10=>'owner_estate_officer',
        ]
    ],
    'pageName' => [
        'en'=>[
            'home' => 'Home Page',
            'estate_officer' => 'Estate Officer' ,
            'owner' => 'Owner' ,
            'maintenance_officer' => 'Maintenance Officer' ,
            'renter' => 'Renter',
            'gallery' => 'Gallery'
        ],'ar'=>[
            'home' => 'الصفحة الرئيسية',
            'estate_officer' => 'مكتب العقار' ,
            'owner' => 'مالك' ,
            'maintenance_officer' => 'مكتب الصيانة' ,
            'renter' => 'مستأجر',
            'gallery' => 'المعرض'
        ]
    ],
     'sendingStatus' => ['en'=>[0=> 'nothing',1 => 'Messages via mobile phone',2 => 'Messages via email',3 => 'Messages by both'],'ar'=>[0=>'بدون',1 => 'إرسال للهاتف فقط',2 => 'إرسال للإيميل فقط',3 => 'إرسال لكلاهما']],
     'buildingStatus' => ['en'=>['new'=> 'new','old' => 'old'],'ar'=>['new'=> 'جديد','old' => 'قديم']],

    'PayMethod' => ['en'=>[Setting::INSTALLMENT_CASH => 'Cash',Setting::INSTALLMENT_DEPOSIT_BANK => 'Deposit Bank',Setting::STATUS_PAY_CARD => 'Electronic payment.', Setting::STATUS_NETWORK=>'Network'],'ar'=>[Setting::INSTALLMENT_CASH => 'كاش',Setting::INSTALLMENT_DEPOSIT_BANK => 'تحويل بنكي',Setting::STATUS_PAY_CARD => 'الدفع الالكتروني.',Setting::STATUS_NETWORK=>'الشبكة' ]],

    'company_type' => ['en'=>[1 => 'Maintenance',2 => 'Estate Office'],'ar'=>[1 => 'مكتب عقاري او وسيط عقاري او مسوق عقاري',2 => 'مقدم صيانة أو خدمات']],
    'estate_type' => ['en'=>[1 => 'For Sale',2 => 'For Rent'],'ar'=>[1 => 'للبيع',2 => 'للإيجار']],
    'offertype' => ['en'=>[1 => 'For Sale',2 => 'For Rent'],'ar'=>[1 => 'للبيع',2 => 'للإيجار']],
    'statusPayment' => ['en'=>[Installment::STATUS_UNPAID => 'Unpaid',Installment::STATUS_PART_PAID=>'part was paid',Installment::STATUS_PAID => 'Paid'],'ar'=>[Installment::STATUS_UNPAID => 'غير مدفوع',Installment::STATUS_PART_PAID=>'تم دفع جزء',Installment::STATUS_PAID => 'مدفوع',]],
    'statusPayment2' => ['en'=>[Installment::STATUS_UNPAID => 'Unpaid',Installment::STATUS_PART_PAID=>'part was paid',Installment::STATUS_PAID => 'Paid',Installment::STATUS_CANCEL => 'Cancelled'],'ar'=>[Installment::STATUS_UNPAID => 'غير مدفوع',Installment::STATUS_PART_PAID=>'تم دفع جزء',Installment::STATUS_PAID => 'مدفوع',Installment::STATUS_CANCEL => 'ملغي',]],
    'building_type' => ['en'=>[1 => 'Building',2 => 'Housing Unit'],'ar'=>[1 => 'مباني',2 => 'وحدات سكنية']],
    'brokerageType' => ['en'=>[1 => 'Percent',2 => 'Static Amount'],'ar'=>[1 => 'نسبة مئوية',2 => 'مبلغ ثابت']],
    'propertyManagementFeesType' => ['en'=>[1 => 'Percent',2 => 'Static Amount'],'ar'=>[1 => 'نسبة مئوية',2 => 'مبلغ ثابت']],
    'marketingFeesType' => ['en'=>[1 => 'Percent',2 => 'Static Amount'],'ar'=>[1 => 'نسبة مئوية',2 => 'مبلغ ثابت']],
    'recipient_type' => ['owner'=> Yii::t('app','Owner'),'maintenance_officer'=> Yii::t('app','Maintenance Office'),'other'=> Yii::t('app','Other')],
    'statusOrder' => ['en'=>[1=>'New' ,2=>'Pending View' , 3=>'Accept' , 4=>'Not Accept' , 5=>'Confirm Accept' , 6=>'Replay Fix' , 7=>'Pending Fix' , 8=>'Finish Fix' , 9=>'Active Fix' , 10=>'Close' ],'ar'=>[1=>'جديد' ,2=>'إنتظار  العروض' , 3=>'تمت الموافقة' , 4=>'تم الرفض' , 5=>'تأكيد  الموافقة' , 6=>'معادة للصيانة' , 7=>'إنتظار الصيانة' , 8=>'إنتهاء الإصلاح' , 9=>'الموافقة على الإصلاح' , 10=>'مغلق' ]],
    'defaultBalanceType'=>['en'=>[0 => 'Selected Balance',1 => 'Open Balance'],'ar'=>[0=>'رصيد محدد',1=>'رصيد مفتوح']],
    'agree_terms' => ['en'=>[1 => 'I Agree Terms & Conditions and Privacy Policy'],'ar'=>[1 => 'أوافق على الشروط والأحكام وسياسة الخصوصية']],
     'period' => [
        'en'=>[
            1 => 'Monthly',
            2 => 'yearly',
        ],'ar'=>[
            1 => 'شهرياً',
            2 => 'سنوياً',
        ]
    ],
    'currency' => [
        'en'=>[
            1 => 'YER',
            2 => 'USD',
        ],'ar'=>[
            1 => 'ريال',
            2 => 'دولار',
        ]
    ],
    //'agree_terms' => ['en'=>[1 => 'I Agree <a href="javascript:;" class="clsTerms">Terms & Conditions</a> and <a href="javascript:;" class="clsPrivacy">Privacy Policy</a>'],'ar'=>[1 => 'أنا موافق <a href="javascript:;" class="clsTerms">البنود و الظروف</a> and <a href="javascript:;" class="clsPrivacy">سياسة الخصوصية</a>']],
    //'agree_terms' => ['en'=>[1 => 'html_entity_decode(I Agree <a href="javascript:;" class="clsTerms">Terms & Conditions</a> and <a href="javascript:;" class="clsPrivacy">Privacy Policy</a>)'],'ar'=>[1 => 'html_entity_decodeأنا موافق <a href="javascript:;" class="clsTerms">البنود و الظروف</a> and <a href="javascript:;" class="clsPrivacy">سياسة الخصوصية</a>)']],

];
