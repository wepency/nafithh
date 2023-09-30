<?php
namespace backend\controllers;

use common\components\GeneralHelpers;
use common\models\EstateOffice;
use common\models\FormBase;
use Da\QrCode\QrCode;
use kartik\mpdf\Pdf;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;


class ExportController extends Controller
{


    private $PlanWidget;
    private $html;

    public function actionDownload($destination = Pdf::DEST_BROWSER)
    {

        $currentUser = \common\models\Chat::getInfoUser();
        if ($currentUser['userType'] == 'estate_officer') {
            $office = EstateOffice::findOne($currentUser['userId']);
            $this->setContent($office);
        }


        $css = "
        *,body{
            font-family: 'DinNextRegular';
        }
        *,body,p,h2,a,h4 {text-align: center !important;font-size:20px;}";

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => 'UTF-8',
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => $destination,
            'defaultFont' => 'DinNextRegular',
            // 'destination' => Pdf::DEST_DOWNLOAD, 
            // 'destination' => Pdf::DEST_BROWSER, 

            'cssFile' => ['@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css'],
            'cssInline' => $css,
            // 'destination' => Pdf::DEST_FILE, 
            // 'marginTop' => 2, 
            // 'marginBottom' => 2, 
            // 'marginHeader' => 2, 
            // 'marginFooter' => 2, 
            // 'marginLeft' => 2, 
            // 'marginRight' => 2, 
            // your html content input
            'content' => $this->html,
            // 'filename' => $title.".pdf",  

            //  // set mPDF properties on the fly
            // 'options' => ['title' => $title],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => '',
                'SetFooter' => '',
                // 'SetFooter'=>['{PAGENO}'],
            ]
            // 'methods' => [
            //         'SetHeader'=>$header, 
            //         'SetFooter'=>$footer,
            //     ]
        ]);

        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $filePath = yii::getAlias("@webroot/../css");

        $pdf->options = array_merge($pdf->options, [
            'autoScriptToLang' => true,  // make sure you refer the right physical path
            // 'autoLangToFont' => true,  // make sure you refer the right physical path
            'fontDir' => array_merge($fontDirs, [$filePath . "/fonts/din-next"]),  // make sure you refer the right physical path
            'fontdata' => array_merge($fontData, [
                'dinnextregular' => [
                    'R' => '/regular/DinNextRegular.ttf',
                    'B' => '/bold/DinNextBold.ttf',
                    'BI' => '/medium/DinNextMedium.ttf',
                    'I' => '/light/DinNextLight.ttf',
                    'useOTL' => 0xFF,
                    'useKashida' => 75,
                ]
            ])
        ]);

        // print_r($pdf->getApi()->fontdata); die();

        return $pdf->render();

    }

    public function setContent($office)
    {
        $urlSite = yii::$app->BaseUrl->baseUrl;
        // $this->html .= $this->renderMainTitle(yii::t('app','Office').'<span> (('.$office->name.'))</span>');
        // $this->html .= $this->renderMainTitle(yii::t('app','Office'));
        $this->html .= $this->renderMainTitle('<span> ((' . $office->name . '))</span>');
        $this->html .= $this->renderMainTitle(yii::t('app', 'Offers Available'));
        $this->html .= "<br><br>";
        $this->html .= "<br><br>";
        $this->html .= '<div class="container">';
        $this->html .= '<div class="row">';
        $this->html .= '<div class="col-xs-7 col-sm-7 ">';
        $this->html .= $this->setQrImage();
        $this->html .= '</div>';
        $this->html .= '<div class="col-xs-3 col-sm-3">';
        $this->html .= '<br><br><br><br><br><br><br>';
        $this->html .= $this->renderSubTitle(yii::t('app', 'Scan here to view offers'));
        $this->html .= '</div>';
        $this->html .= '</div>';
        $this->html .= '</div>';
        $this->html .= '<br>';
        $urlOffer = GeneralHelpers::urlMyOffer();
        $this->html .= $this->renderDescribe(Html::a($urlOffer, $urlOffer));
        $this->html .= '<br>';
        $this->html .= '<br>';
        $this->html .= '<br>';
        $this->html .= $this->renderSubTitle(yii::$app->SiteSetting->siteName());
        $this->html .= $this->renderSubTitle(yii::t('app', 'Your view of the real estate world'));
        $this->html .= '<br>';
        $this->html .= Html::a($urlSite, $urlSite);
    }


    public function setQrImage()
    {
        $urlOffer = GeneralHelpers::urlMyOffer();
        $qrCode = (new QrCode($urlOffer))
            ->setSize(500)
            // ->setSize(250)
            ->setMargin(5)
            // ->useForegroundColor(51, 153, 255);
            ->useForegroundColor(198, 165, 62);
        $img = $qrCode->writeDataUri();
        // echo $qrCode->writeString();
        $this->html .= Html::img($img, ['width' => '100%']);
    }


    public function renderMainTitle($title)
    {
        return Html::tag('h2', Html::tag('center', $title));
    }

    public function renderSubTitle($title)
    {
        return Html::tag('h4', $title);
    }

    public function renderDescribe($content)
    {
        return Html::tag('p', $content);
    }


    // public function actionWatermarked($filePath = '')
    // {

    //     $filePath = yii::getAlias("@upload/attachment/RhaaQJf4zuJDFG2CiL6xHEsUiGzbpUh01.png");
    //     if($filePath){
    //         // $font = yii::getAlias("@frontend/assets/DinNextBold.ttf");
    //         // $foundName = "Nafithh";
    //         // $image= Image::open($filePath)
    //         //     ->write($font, $foundName, 152, 145, 15, 0, 0x1c5078, 'left');
    //         //     // ->write($font, $foundName, 152, 145, 15, 0, 'transparent', 'left');
    //         //     // echo $image->inline();
    //         //     // echo $image->jpeg();
    //         // // $img_src = yii::$app->BaseUrl->baseUrl.'/admin/'.$image->jpeg();
    //         // $img_src = $image->inline();
    //         // print_r('<img src="'.$img_src.'">'); die();


    //         // $image= Image::open($filePath);
    //             // ->write($font, $foundName, 152, 145, 15, 0, 0x1c5078, 'left');
    //         // print_r($image); die();


    //         $img = Image::open($filePath);
    //         $watermarkimage = yii::getAlias("@frontend/assets/image/watemarken.png");
    //         $watermark = Image::open($watermarkimage);
    //         // Opening vinci.png

    //         // Mergine vinci text into mona in the top-right corner
    //         $img->merge($watermark, $img->width()/1.5,
    //             $img->height()/1.5);
    //             // ->save('out.jpg', 'jpg');

    //             $img_src = $img->inline();
    //         print_r('<img src="'.$img_src.'">'); die();

    //         return 0 ;
    //     }
    // }


}

?>
