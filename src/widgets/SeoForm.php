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
    const TYPE_SIMPLE = 1;

    const TYPE_PANEL = 2;

    const TYPE_COLLAPSE = 3;

    /**
     * @var ActiveRecord
     */
    public $model;

    /**
     * @var ActiveForm
     */
    public $form;

    /**
     * @var string
     */
    public $title = 'SEO';

    /**
     * @var array list of fields will be shown in form
     */
    public $fields = [];

    /**
     * @var int Type of widget display
     */
    public $type = self::TYPE_SIMPLE;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (!$this->form instanceof ActiveForm) {
            throw new InvalidConfigException('The "form" property must be set and it should be instance of "ActiveForm".');
        }

        if (!$this->model instanceof ActiveRecord) {
            throw new InvalidConfigException('The "model" property must be set and it should be instance of "ActiveRecord".');
        }

        if (empty($this->fields)) {
            $this->fields = ['title', 'keywords', 'description'];
        }

        parent::init();
    }

    public function run()
    {
        if (!$this->model->seo instanceof Seo) {
            $this->model->seo = new Seo();
        }

        $content = [];
        if (\in_array('title', $this->fields, true)) {
            $content[] = $this->form->field($this->model->seo, 'title')->textInput();
        }
        if (\in_array('keywords', $this->fields, true)) {
            $content[] = $this->form->field($this->model->seo, 'keywords')->textarea();
        }
        if (\in_array('description', $this->fields, true)) {
            $content[] = $this->form->field($this->model->seo, 'description')->textarea(['rows' => 4]);
        }

        if (self::TYPE_SIMPLE === $this->type) {
            return \implode('', $content);
        }

        $title = $this->title;
        $body  = Html::tag('div', \implode('', $content), ['class' => 'panel-body']);

        if (self::TYPE_COLLAPSE === $this->type) {
            $title = Html::a($this->title, '#' . $this->id, ['data-toggle' => 'collapse']);
            $body  = Html::tag('div', $body, ['class' => 'panel-collapse collapse', 'id' => $this->id]);
        }

        $heading = Html::tag('div', Html::tag('h2', $title, ['class' => 'panel-title']), ['class' => 'panel-heading']);

        return Html::tag('div', $heading . $body, ['class' => 'panel panel-default']);
    }
}
