<?php

namespace sbs\widgets;

use sbs\models\Seo;
use yii\base\InvalidConfigException;
use yii\base\Widget;

class SeoTags extends Widget
{
    /**
     * @var null|Seo
     */
    public $seo;

    /**
     * @var string
     */
    public $title = '';

    /**
     * @var string
     */
    public $keywords = '';

    /**
     * @var string
     */
    public $description = '';

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        if (empty($this->title) && empty($this->keywords) && empty($this->description)) {
            if (!$this->seo instanceof Seo) {
                throw new InvalidConfigException('No information for the show in SEO tags.');
            }
        }

        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if ($this->seo instanceof Seo) {
            if (empty($this->title)) {
                $this->title = $this->seo->title;
            }
            if (empty($this->keywords)) {
                $this->keywords = $this->seo->keywords;
            }

            if (empty($this->description)) {
                $this->description = $this->seo->description;
            }
        }

        $this->view->title = $this->title;
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $this->keywords]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => $this->description]);

        return '';
    }
}
