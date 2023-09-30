<?php
namespace common\behaviors;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\helpers\Inflector;


 
 // HOW TO used basic 
    // class is requierd it is class relation
// 'uploadFilesBehavior' => [ 
//     'class' =>\common\behaviors\UploadFilesBehavior::class, 
//     'relationOptions' => [
//         'class' => Attachment::class,
//     ],
// ],

//  HOW TO used with all values , this default value
// 'uploadFilesBehavior' => [ 
//     'class' =>\common\behaviors\UploadFilesBehavior::class, 
//     'relationOptions' => [
//         'fileAttribute' => 'imageFiles', // DEFAULT  'imageFiles'
//         'configAttribute' => 'filesConfig', // DEFAULT  'filesConfig'
//         'class' => Attachment::class, //class relation
//         'moreAttributes' => ['title','type','size'], //column name from  relation table
//     ],
//     'pkColumnName' => 'id', // column used in relations, usually it is pk column
//     'foreignKeyColumnName' => 'item_id', //foreign key column name of the related entity
//     'typeColumnName' => 'item_type', // column name in the related entity model
//     'saveDir' => , dir for save the file , default is  Yii::getAlias("@upload/")+ relation table name;
// ],



class UploadFilesBehavior extends AttributeBehavior
{
    public $saveDir = '';
    public $validators ;
    public $moreDetail = false;
    public $setRule = true;
    public $foreignKeyColumnName = 'item_id';
    public $typeColumnName = 'item_type';
    public $pkColumnName = 'id';

    public $relationOptions;

    private $fileAttribute;
    private $configAttribute;

