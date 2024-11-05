<?php

namespace common\components;

use common\models\Order;
use common\models\Plan;
use yii;
use common\models\Purview;
use common\models\Project;
use common\models\Program;

// use common\components\LIB\Otsms;

use common\models\Setting;
use common\models\SmsProvider;
use common\models\User;
use common\models\Attachment;
use common\models\EstateOffice;
use common\models\MaintenanceOffice;
use common\models\NotifTempEstateOffice;
use common\models\NotifTemp;
use yii\web\NotFoundHttpException;
use Gregwar\Image\Image;
use yii\web\UploadedFile;
use yii\helpers\Url;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class GeneralHelpers
{

    public static function extractKeyWords($string)
    {

        mb_internal_encoding('UTF-8');
        $stopwords = array();
        $string = preg_replace('/[\pP]/u', '', trim(preg_replace('/\s\s+/iu', '', mb_strtolower($string))));
        $matchWords = array_filter(explode(' ', $string), function ($item) use ($stopwords) {
            return !($item == '' || in_array($item, $stopwords) || mb_strlen($item) <= 2 || is_numeric($item));
        });
        $wordCountArr = array_count_values($matchWords);
        arsort($wordCountArr);
        return implode(',', array_keys(array_slice($wordCountArr, 0, 10)));
    }


    public static function sendNotif($notifTempId, $params, $estateOfficeId = null)
    {
        $notifTemp = self::getTemp($notifTempId, $estateOfficeId);

        $favLang = self::getFavLang($params['re_id'], $params['re_type']);
        if ($favLang == 'ar') {
            $msgEmail = \Yii::t('app', $notifTemp->body_email, $params);
            $msgTitleEmaile = \Yii::t('app', $notifTemp->title_email, $params);
            $msgSms = \Yii::t('app', $notifTemp->body_sms, $params);
        } else {
            $msgEmail = \Yii::t('app', $notifTemp->body_email_en, $params);
            $msgTitleEmaile = \Yii::t('app', $notifTemp->title_email_en, $params);
            $msgSms = \Yii::t('app', $notifTemp->body_sms_en, $params);
        }

        if ($notifTemp->enable_sms = 1) {

            // سيتم إرسال رسالة إذا كان الاشعار غير مرتبط بمكتب أو إذا كان مرتبط بمكتب ولديه رصيد كافي للإرسال
            $estatOffice = EstateOffice::findOne($estateOfficeId);
            if (!$estateOfficeId || ($estatOffice !== null && $estatOffice->checkAvalibalBalance('sms'))) {
                $statusSend = self::sendSms($params['mobile'], $msgSms);
            } else {
                $statusSend = ['status' => false, 'message' => 'You cannot Send Messages sms  due to the expiration of the SMS balance'];
            }

            if(is_array($statusSend)) {
                if ($statusSend['status']) {
                    if ($estatOffice) {
                        $estatOffice->sms_balance = $estatOffice->sms_balance - 1;
                        $estatOffice->save(false);
                    }
                    if (Yii::$app instanceof \yii\web\Application) {
                        Yii::$app->session->setFlash('success', Yii::t('app', $statusSend['message']));
                    }
                } else {
                    if (Yii::$app instanceof \yii\web\Application) {
                        Yii::$app->session->setFlash('dangur', Yii::t('app', $statusSend['message']));
                    }
                }
            }

//            $log = new \common\models\LogMessage();
//
//            if ($estateOfficeId) {
//                $log->sender_id = (int)$estateOfficeId;
//                $log->sender_type = 'estate_officer';
//            } else {
//                $log->sender_id = 0;
//                $log->sender_type = 'admin';
//            }
//            $log->notif_temp_id = (int)$notifTempId;
//            $log->receiver_id = (int)$params['re_id'];
//            $log->receiver_type = $params['re_type'];
//            $log->contact_mobile = isset($params['mobile']) ? $params['mobile'] : '';
//            $log->contact_email = '';
//            $log->message = $msgSms;
//            $log->status = $statusSend['message'];
//            $log->save();
        }

//        if ($notifTemp->enable_email && $params['email']) {
//
//            $attach = isset($params['attach']) ? $params['attach'] : null;
//
//            $statusSend = self::sendEmail($params['email'], $msgTitleEmaile, $msgEmail, '', '', $attach);
//
//            if ($statusSend['status'] == true) {
//                if (Yii::$app instanceof \yii\web\Application) {
//                    Yii::$app->session->setFlash('success', Yii::t('app', $statusSend['message']));
//                }
//            } else {
//                if (Yii::$app instanceof \yii\web\Application) {
//                    Yii::$app->session->setFlash('dangur', Yii::t('app', $statusSend['message']));
//                }
//            }
//
////            $log = new \common\models\LogMessage();
////            if ($estateOfficeId) {
////                $log->sender_id = (int)$estateOfficeId;
////                $log->sender_type = 'estate_officer';
////            } else {
////                $log->sender_id = 0;
////                $log->sender_type = 'admin';
////            }
////            $log->notif_temp_id = (int)$notifTempId;
////            $log->receiver_id = (int)$params['re_id'];
////            $log->receiver_type = $params['re_type'];
////            $log->contact_mobile = '';
////            $log->contact_email = isset($params['email']) ? $params['email'] : '';
////            $log->message = $msgEmail;
////            $log->status = $statusSend['message'];
////            $log->save();
//
//        }

        if ($notifTemp->enable_system) {
            $params['content'] = $msgEmail;
            \common\models\Notification::addNew($params);
        }

    }


    public static function sendEmail($to_email, $subject, $message, $from = '', $fileView = null, $file_attachment = null)
    {

        if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'localhost') {
            return ['status' => true, 'message' => "Send Successfully"];
        }

        // return ['status' => true ,'message'=> "Send Successfully"];

        $setting = SmsProvider::findOne(1);
        $user_msg = 'no-reply@nafithh.sa';
        // $password_msg =$setting->sendgrid_password;
        $password_msg = 'tvR;=SPuYC--3oWq';

        Yii::$app->mailer->setTransport([
            'class' => \yii\symfonymailer\Mailer::class,
            'scheme' => 'smtps',
            'host' => 'mail.s1323.sureserver.com',
            'username' => $user_msg,
            'password' => $password_msg,
            'port' => '465',
            'encryption' => 'ssl',
            'streamOptions' => [
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ]
        ]);

        Yii::$app->mailer->setViewPath(Yii::getAlias('@common/mail'));

        // $sendGrid = Yii::$app->mailer;
        // $sendGrid = Yii::$app->sendGrid;
        // $sendGrid->username = $setting->sendgrid_username;
        // $sendGrid->password = $setting->sendgrid_password;

        // $sendGrid->setViewPath(Yii::getAlias('@common/mail'));

        if (!$from) {
            $from = Setting::findOne(1)->email_admin;
        }
        if (empty($fileView))
            $message = Yii::$app->mailer->compose('general', ['message' => $message, 'subject' => $subject]);

        else
            $message = Yii::$app->mailer->compose($fileView, ['message' => $message, 'subject' => $subject]);

        // print_r($message); die();
        $message->setFrom($from)
            ->setTo($to_email)
            ->setSubject($subject);

        if (!empty($file_attachment)) {
            $message->attach($file_attachment);
        }
        // try {
        //     if ($message->send())
        //     {
        //         return ['status' => true ,'message'=> "Send Successfully"];
        //     } else{
        //         return ['status' => false ,'message'=> "errore".@$sendGrid->getErrors()[0]];
        //     }
        // } catch (TransportExceptionInterface $e) {
        //         return ['status' => false ,'message'=> "errore ".implode(", ",$e)];
        //     // some error prevented the email sending; display an
        //     // error message or try to resend the message
        // }
//        try {
//            if ($sendGrid->getSwiftMailer()->send($message->getSwiftMessage(), $failures))
//            {
//                return ['status' => true ,'message'=> "Send Successfully"];
//            } else {
//                return ['status' => false ,'message'=> "errore ".implode(", ",$failures)];
//            }
//
//        } catch (Exception $e) {
//            return ['status' => false ,'message'=> "errore ".implode(", ",$e)];
//        }
    }

    // public static function sendEmail($to_email, $subject, $message,$from = '', $fileView = null,$file_attachment=null)
    // {
    //     if (!$to_email || empty($to_email))
    //         return ['status' => false ,'message'=> "The Email is not correct, or blank!!"];

    //     if(!$from){
    //         $from = Setting::findOne(1)->email_admin;
    //     }
    //     $sendGrid = Yii::$app->sendGrid;
    //     if (empty($fileView))
    //         $message = $sendGrid->compose('general', ['message' => $message, 'subject' => $subject]);

    //     else
    //         $message = $sendGrid->compose($fileView, ['message' => $message, 'subject' => $subject]);

    //     $message->setFrom($from)
    //         ->setTo($to_email)
    //         ->setSubject($subject);

    //     if (!empty($file_attachment)){
    //         $message->attach($file_attachment);
    //     }

    //     // if ($message->send() === true) {
    //     // echo 'Success!';
    //     // echo '<pre>' . print_r($sendGrid->getRawResponse(), true) . '</pre>';

    //     // } else {
    //     // echo 'Error!<br>';
    //     // echo '<pre>' . print_r($sendGrid, true) . '</pre>';
    //     // echo '<pre>' . print_r($sendGrid->getErrors(), true) . '</pre>';
    //     // }
    //     // die();
    //     if ($result = $message->send()) {
    //         return ['status' => true ,'message'=> "Send Successfully"];
    //     } else {
    //         return ['status' => false ,'message'=> "errore".@$sendGrid->getErrors()[0]];
    //     }

    // }
    /**
     *
     */
    public static function sendSms($to, $message)
    {
//        if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'localhost') {
//            return ['status' => true, 'message' => "Send Successfully"];
//        }

        //get variables from admin settings

        $settingSms = SmsProvider::findOne(1);
        $host_msg = $settingSms->domain;
        $user_msg = $settingSms->username;
        $password_msg = $settingSms->password;
        $sender_msg = $settingSms->sender;

        $msg = $message;
//        $msg = urlencode($message).' - '.rand(1111,9999);
        //للإظهار jop_id والرصيد المخصوم والرصيد المتبقي
        $infos = "YES";
        //للإظهار نتيجة الإرسال على شكل XML
        $xml = "XML";
        $to = '966' . $to;

        if ($host_msg != NULL && $user_msg != NULL && $password_msg != NULL) {
            if ($sender_msg != NULL) {
                $SendingResult = self::SendMsgSms($user_msg, $password_msg, $to, $sender_msg, $msg, $infos, $xml);
            } else {
                $SendingResult = self::SendMsgSms($user_msg, $password_msg, $to, '', $msg, $infos, $xml);
            }
//            $lib = simplexml_load_string(iconv("windows-1256", "UTF-8", $SendingResult));

            return ['status' => true, 'message' => "Send Successfully ,JOB_ID : "];


//            if ($lib) {
//                $ResultSending = $lib->ResultSending[0];
//                $code = $ResultSending->Code;
//
//                // $code = $SendingResult;
//
//                if ($code == "1") {
//                    $text = "JOB_ID : " . $ResultSending->JOB_ID;
//                    $text .= "<br>";
//                    $text .= "Cost : " . $ResultSending->Cost;
//                    $text .= "<br>";
//                    $text .= "Credit : " . $ResultSending->Credit;
//                    return ['status' => true, 'message' => "Send Successfully ,JOB_ID : " . $ResultSending->JOB_ID];
//
//                } else {
//                    return ['status' => false, 'message' => "error profiver code:$code"];
//
//                }
//            }

        } else
            return ['status' => false, 'message' => "error data profiver"];
    }

    public static function SendMsgSms($UserName, $UserPassword, $Numbers, $Originator, $Message, $infos = "", $xml = "")
    {
        $url = "https://app.mobile.net.sa/api/v1/send"; // Updated URL for the request

        if (!$url || $url == "") {
            return "No URL";
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, true);

            // Prepare the POST data
            $dataPOST = array(
                "number" => $Numbers,
                "senderName" => $Originator,
                "sendAtOption" => "Now",
                "messageBody" => $Message,
                "allow_duplicate" => true

//                'userName' => $UserName,
//                'userPassword' => $UserPassword,
//                'userSender' => $Originator,
//                'numbers' => $Numbers,
//                'msg' => $Message,
//                'By' => "standard"
            );

            if ($infos) $dataPOST["infos"] = "YES";
            if ($xml) $dataPOST["return"] = "XML";

            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dataPOST)); // Use http_build_query for proper encoding
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 0);

            // Set the Authorization header with Bearer token
            $bearerToken = "vPtRrBkjs25SFzUazyK02fKyNNgkLmjFw2JQqSVe"; // Replace with your actual token
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer " . $bearerToken,
                "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
            ));

            $FainalResult = curl_exec($ch);

            if (curl_errno($ch)) {
                // Handle any errors
                $FainalResult = 'Curl error: ' . curl_error($ch);
            }

            curl_close($ch);
            return $FainalResult;
        }

    }

    public static function getTemp($notifTempId, $estateOfficeId)
    {

        if ($estateOfficeId !== null &&
            in_array($notifTempId, NotifTempEstateOffice::NOTIF_AVALIBAL_FOR_ESTATE_OFFICE) &&
            ($temp = NotifTempEstateOffice::find()->where(['notification_id' => $notifTempId, 'estate_office_id' => $estateOfficeId])->one()) !== null
        )
            return $temp;
        elseif (($temp = NotifTemp::findOne($notifTempId)) !== null)
            return $temp;
        else
            throw new NotFoundHttpException(Yii::t('app', 'Notification template does not exist.'));

    }

    public static function getFavLang($receiver_id, $receiver_type)
    {
        $user = User::find();
        switch ($receiver_type) {
            case 'user':
            case 'owner':
            case 'renter':
                $user->where(['id' => $receiver_id]);
                break;
            case 'admin':
                $user->where(['user_type' => 'admin']);
                break;
            case 'estate_officer':
                $office = EstateOffice::findOne($receiver_id);
                $user->where(['id' => $office->admin->id]);
                break;
            case 'maintenance_officer':
                $office = MaintenanceOffice::findOne($receiver_id);
                $user->where(['id' => $office->admin->id]);
                break;
            default:
                $user->where(['user_type' => 'developer']);
                break;
        }
        if (isset($user->one()->fav_lang))
            return $user->one()->fav_lang;
        else
            return 'ar';

    }

    public static function getMaplist()
    {

        $settingMap = Setting::find(1)->Select(['lat', 'lng', 'site_name', 'site_name_en'])->One();

        $projectMap = Project::find()->where(['view_in_map' => 1, 'status' => 1])->all();

        return ['settingMap' => $settingMap, 'projectMap' => $projectMap];

    }

    public static function formatDate($value)
    {
        $today = date_create()->setTime(0, 0, 0);
        $date = date_create($value)->setTime(0, 0, 0);
        if ($today == $date) {
            $label = 'Today';
        } elseif ($today->getTimestamp() - $date->getTimestamp() == 24 * 60 * 60) {
            $label = 'Yesterday';
        } elseif ($today->format('W') == $date->format('W') && $today->format('Y') == $date->format('Y')) {
            $label = \Yii::$app->formatter->asDate($value, 'php:l');
        } elseif ($today->format('Y') == $date->format('Y')) {
            $label = \Yii::$app->formatter->asDate($value, 'php:d F');
        } else {
            $label = \Yii::$app->formatter->asDate($value, 'medium');
        }
        $formatted = \Yii::$app->formatter->asTime($value, 'short');
        return [$label, $formatted];
    }

    /*
$arr = array('s'=>'Second','i'=>'Minute','h'=>'Hour','d'=>'Day','w'=>'Week','m'=>'Month','y'=>'Year',       );
$retArr = getElapsedTime(mkTime(0,0,0,'2','1','2013'));
echo $retArr[1].' '.$arr[$retArr[0]];
function getElapsedTime ($t){
    $timeDiff = time()-$t;
    if($timeDiff < 60){
        $arr[0] = 's';
        $arr[1] = $timeDiff;
    }else if(($temp=(int)($timeDiff/60)) < 60){
        $arr[0] = 'i';
        $arr[1] = $temp;
    }else if(($temp=(int)($timeDiff/(60*60))) < 24){
        $arr[0] = 'h';
        $arr[1] = $temp;
    }else if(($temp=(int)($timeDiff/(60*60*24))) < 7){
        $arr[0] = 'd';
        $arr[1] = $temp;
    }else if(($temp=(int)($timeDiff/(60*60*24*7))) < 4){
        $arr[0] = 'w';
        $arr[1] = $temp;
    }else if(($temp=(int)($timeDiff/(60*60*24*7*4))) < 12){
        $arr[0] = 'm';
        $arr[1] = $temp;
    }else{
        $arr[0] = 'y';
        $arr[1] = $temp;
    }
    return $arr;
}
*/


    public static function setImages($model, $folder = 'attachment', $field = 'imageFiles', $inputName = null)
    {

        $model->$field = UploadedFile::getInstances($model, $field);
        if ($inputName) {
            $model->$field = UploadedFile::getInstancesByName($inputName);
        }

        $newName = Yii::$app->security->generateRandomString();
        if (!empty($model->$field)) {
            if ($model->validate()) {
                $files = $model->$field;
                // file is uploaded successfully
                $jj = 1;
                foreach ($files as $imageFile) {
                    //print_r($imageFile);die;
                    $modelImage = new Attachment();
                    $name = basename($imageFile, "." . $imageFile->extension);
                    $fileName = $newName . $jj . '.' . $imageFile->extension;
                    $modelImage->title = $name;
                    $modelImage->file = $fileName;
                    $modelImage->item_id = $model->id;
                    $modelImage->item_type = $model->tableName();
                    $modelImage->type = $imageFile->type;
                    $modelImage->size = $imageFile->size;


                    $modelImage->save();

                    $imageFile->saveAs(Yii::getAlias("@upload/$folder/{$fileName}"));

                    $jj++;
                }
            }
        }

    }


    public static function setImagesWithWatemark($model, $folder = 'attachment', $field = 'imageFiles', $inputName = null)
    {

        $model->$field = UploadedFile::getInstances($model, $field);
        if ($inputName) {
            $model->$field = UploadedFile::getInstancesByName($inputName);
        }

        $newName = Yii::$app->security->generateRandomString();
        if (!empty($model->$field)) {
            if ($model->validate()) {
                $files = $model->$field;
                // file is uploaded successfully
                $jj = 1;
                foreach ($files as $imageFile) {
                    //print_r($imageFile);die;
                    $modelImage = new Attachment();
                    $name = basename($imageFile, "." . $imageFile->extension);
                    $fileName = $newName . $jj . '.' . $imageFile->extension;
                    $modelImage->title = $name;
                    $modelImage->file = $fileName;
                    $modelImage->item_id = $model->id;
                    $modelImage->item_type = $model->tableName();
                    $modelImage->type = $imageFile->type;
                    $modelImage->size = $imageFile->size;

                    $modelImage->save();

                    // watemark
                    $image = Image::open($imageFile->tempName);
                    $watermark = Image::open(Yii::getAlias("@upload/watermark.png"));
                    $watermark->resize((int)$image->width() / 7, (int)$image->height() / 7, 'transparent', true);

//                    $image->merge($watermark, $image->width() / 1.5, $image->height() / 1.5, $image->width() / 10, $image->height() / 10);
                    $image->save(Yii::getAlias("@upload/$folder/{$fileName}"), $imageFile->extension);

                    $jj++;
                    // $watermark->scaleResize($image->width(),$image->height(),null,null,10);
                    // $watermark->resize((int)$size,(int)$size);

                    // $url = yii::$app->uploadUrl->baseUrl.'/'.$folder.'/'.$fileName;// print_r("<img src='".$url."'>");// die();
                }
            }
        }

    }

    public static function updateImages($model, $folder = 'attachment')
    {
        $arrImages = $arrImages2 = [];
        // $types = ['image'=>'image','application'=>'pdf','application'=>'vnd.openxmlformats-officedocument.wordprocessingml.document','application'=>'msword'];
        $types = ['image' => 'image', 'application' => ['pdf', 'vnd.openxmlformats-officedocument.wordprocessingml.document', 'msword']];
        //$keys = array_key_exists

        foreach ($model->attachments as $value) {
            $url = Yii::$app->uploadUrl->baseUrl . "/$folder/" . $value->file;
            $ex = explode('/', $value->type);
            $type = '';
            if (array_key_exists($ex[0], $types)) {
                if (is_array($types[$ex[0]]) && (in_array($ex[1], $types[$ex[0]]))) {
                    $type = $ex[0] . '/' . $types[$ex[0]][array_search($ex[1], $types[$ex[0]])];

                } else {
                    $type = $types[$ex[0]];

                }
            } else
                $type = 'other';

            $arrImages[] = $url;
            $arrImages2[] = [
                'caption' => $value->title,
                'downloadUrl' => $url,
                'key' => $value->id,
                'filetype' => $value->type,
                'size' => $value->size,
                'type' => $type,
                'url' => Url::to(['attachment/delete-file', 'id' => $value->id]),
                //'extra' => ['id'=> $value->id]
            ];
        }
        $model->imageFiles = $arrImages;

        return $arrImages2;

    }


    /*
    if model have 2 type image used $attribute for name column

       If you want to delete the entire row in which the file is located, 
       write anything in $deleteRow

    */

    public static function deleteImages($class, $id, $attribute = "file", $deleteRow = '')
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (isset($id)) {

            if (($model = $class::findOne($id)) !== null) {
                $filepath = Yii::getAlias("@upload/" . $class::tableName() . "/") . $model->$attribute;

                if (file_exists($filepath)) {
                    unlink($filepath);
                }
                if ($deleteRow) {
                    $model->delete();
                } else {
                    $model->$attribute = '';
                    $model->save(false);
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public static function deleteImagesByPostId($class, $id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (isset($id)) {

            if (($model = Attachment::find()->where(['item_id' => $id, 'item_type' => $class::tableName()])->select(['file'])->asArray()->all()) !== null) {
                foreach ($model as $row) {
                    $filepath = Yii::getAlias("@upload/" . Attachment::tableName() . "/") . $row['file'];

                    if (file_exists($filepath)) {
                        unlink($filepath);
                    }
                    // print_r(unlink($filepath));
                    // die();
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    /*
    * change the balance of contract or sms
    */
    public static function balanceChange($model, $operation = 'add', $flag = false)
    {
        if (($estateOffice = EstateOffice::findOne($model->estate_office_id)) !== null) {
            if ($model::tableName() == 'balance_contract') {
                $estateOffice->contract_balance = ($operation == 'add') ? $estateOffice->contract_balance + $model->amount : $estateOffice->contract_balance - $model->amount;
                if ($flag)
                    $estateOffice->expire_date = $model->expire_date;
                $estateOffice->contract_expire_date = $model->expire_date;
            } elseif ($model::tableName() == 'balance_sms')
                $estateOffice->sms_balance = ($operation == 'add') ? $estateOffice->sms_balance + $model->amount : $estateOffice->sms_balance - $model->amount;
            $estateOffice->sms_expire_date = $model->expire_date;

            $estateOffice->save(false);
        }

    }

    /*
    *
    */
    public static function getEstateOfficeId()
    {
        $session = Yii::$app->session;
        // return 1 ;
        if (!isset($session['estate_office_id']) && isset(Yii::$app->user->identity->id)) {
            $user_estate = \common\models\UserEstateOffice::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
            $session = Yii::$app->session;
            if ($user_estate !== null) {
                $session['estate_office_id'] = $user_estate->estate_office_id;
            } else {
                $session['estate_office_id'] = null;
            }
        }

        return $session['estate_office_id'];

    }

    public static function getMaintenanceOfficeId()
    {
        $session = Yii::$app->session;
        // return 5 ;

        if (!isset($session['maintenance_office_id']) && isset(Yii::$app->user->identity->id)) {
            $user_maintenance = \common\models\UserMaintenanceOffice::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
            $session = Yii::$app->session;
            if ($user_maintenance !== null) {
                $session['maintenance_office_id'] = $user_maintenance->maintenance_office_id;
            } else {
                $session['maintenance_office_id'] = null;
            }
        }

        return $session['maintenance_office_id'];

    }


    public static function testActiveEstateOffice()
    {
        $estate_office_id = GeneralHelpers::getEstateOfficeId();

        // check Office
        if (($estateOffice = EstateOffice::findOne($estate_office_id)) !== null) {
            //check balance Contract && check Expire date office
            if ($estateOffice->checkAvalibalBalance('email') > 0 && strtotime($estateOffice->expire_date) > time()) {
                return true;
            }


        }
        return false;
    }

    public static function checkAvalibalBalance($type = 'email')
    {
        $estate_office_id = GeneralHelpers::getEstateOfficeId();

        // check Office
        if (($estateOffice = EstateOffice::findOne($estate_office_id)) !== null) {
            //check balance Contract && check Expire date office
            if ($estateOffice->checkAvalibalBalance($type) > 0 && strtotime($estateOffice->expire_date) > time()) {
                return true;
            }


        }
        return false;
    }

    public static function getAvailableBalance($type = 'email')
    {
        $estate_office_id = GeneralHelpers::getEstateOfficeId();

        // check Office
        if (($estateOffice = EstateOffice::findOne($estate_office_id)) !== null) {
            //check balance Contract && check Expire date office
            return $estateOffice->getAvailableBalance($type);
        }

        return false;
    }

    public static function checkIfOfficeOnTrialPlan($type = 'email')
    {
// Fetch the estate_office_id from the Plan model
        $lastPlan = Order::find()
            ->where(['admin_id' => Yii::$app->user->identity]) // Assuming $userId contains the ID for the condition
            ->orderBy(['id' => SORT_DESC]) // Order by 'id' in descending order
            ->one()?->plan; // Fetch only one record

        return (bool)$lastPlan?->price == 0;
    }


    public static function getAvailablePaymentMethod()
    {
        $setting = yii::$app->SiteSetting->info();
        $PayMethod = [
            Setting::INSTALLMENT_CASH => 'enable_installment_cash',
            Setting::INSTALLMENT_DEPOSIT_BANK => 'enable_installment_deposit_bank',
            Setting::STATUS_PAY_CARD => 'enable_installment_pay_card',
            Setting::STATUS_NETWORK => 'enable_installment_network'
        ];
        // $list = [];
        foreach ($PayMethod as $key => $value) {
            if ($setting->{$value} == 0) {
                unset($PayMethod[$key]);
            }
        }
        return $PayMethod;
    }


    public static function translateParams($param)
    {
        if (is_array($param)) {
            array_walk($param, function (&$value) {
                $value = \Yii::t("app", $value);
            });
            return $param;
        } else {
            return \Yii::t("app", $param);
        }
    }

    public static function listUserAndOfficeByCurrent($wanted)
    {
        $sender_type = \common\models\Chat::getInfoUser();
        $droptions = [];
        switch ($wanted) {
            case 'admin':
                $droptions = [['id' => 0, 'name' => yii::$app->SiteSetting->info()->_site_name, 'mobile' => yii::$app->SiteSetting->info()->mobile]];
                break;
            case 'owner': // view for :'admin','estate_officer','renter'
                $query = User::find()->where(['or', ['user_type' => 'owner'], ['owner' => 1]]);

                if ($sender_type['userType'] === 'estate_officer')
                    $droptions = EstateOffice::listOwner();
                elseif ($sender_type['userType'] === 'renter')
                    $droptions = $query->leftJoin('contract', 'user.id = contract.owner_id')->andWhere(['contract.renter_id' => $sender_type['userId']])->asArray()->all();
                else
                    $droptions = $query->asArray()->all();
                break;
            case 'renter':// view for 'admin','estate_officer','owner'
                $query = User::find()->where(['or', ['user_type' => 'renter'], ['renter' => 1]]);

                if ($sender_type['userType'] === 'estate_officer')
                    $droptions = $query->leftJoin('estate_office_renter as e', 'user.id = e.renter_id')->andWhere(['e.estate_office_id' => $sender_type['userId']])->asArray()->all();
                elseif ($sender_type['userType'] === 'owner')
                    $droptions = $query->leftJoin('contract', 'user.id = contract.renter_id')->andWhere(['contract.owner_id' => $sender_type['userId']])->asArray()->all();
                else // for admin
                    $droptions = $query->asArray()->all();
                break;
            case 'estate_officer': // view for 'admin','renter','owner'
                $query = EstateOffice::find();

                if ($sender_type['userType'] === 'owner')
                    $droptions = $query->leftJoin('estate_office_owner as eo', 'estate_office.id = eo.estate_office_id')->andWhere(['eo.owner_id' => $sender_type['userId']])->asArray()->all();
                elseif ($sender_type['userType'] === 'renter')
                    $droptions = $query->leftJoin('estate_office_renter as er', 'estate_office.id = er.estate_office_id')->andWhere(['er.renter_id' => $sender_type['userId']])->asArray()->all();
                elseif ($sender_type['userType'] === 'estate_officer')
                    $droptions = $query->leftJoin('user as admin', 'estate_office.admin_id = admin.id')
                        ->andWhere(['not', ['or', ['user_type' => 'owner_estate_officer'], ['owner_estate_officer' => 1]]])
                        ->asArray()->all();
                else
                    $droptions = $query->asArray()->all();
                break;
            case 'maintenance_officer':
                $droptions = MaintenanceOffice::find()->asArray()->all();
                break;

            default:
                # code...
                break;
        }

        return $droptions;
    }


    public static function urlMyOffer()
    {
        $estate_office_id = self::getEstateOfficeId();
        return yii::$app->BaseUrl->baseUrl . '/gallery?office_id=' . $estate_office_id;
    }

    public static function taxes($amount)
    {
        return number_format(((float)$amount * 15) / 100, 2, '.', '');
    }

    public static function currency($amount, $currency = 1)
    {
        return number_format($amount, 2) . ' ' . Yii::$app->params['currency'][Yii::$app->language][$currency];
    }
}