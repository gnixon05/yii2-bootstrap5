<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace gnixon\bootstrap5;

/**
 * \gnixon\bootstrap5\Widget is the base class for all bootstrap widgets.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @author Qiang Xue <qiang.xue@gmail.com>
 */
class Widget extends \yii\base\Widget
{
    use BootstrapWidgetTrait;

    private $id = null;
    private $autoGenerate = true;
    //private $autoIdPrefix = 'w';
    public static $counter = 0;

    /**
     * @var array the HTML attributes for the widget container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * Returns the Id of the widget.
     *
     * @return string|null Id of the widget.
     */
    public function getId($autoGenerate = true): ?string
    {
        if ($this->autoGenerate && $this->id === null) {
            $this->id = static::$autoIdPrefix . static::$counter++;
        }

        return $this->id;
    }
}
