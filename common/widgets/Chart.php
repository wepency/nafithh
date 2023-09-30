<?php
namespace common\widgets;

use Yii;
use yii\helpers\StringHelper; 
use yii\base\InvalidConfigException;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class Chart extends \yii\bootstrap\Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - key: the name of the session flash variable
     * - value: the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public static $color = [0=>'#f56954','#00a65a','#f39c12','#00c0ef','#3c8dbc','#d2d6de','#42d4f4','#f032e6','#bfef45','#fabebe','#469990','#e6beff','#9A6324','#fffac8','#800000','#aaffc3','#3cb44b'];
    
    /**
     * {@inheritdoc}
     */
    public static  function card($option)
    {
        // print_r($option); die();
        $label= (isset($option['label']))? $option['label'] : yii::t('app',"number");
        $content = (isset($option['content']))? $option['content'] :0;
        $url = (isset($option['url']))? $option['url'] :"#";
        $icon = (isset($option['icon']))? $option['icon'] :"fa fa-area-chart";
        $color = (isset($option['color']))? $option['color'] :"bg-aqua";
        $code = <<< HTML
            <div class="small-box  $color ">
                <div class="inner">
                    <h3> $content </h3>
                    <p>$label</p>
                </div>
                <div class="icon">
                    <i class="$icon"></i>
                </div>
                <a href=" $url" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>

        HTML;
         echo $code ;      
    }

    public static  function boxList($option)
    {
        // print_r($option); die();
        $label= (isset($option['label']))? $option['label'] : yii::t('app',"number");
        $content = (isset($option['content']))? $option['content'] :array();
        $contentTitle = (isset($option['contentTitle']))? $option['contentTitle'] :null;
        $contentText = (isset($option['contentText']))? $option['contentText'] :null;
        $contentAdd = (isset($option['contentAdd']))? $option['contentAdd'] :'';
        $contentImage = (isset($option['contentImage']))? $option['contentImage'] :'';

        $url = (isset($option['url']))? $option['url'] :"#";
        $urlAll = (isset($option['urlAll']))? $option['urlAll'] :"#";
        $icon = (isset($option['icon']))? $option['icon'] :"fa fa-area-chart";
        // if(!$contentTitle || !$contentText )
        //     return '';
        $code = <<< HTML
            <div class="row">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">$label</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="products-list product-list-in-box">
        HTML;
                   foreach ($content as $item) {
                    $title = $item->{$contentTitle};
                    $image =Yii::$app->uploadUrl->baseUrl."/user/default.png";
                    $text = yii::t('app',StringHelper::truncateWords(strip_tags($item->$contentText),15));
                        $code .= <<< HTML
                            <li class="item">
                                <div class="product-img">
                                  <img src="$image" alt="Product Image">
                                </div>
                                <div class="product-info">
                                    <a href="$url/$item->id" class="product-title">
                                        $title
                                        <span class="product-description">
                                            $contentAdd $text
                                        </span>
                                    </a>
                                    </div>
                                </li>
                         HTML;
                    };
        $code .= <<< HTML
            </ul>
                </div>
                    <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="$urlAll" class="uppercase">Show All</a>
                </div>
                    <!-- /.box-footer -->
            </div>
        </div>
        HTML;                
         echo $code ;      
    }


    public static  function pieChart($option)
    {
        // print_r($option); die();
        $label= (isset($option['label']))? $option['label'] : yii::t('app',"number");
        $url = (isset($option['url']))? $option['url'] :"#";
        $divId = (isset($option['divId']))? $option['divId'] :'pieChart';
        $content = (array) $option['content'];
        $contentLable = (array) $option['contentLable'];
        if(!(is_array($content) && is_array($contentLable)) )
            throw new InvalidConfigException('Invalid layout type:  $content');

        // if(!(is_array($contentLable) && isset($contentLable[0]) && isset($contentLable[1])) )
        //     throw new InvalidConfigException('Invalid layout type:  $contentLable');

        // html code
        $code = <<< HTML
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">$label</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <canvas id="$divId"  width="767" height="390">
                    </canvas>
                </div>
            </div>
        HTML;
        echo $code;

        // js code
        $data ='';
        $i = 1 ;
        foreach ($content as $item ){
            $id = array_values($item)[0];
            $count = array_values($item)[1];
            $color = self::$color;
            $label2 = $contentLable[$id]?? '...';
            // print_r($Lable); die();
            // print_r($content); die();
            $data .= "{
                value    : '$count',
                color    : '$color[$i]',
                highlight: '$color[$i]',
                label    : '$label2'
              
              }," ; 
            $i = ($i >= 16)? 1 : ++$i;
        }
        $view = Yii::$app->getView();
        $view->registerJsFile(
            '@web/../vendor/bower-asset/adminlte/plugins/jQuery/jquery-2.2.3.min.js',
           ['position' => \yii\web\View::POS_READY]
        );
        $view->registerJsFile(
            '@web/../vendor/bower-asset/adminlte/bootstrap/js/bootstrap.min.js',
           ['position' => \yii\web\View::POS_READY]
        );
        $view->registerJsFile(
            '@web/../vendor/bower-asset/adminlte/plugins/chartjs/Chart.min.js',
           ['position' => \yii\web\View::POS_END]
        );

        // ActiveFormAsset::register($view);
        $js = 'var pieChart = new Chart(jQuery("#' . $divId.'").get(0).getContext("2d"));';
        $js .= 'var PieData = ['. $data .'];';
        $js .= 'var pieOptions= {responsive : true,
            onAnimationComplete: function()
            {this.showTooltip(this.segments, true);},
            tooltipEvents: [],
        };';
        $js .= 'pieChart.Doughnut(PieData, pieOptions);';
        $view->registerJs($js);
    }

    public static  function barChart($option)
    {
        // print_r($option); die();
        $list1['label'] = (isset($option['list1']['label']))? $option['list1']['label'] : yii::t('app',"number");
        $list1['data'] = (isset($option['list1']['data']))? $option['list1']['data'] :array();
        $list2['label'] = (isset($option['list2']['label']))? $option['list2']['label'] : yii::t('app',"number");
        $list2['data'] = (isset($option['list2']['data']))? $option['list2']['data'] : array();
        $values = (isset($option['values']))? $option['values'] :array();

        $label= (isset($option['label']))? $option['label'] : yii::t('app',"number");
        $url = (isset($option['url']))? $option['url'] :"#";

        $divId = (isset($option['divId']))? $option['divId'] :'barChart';

        $code = <<< HTML
            <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">$label</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="chart">
                    <canvas id="$divId" style="height:330px"></canvas>
                  </div>
                </div>
            <!-- /.box-body -->
            </div>
        HTML;
        echo $code;

        // js code
        
        $view = Yii::$app->getView();
        $view->registerJsFile(
            '@web/../vendor/bower-asset/adminlte/plugins/jQuery/jquery-2.2.3.min.js',
           ['position' => \yii\web\View::POS_READY]
        );
        $view->registerJsFile(
            '@web/../vendor/bower-asset/adminlte/bootstrap/js/bootstrap.min.js',
           ['position' => \yii\web\View::POS_READY]
        );
        $view->registerJsFile(
            '@web/../vendor/bower-asset/adminlte/plugins/chartjs/Chart.min.js',
           ['position' => \yii\web\View::POS_END]
        );

        // ActiveFormAsset::register($view);
        $js = 'var areaChartData = {
              labels: [';
        foreach ($values as $value) {
            $js .= "'$value',";
        }
        $js .= '],
              datasets: [
                {
                  label: "'.$list1["label"].'",
                  fillColor: "rgba(210, 214, 222, 1)",
                  strokeColor: "rgba(210, 214, 222, 1)",
                  pointColor: "rgba(210, 214, 222, 1)",
                  pointStrokeColor: "#c1c7d1",
                  pointHighlightFill: "#fff",
                  pointHighlightStroke: "rgba(220,220,220,1)",
                  data: ['.$list1["data"].']
                },
                {
                  label: "'.$list2["label"].'",
                  fillColor: "rgba(60,141,188,0.9)",
                  strokeColor: "rgba(60,141,188,0.8)",
                  pointColor: "#3b8bba",
                  pointStrokeColor: "rgba(60,141,188,1)",
                  pointHighlightFill: "#fff",
                  pointHighlightStroke: "rgba(60,141,188,1)",
                  data: ['.$list2["data"].']
                }
              ]
            };

            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $("#' . $divId.'").get(0).getContext("2d");
            var barChart = new Chart(barChartCanvas);
            var barChartData = areaChartData;
            barChartData.datasets[1].fillColor = "#00a65a";
            barChartData.datasets[1].strokeColor = "#00a65a";
            barChartData.datasets[1].pointColor = "#00a65a";
            var barChartOptions = {
              //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
              scaleBeginAtZero: true,
              //Boolean - Whether grid lines are shown across the chart
              scaleShowGridLines: true,
              //String - Colour of the grid lines
              scaleGridLineColor: "rgba(0,0,0,.05)",
              //Number - Width of the grid lines
              scaleGridLineWidth: 1,
              //Boolean - Whether to show horizontal lines (except X axis)
              scaleShowHorizontalLines: true,
              //Boolean - Whether to show vertical lines (except Y axis)
              scaleShowVerticalLines: true,
              //Boolean - If there is a stroke on each bar
              barShowStroke: true,
              //Number - Pixel width of the bar stroke
              barStrokeWidth: 2,
              //Number - Spacing between each of the X value sets
              barValueSpacing: 5,
              //Number - Spacing between data sets within X values
              barDatasetSpacing: 1,
              //String - A legend template
              legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
              //Boolean - whether to make the chart responsive
              responsive: true,
              maintainAspectRatio: true
            };

            barChartOptions.datasetFill = false;
            barChart.Bar(barChartData, barChartOptions);';
        $view->registerJs($js);
    }

    
}
