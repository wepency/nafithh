<?php
namespace common\behaviors;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;
use common\models\ConvertNumToText;

class ConvertNumToTextBehavior extends AttributeBehavior
{
    public $numberAttribute;
    public $textNumberAttribute;

    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'convert',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'convert',

        ];
    }

    /*
    *
    */
    public function convert()
    {
        if (!($this->owner->hasAttribute($this->numberAttribute))) {
                throw new \InvalidArgumentException("You should add attribute ".$this->numberAttribute);
        }

        if (!($this->owner->hasAttribute($this->textNumberAttribute))) {
            throw new \InvalidArgumentException("You should add attribute ".$this->textNumberAttribute);
        }

        $ar_number= new ConvertNumToText($this->owner->{$this->numberAttribute}, "male");
        $this->owner->{$this->textNumberAttribute} =  $ar_number->convert_number(). ' ريال سعودي فقط لا غير';
    }
    
}