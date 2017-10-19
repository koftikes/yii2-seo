<?php

namespace sbs\widgets;

use sbs\models\Seo;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

class SeoForm extends Widget
{
    const TYPE_PANEL = 1;
    const TYPE_COLLAPSE = 2;
    const TYPE_SIMPLE = 3;

    /** @var ActiveRecord */
    public $model;

    /** @var  ActiveForm */
    public $form;

    public $title = 'SEO';

    /** @var string Type of widget display */
    public $type = self::TYPE_COLLAPSE;

    public function init()
    {
        if ($this->form === null || !$this->form instanceof ActiveForm) {
            throw new InvalidConfigException('The "form" property must be set and it should be instance of "ActiveForm".');
        }

        if ($this->model === null || !$this->model instanceof ActiveRecord) {
            throw new InvalidConfigException('The "model" property must be set and it should be instance of "ActiveRecord".');
        }

        parent::init();
    }

    public function run()
    {
        if ($this->model->isNewRecord) {
            $this->model = new Seo;
        } else {
            $this->model = $this->model->seo;
        }

        $content = [];
        $content[] = $this->form->field($this->model, 'title')->textInput();
        $content[] = $this->form->field($this->model, 'keywords')->textarea();
        $content[] = $this->form->field($this->model, 'description')->textarea(['rows' => 4]);

        if ($this->type == self::TYPE_SIMPLE) {
            return implode('', $content);
        }

        $body = Html::tag('div', implode('', $content), ['class' => 'panel-body']);
        if ($this->type == self::TYPE_COLLAPSE) {
            $title = Html::a($this->title, '#' . $this->id, ['data-toggle' => 'collapse']);
            $body = Html::tag('div', $body, ['class' => 'panel-collapse collapse', 'id' => $this->id]);
        } else {
            $title = $this->title;
        }

        $heading = Html::tag('div', Html::tag('h4', $title, ['class' => 'panel-title']), ['class' => 'panel-heading']);

        return Html::tag('div', $heading . $body, ['class' => 'panel panel-default']);
    }
}
