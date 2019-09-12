Yii2-Seo
==========

The module provides an ability to add SEO fields to Model. Fields: title, keywords, description.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run
```bash
composer require sbs/yii2-seo
```

or add to the require section of your application's `composer.json` file next line 
```json
"sbs/yii2-seo": "*"
```

and run
```bash
composer update
```

Migrations
----------

For add table, to DataBase, you can run next command  
```bash
php yii migrate/up --migrationPath=vendor/sbs/yii2-seo/src/migrations
```

or you can configure your application's `config\console.php`

*This method more preferable because you can run standard migrations commands.*
```php
'controllerMap' => [
    'migrate' => [
        'class' => MigrateController::class,
        'migrationNamespaces' => ['sbs\migrations'],
        //...
    ],
    //...
],
```

Use with Model
--------------

You need to add behaviors to model:

```php
use sbs\behaviors\SeoBehavior;

function behaviors()
{
    return [
    //...
        SeoBehavior::class,
    //...
    ];
}
```

Now all fields will be avalible by $model->seo.

For add/edit fields in model form view use next widget:

```php
//...
use sbs\widgets\SeoForm;
//...
?>
<div>
    <?php $form = ActiveForm::begin(); ?>
    //...
    <?= SeoForm::widget(['model' => $model, 'form' => $form]); ?>
    //...
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create': 'Update'); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
```

For display this field on page view use next widget:

```php
use sbs\widgets\SeoTags;
//...
SeoTags::widget(['seo' => $model->seo]);
// ...
``` 

Use without Model
-----------------
Also, you can use the SeoTags widget without model and DataBase.
For example, if you need to add SEO to some static page and no need for editing this information in the admin panel:

```php
use sbs\widgets\SeoTags;
//...
SeoTags::widget(['title' => 'title', 'keywords' => 'keyword 1, keyword 2', 'description' => 'your description']);
// ...
``` 
