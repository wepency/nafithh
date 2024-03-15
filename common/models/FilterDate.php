<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Link;
use yii\web\Linkable;

/**
 * ArrayableTrait provides a common implementation of the [[Arrayable]] interface.
 *
 * ArrayableTrait implements [[toArray()]] by respecting the field definitions as declared
 * in [[fields()]] and [[extraFields()]].
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
trait FilterDate
{
    public $startDate;
    public $endDate;

  //   public function rules()
  //   {
  //       return  array_merge(parent::rules(), 
  // [[['startDate','endDate'],'safe']]
  // );
  //       // return ['startDate','endDate'];
  //   }


    public function filterByDate(&$query,$filed = 'created_at')
    {
        $className = @array_keys(yii::$app->request->get())[0];

//        if(!class_exists($className)){
        if(!is_object($className) && $className !== null
            && class_exists($className)){
            $className = $this->formName();
        }
        
        $this->endDate = isset(yii::$app->request->get()[$className]['endDate'])? yii::$app->request->get()[$className]['endDate'] : '';
        $this->startDate = isset(yii::$app->request->get()[$className]['startDate'])? yii::$app->request->get()[$className]['startDate'] : '';
        
        $class = new $query->modelClass;
        
        $st = strpos($filed, "."); 
        $ss = substr($filed, ($st>0)?strpos($filed, ".")+1:0); 
        $type = $class->getTableSchema()->columns[$ss]->type;
        // print_r($type); die();
        if($type == 'timestamp' || $type == 'date' || $type == 'datetime'){
            $startDate = Yii::$app->formatter->asDate($this->startDate.' 00:00:00','php:Y-m-d H:i:s');
            $endDate = Yii::$app->formatter->asDate($this->endDate.' 23:59:59','php:Y-m-d H:i:s');
        }else{
            $startDate = Yii::$app->formatter->asTimestamp($this->startDate.' 00:00:00');
            $endDate = Yii::$app->formatter->asTimestamp($this->endDate.' 23:59:59');
        }

        if($this->startDate && $this->endDate){
            $query->andFilterWhere([ 'AND',
                                        ['>=', $filed, $startDate],
                                        ['<=', $filed, $endDate]
                                        
                                    ]);
        }elseif($this->startDate){
            $query->andFilterWhere(['>=', $filed, $startDate]);
        }elseif($this->endDate){
            $query->andFilterWhere(['<=', $filed, $endDate]);
        }else{
            '';
        }

    }
}
