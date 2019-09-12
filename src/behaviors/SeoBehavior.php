<?php

namespace sbs\behaviors;

use sbs\models\Seo;
use Yii;
use yii\base\Behavior;
use yii\base\Component;
use yii\base\InvalidCallException;
use yii\db\ActiveRecord;

class SeoBehavior extends Behavior
{
    /**
     * @var null|ActiveRecord
     */
    private $seo;

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function updateFields($event)
    {
        $model = $this->getSeo();
        if ($model->load(Yii::$app->request->post())) {
            return $model->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteFields($event)
    {
        if (!$this->owner instanceof Component) {
            throw new InvalidCallException('Can not find owner of this behavior.');
        }

        if ($this->owner->seo) {
            return $this->owner->seo->delete();
        }

        return true;
    }

    /**
     * @return Seo
     */
    protected function getSeo()
    {
        if (!$this->owner instanceof Component) {
            throw new InvalidCallException('Can not find owner of this behavior.');
        }

        if (!$this->seo instanceof Seo) {
            $this->seo = Seo::findOne(['item_id' => $this->owner->id, 'item_model' => $this->owner::className()]);
            if (null === $this->seo) {
                $this->seo = new Seo([
                    'item_id'    => $this->owner->id,
                    'item_model' => $this->owner::className(),
                ]);
            }
        }

        return $this->seo;
    }
}
