<?php

namespace sbs\behaviors;

use sbs\models\Seo;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class SeoBehavior extends Behavior
{
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

    /**
     * @inheritdoc
     */
    public function updateFields($event)
    {
        $model = $this->findSeo();
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
        }
    }

    /**
     * @inheritdoc
     */
    public function deleteFields($event)
    {
        if ($this->owner->seo) {
            $this->owner->seo->delete();
        }

        return true;
    }

    /**
     * @return Seo|static
     */
    protected function findSeo()
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
