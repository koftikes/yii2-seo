<?php

namespace sbs\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%seo}}".
 *
 * @property int    $id
 * @property int    $item_id
 * @property string $item_model
 * @property string $title
 * @property string $keywords
 * @property string $description
 */
class Seo extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%seo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id'], 'integer'],
            [['item_model'], 'string', 'max' => 150],
            [['item_id', 'item_model'], 'required'],
            [['title', 'keywords'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title'       => 'Seo Title',
            'keywords'    => 'Seo Keywords',
            'description' => 'Seo Description',
        ];
    }
}
