<?php

namespace sbs\behaviors;

use Yii;
use sbs\models\Seo;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class SeoBehavior extends Behavior
{
    /** @var ActiveRecord */
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

    /**
     * @inheritdoc
     */
    public function updateFields($event)
    {
        $model = $this->getSeo();
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
    protected function getSeo()
    {
        $this->seo = Seo::findOne(['item_id' => $this->owner->id, 'modelName' => $this->owner->className()]);
        if ($this->seo == null) {
            $this->seo = new Seo([
                'item_id' => $this->owner->id,
                'modelName' => $this->owner->className(),
            ]);
        }

        return $this->seo;
    }
}
