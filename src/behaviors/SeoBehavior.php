<?php

namespace sbs\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use sbs\models\Seo;

class SeoBehavior extends Behavior
{
    private $seo;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'updateFields',
            ActiveRecord::EVENT_AFTER_UPDATE => 'updateFields',
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteFields',
        ];
    }

    public function updateFields($event)
    {
        $model = $this->getSeo();
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
        }
    }

    public function deleteFields($event)
    {
        if ($this->owner->seo) {
            $this->owner->seo->delete();
        }

        return true;
    }

    public function getSeo()
    {
        $model = Seo::findOne(['item_id' => $this->owner->id, 'modelName' => $this->owner->className()]);
        if ($model == null) {
            $model = new Seo;
            $model->item_id = $this->owner->id;
            $model->modelName = $this->owner->className();
        }

        return $model;
    }
}
