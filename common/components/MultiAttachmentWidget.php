<?php

namespace common\components;

use yii\base\Widget;

class MultiAttachmentWidget extends Widget
{

    public $model;
    public $form;
    public $files;
    public $hidden_remove = false;
    public bool $required = false;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('MultiAttachmentWidget', ['model' => $this->model, 'form' => $this->form, 'files' => $this->files, 'hidden_remove' => $this->hidden_remove, 'required' => $this->required]);
    }


    public function runForView()
    {
        return $this->render('forView', ['model' => $this->model, 'form' => $this->form, 'files' => $this->files, 'hidden_remove' => $this->hidden_remove]);
    }
}