    private $rules = []; // added rules to $owner;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'addFiles',
            ActiveRecord::EVENT_BEFORE_INSERT => 'addFiles',
            ActiveRecord::EVENT_AFTER_FIND => 'getFiles',
            // ActiveRecord::EVENT_AFTER_UPDATE => 'getFiles',
            ActiveRecord::EVENT_AFTER_UPDATE => 'addFiles',
            ActiveRecord::EVENT_BEFORE_DELETE => 'deleteFiles',
            // ActiveRecord::EVENT_BEFORE_UPDATE => 'setOrginalvalue',
        ];
    }


    
    public function init()
    {
        parent::init();
        if (!isset($this->relationOptions['class'])) {
            throw new \InvalidArgumentException("You should specify related model class for '{$this->relationOptions['class']}' relation.'");
        }
        if (!isset($this->relationOptions['fileAttribute']) ) {
           throw new \InvalidArgumentException("You should specify required option 'fileAttribute' either
                 per relation or behavior configuration.'");
        }

        if (!isset($this->relationOptions['configAttribute']) ) {
           throw new \InvalidArgumentException("You should specify required option 'configAttribute' either
                 per relation or behavior configuration.'");
        }

        if (!$this->saveDir ) {
            $this->saveDir =Yii::getAlias("@upload/".$this->relationOptions['class']::tableName()."/");
        }

        foreach(['foreignKeyColumnName', 'pkColumnName', 'typeColumnName'] as $optionName) {
            if (!$this->{$optionName}) {
                throw new \InvalidArgumentException("You should specify required option '{$optionName}' either
                 per relation or behavior configuration.'");
            }
        }

        $this->rules = [
                [["".$this->relationOptions['fileAttribute'].""], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,txt, jpg, jpeg, gif, pdf, docx, xlsx','mimeTypes' => 'image/jpeg,image/jpg, image/png, image/gif,application/msword,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','maxFiles' => 10],
        ];
    }
    /*
    *
    */

    

    public function addFiles($event)
    {
        $files = UploadedFile::getInstances($this->owner, $this->relationOptions['fileAttribute']);
        if(empty($files)){
            $files = UploadedFile::getInstancesByName($this->relationOptions['fileAttribute']);
        }
        if (!empty($files)) {
           $this->owner[$this->relationOptions['fileAttribute']] = $files;
           if($event->name === 'beforeInsert'){
                if(!$this->owner->validate([$this->relationOptions['fileAttribute']])){
                    $event->isValid = false;
                }
                return ;
            }
            
            if(!is_dir($this->saveDir)){
                \yii\helpers\FileHelper::createDirectory($this->saveDir, $mode = 0775, $recursive = true);
            }
            $newName = Yii::$app->security->generateRandomString();
            $jj = 1;
            foreach($files as $file){
                $fileName = $newName. $jj . '.' . $file->extension;

                if($file->saveAs($this->saveDir . $fileName)){

                    $relationModal =   new $this->relationOptions['class'];
                    $relationModal->file = $fileName;
                    $relationModal[$this->foreignKeyColumnName] = $this->owner[$this->pkColumnName];
                    $relationModal[$this->typeColumnName] = $this->owner->tableName();

                    // added attributes
                    foreach ($this->relationOptions['moreAttributes'] as $key => $value) {

                       if ($relationModal->hasAttribute($value)) {
                            if( $value == 'title'){
                                $relationModal->$value = basename($file,".".$file->extension);
                            }else{
                                $relationModal->$value = isset($file->$value)? $file->$value : '';
                            }
                       }
                    }
                    $relationModal->save();
                }
                $jj++;
            }
        }
    }

    /*
    *
    */
    public function deleteFiles()
    {
        $files = $this->owner
            ->hasMany($this->relationOptions['class'], [$this->foreignKeyColumnName => $this->pkColumnName])
            ->andWhere([$this->typeColumnName => $this->owner->tableName()])->all();
        foreach($files as $file){
            $filepath = $this->saveDir.'/'.$file->file;
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            $file->delete();
        }
    }
    
    /*
    *
    */

    public function getFiles()
    {
        $types = ['image'=>'image','application'=>['pdf','vnd.openxmlformats-officedocument.wordprocessingml.document','msword']];
        $arrConfig =$arrFile = [];
        // $files = $this->owner
        //     ->hasMany($this->relationOptions['class'], [$this->foreignKeyColumnName => $this->pkColumnName])
        //     ->andWhere([$this->typeColumnName => $this->owner->tableName()]);
            // $files = $this->owner
            // ->hasMany($this->relationOptions['class'], [$this->foreignKeyColumnName => $this->pkColumnName])
            // ->andWhere([$this->typeColumnName => $this->owner->tableName()])->all();
        $files = $this->getQueryRelations()->all();
            // print_r($files->all()); die();
        foreach($files as $file){

            $url = Yii::$app->uploadUrl->baseUrl."/".$this->relationOptions['class']::tableName().
            "/".$file->file;
            $ex = explode('/',$file->type);
            $type = '';
            if (array_key_exists($ex[0],$types) ) {
                if(is_array($types[$ex[0]]) && (in_array($ex[1], $types[$ex[0]])) ){
                    $type = $ex[0].'/'.$types[$ex[0]][array_search($ex[1], $types[$ex[0]])];
                
                }else{
                    $type = $types[$ex[0]];

                }
            }else
                $type = 'other';

            $arrConfig[] = [
                'caption'=>$file->title,
                'downloadUrl'=>$url,
                'key'=>$file->id,
                'filetype'=>$file->type,
                'size'=>$file->size,
                'type'=>$type,
                'url'=> Url::to(['attachment/delete-file','id'=> $file->id]),
                            //'extra' => ['id'=> $value->id]
            ];
            
            $arrFile[] = $url;
        }
        $this->owner[$this->relationOptions['fileAttribute']] = $arrFile;
        $this->owner[$this->relationOptions['configAttribute']] = $arrConfig;
        $this->fileAttribute = $arrFile;
        $this->configAttribute = $arrConfig;
        // return $arrImages;
    }

    public function __get($name)
    {
        if($name == $this->relationOptions['fileAttribute']){
            return $this->fileAttribute;
        }

        if($name == $this->relationOptions['configAttribute']){
            return $this->configAttribute;
        }
    }


    public function canGetProperty($name, $checkVars = true)
    {
        return  ($name == $this->relationOptions['fileAttribute'] || $name == $this->relationOptions['configAttribute'] ) ? true : parent::canGetProperty($name, $checkVars);
    }

     public function hasMethod($name)
    {
        $name = Inflector::variablize(substr($name, 3));
        return $this->relationOptions['fileAttribute'] === $name ? true : parent::hasMethod($name);
    }

    public function __call($name, $arguments)
    {
        $name = Inflector::variablize(substr($name, 3));
        return $this->getQueryRelations();
    }

    public function getQueryRelations()
    {
        return $this->owner
            ->hasMany($this->relationOptions['class'], [$this->foreignKeyColumnName => $this->pkColumnName])
            ->andOnCondition([$this->typeColumnName => $this->owner->tableName()]);

        // return    $this->owner
        //         ->hasMany('news', [$this->foreignKeyColumnName => $this->pkColumnName])
        //         ->viaTable($this->owner->tableName(), [$this->foreignKeyColumnName => $this->pkColumnName],
        //             function($query) {
        //                 $query->andWhere([$this->typeColumnName => $this->owner->tableName()]);
        //             });
    }

    public function canSetProperty($name, $checkVars = true)
    {
        return  ($name == $this->relationOptions['fileAttribute'] || $name == $this->relationOptions['configAttribute'] ) ? true : parent::canSetProperty($name, $checkVars);
    }

    public function __set( $name, $value )
    {
        if($name == $this->relationOptions['fileAttribute']){
            $this->fileAttribute = $value;
        }
    }


    public function attach($owner)
    {
        parent::attach($owner);
        
        if($this->setRule){

            $validators = $owner->validators;
            foreach ($this->rules as $rule) {
                if ($rule instanceof Validator) {
                    $validators->append($rule);
                    $this->validators[] = $rule; // keep a reference in behavior
                } elseif (is_array($rule) && isset($rule[0], $rule[1])) { // attributes, validator type
                    $validator = \yii\validators\Validator::createValidator($rule[1], $owner, (array) $rule[0], array_slice($rule, 2));
                    $validators->append($validator);
                    $this->validators[] = $validator; // keep a reference in behavior
                } else {
                    throw new InvalidConfigException('Invalid validation rule: a rule must specify both attribute names and validator type.');
                }
            }
        }
        // $owner->setAttribute('ssas',array());

    }

    public function detach()
    {
        $ownerValidators = $this->owner->validators;
        $cleanValidators = [];
        foreach ($ownerValidators as $validator) {
            if ( ! in_array($validator, $this->validators)) {
                $cleanValidators[] = $validator;
            }
        }
        $ownerValidators->exchangeArray($cleanValidators);
    }

}