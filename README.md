<p align="center">
    <a href="http://getbootstrap.com/" target="_blank" rel="external">
        <img src="https://v4-alpha.getbootstrap.com/assets/brand/bootstrap-solid.svg" height="80px">
    </a>
    <h1 align="center">Twitter Bootstrap 5 Extension for Yii 2</h1>
    <br>
</p>

This is the Twitter Bootstrap extension for [Yii framework 2.0](http://www.yiiframework.com). It encapsulates [Bootstrap 5](http://getbootstrap.com/) components
and plugins in terms of Yii widgets, and thus makes using Bootstrap components/plugins
in Yii applications extremely easy.

This particular version is a clone of [yiisoft Bootstrap 4](https://github.com/yiisoft/yii2-bootstrap4) and updated using [yiisoft Bootstrap 5](https://github.com/yiisoft/yii-bootstrap5) to ensure the appropriate classes and structure were utilized while maintaining proper compatability with Yii 2.

For license information check the [LICENSE](LICENSE.md)-file.

Documentation is at [docs/guide/README.md](docs/guide/README.md).


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist gnixon05/yii2-bootstrap5
```

or add

```
"gnixon05/yii2-bootstrap5": "dev"
```

to the require section of your `composer.json` file.

Usage
----

For example, the following
single line of code in a view file would render a Bootstrap Progress plugin:

```php
<?= gnixon\bootstrap5\Progress::widget(['percent' => 60, 'label' => 'test']) ?>
```
