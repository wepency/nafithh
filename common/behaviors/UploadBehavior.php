<?php
namespace common\behaviors;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class UploadBehavior extends AttributeBehavior
{
    public $fileAttribute = 'file';
    public $fileAttribute_bak = '';
    public $saveDir = '../../uploads/';
    public $moreDetail = false;

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
        $file = UploadedFile::getInstance($this->owner, $this->fileAttribute);
        

        if (!empty($file)) {

            if(!is_dir($this->saveDir)){
                \yii\helpers\FileHelper::createDirectory($this->saveDir, $mode = 0775, $recursive = true);
            }
            
            $newName = Yii::$app->security->generateRandomString() . '.' . $file->extension;
            if ($file->saveAs($this->saveDir . $newName)) {

                $this->owner[$this->fileAttribute] = $newName;
                // To delete the previos attachment during updates record..
                
                if ($this->fileAttribute_bak !=''){
                  $this->deleteFiles();
                  $this->fileAttribute_bak = '';
                }

                // for the others fields in table marteial
                if ($this->moreDetail){
                    $this->owner->filemime = $file->type;
                    $this->owner->filesize = $file->size;
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
        $action_name = @Yii::$app->controller->action->id;
        if (!empty($this->owner[$this->fileAttribute]) && $action_name!="delete-file"){
            $this->fileAttribute_bak = $this->owner[$this->fileAttribute];
            $this->owner[$this->fileAttribute] = Yii::$app->uploadUrl->baseUrl."/".$this->owner->tableName()."/".$this->owner[$this->fileAttribute];
            return $this->owner[$this->fileAttribute];
        }
    }

    /*
    *
    */
    public function getFilepath()
    {
        if (!empty($this->owner[$this->fileAttribute])){
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
            return $this->owner[$this->fileAttribute] = $this->fileAttribute_bak;
        }
    }


    
}