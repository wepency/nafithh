<?php
namespace common\components;
 
use yii\base\Widget;

class HousingUnitWidget extends Widget
{
   
   public $model;
   public $form;
   
    public function init()
    {
        parent::init();
    }
    
    public function run()
    {
        return $this->render('HousingUnitWidget',['modelsHousings'=>$this->model,'form'=>$this->form]);
    }
}
