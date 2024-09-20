<?php
namespace common\behaviors;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class UploadImagesBehavior extends AttributeBehavior
{   

    // class of model related 
    public $classTableRelated;
    // for files attachement or images
    public $files; 
    /**
     * column used in relations, usually it is pk column
     * used as fallback when 'pkColumnName' not specified in corresponding relation config
     * pk model field will be used as fallback value
     * @var string
     */
    public $pkColumnName;
     /**
     * foreign key column name of the related entity
     * used as fallback when 'foreignKeyColumnName' not specified in corresponding relation config
     * @var string
     */
    public $foreignKeyColumnName = 'external_id';
    /**
     column name in who the file will be saved
     *
     * @var string
     */
     
    public $fileAttribute = 'file';
    /**
     If the sub-model has a relationship
     *
     * that used to distinguish polymorphic behavior
     * used as fallback when 'typeColumnName' not specified in corresponding relation config
     * @var string
     */
    public $typeColumnName ;

    
    public $fileAttribute_bak = '';
    public $saveDir = '../../uploads/';
    public $moreDetail = false;

    public function init()
    {
        parent::init();
        if (!isset($files)) {
            return '';
        }
        if (!isset($classTableRelated)) {
            return '';
            throw new \InvalidArgumentException("You should specify class relation");
        }

        foreach(['foreignKeyColumnName', 'pkColumnName', 'fileAttribute','saveDir'] as $optionName) {
            $optionValue = isset($optionName) ? $optionName : $this->{$optionName};
            if (!$optionValue) {
                throw new \InvalidArgumentException("You should specify required option '{$optionName}' either
                 per relation or behavior configuration.'");
            }
        }
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_VALIDATE => 'addFiles',
            ActiveRecord::EVENT_BEFORE_DELETE => 'deleteFiles',
            ActiveRecord::EVENT_AFTER_FIND => 'getFile',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'setOrginalvalue',
            ActiveRecord::EVENT_AFTER_UPDATE => 'getFile',
        ];
    }

    /*
    *
    */
    public function addFiles()
    {
        //print $this->fileAttribute;print $this->saveDir;die();
        if($fileAttribute){
            foreach ($files as $key) {
                $this->fileAttribute = $key;
                $file = UploadedFile::getInstance($classTableRelated, $this->fileAttribute);
                if (!empty($file)) {
                    $newName = Yii::$app->security->generateRandomString() . '.' . $file->extension;
                    if ($file->saveAs($this->saveDir . $newName)) {

                        // To delete the previos attachment during updates record..
                        if ($this->fileAttribute_bak !=''){
                          $this->deleteFiles();
                          $this->fileAttribute_bak = '';
                        }
                       
                           
                        $classTableRelated->{$this->fileAttribute} = $newName.$jj;
                       
                        
                        // for the others fields in table marteial
                        if ($this->moreDetail){
                            $classTableRelated->filemime = $file->type;
                            $classTableRelated->filesize = $file->size;
                        }
                    }
                }
            }
        }
    }

    /*
    *
    */
    public function deleteFiles()
    {
        $filepath = $this->getFilepath();
        if (file_exists($filepath)) {
            unlink($filepath);
        }
    }
    
    /*
    *
    */
    public function getFile()
    {
        $action_name = Yii::$app->controller->action->id;
        if (!empty($classTableRelated->{$this->fileAttribute}) && $action_name!="delete-file"){
            $this->fileAttribute_bak = $classTableRelated->{$this->fileAttribute};
            $classTableRelated->{$this->fileAttribute} = Yii::$app->uploadUrl->baseUrl."/".$classTableRelated->tableName()."/".$classTableRelated->{$this->fileAttribute};
            return $classTableRelated->{$this->fileAttribute};
        }
    }

    /*
    *
    */
    public function getFilepath()
    {
        if (!empty($classTableRelated->{$this->fileAttribute})){
            return $this->saveDir.$this->fileAttribute_bak;
        }else{
            return '';
        }
    }
    /*
    *
    */
    public function setOrginalvalue()
    {
        if ($this->fileAttribute_bak!=''){
            return $classTableRelated->{$this->fileAttribute} = $this->fileAttribute_bak;
        }
    }


    
}