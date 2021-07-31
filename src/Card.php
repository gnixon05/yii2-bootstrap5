<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace gnixon\bootstrap5;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Card renders a bootstrap card.
 * A card is a flexible and extensible content container. It includes options for headers and footers,
 * a wide variety of content, contextual background colors, and powerful display options.
 * If you’re familiar with Bootstrap 3, cards replace our old panels, wells, and thumbnails.
 * Similar functionality to those components is available as modifier classes for cards.
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the modal window:
 *
 * * ```php
 * echo Card::widget([
 *     'options' => [
 *         'class' => 'text-center',
 *     ],
 *     'img' => [
 *          'src' => '...',
 *          'location' => 'top/bottom/false',
 *          'imgOverlay' => [
 *              'options' => [],
 *              'title' => '...',
 *              'body' => '...',
 *          ],
 *      ],
 *     'header' => 'Say hello...',
 *     'headerOptions' => [],
 *     'body' => 'Say hello...',
 *     'bodyOptions' => [],
 *     'list' => [...],
 *     'footer' => 'Say hello...',
 *     'footerOptions' => [],
 * ]);
 * ```
 *
 * @see https://getbootstrap.com/docs/5.0/components/card/
 * @author Gwinn Nixon <gwinn@gnixon.com>
 */
class Card extends Widget
{

    /**
     * @var string the header content in the alert component.
     */
    public $header;
    /**
     * @var string the body content in the alert component.
     */
    public $body;
    /**
     * @var string the footer content in the modal window.
     */
    public $footer;
    /**
     * @var array additional header options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $headerOptions = [];
    /**
     * @var array additional body options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $bodyOptions = [];
    /**
     * @var array additional footer options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $footerOptions = [];
    /**
     * @var array the body content in the alert component.
     */
    public $img;
    /**
     * @var array the body content in the alert component.
     */
    public $list;


    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->initOptions();

        echo Html::beginTag('div', $this->options) . "\n";
        if (!$this->imageLocationBottom()) {
            echo $this->renderImg() . "\n";
        }
        echo $this->renderHeader() . "\n";
        echo $this->renderBodyBegin() . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo "\n" . $this->renderBodyEnd();
        echo "\n" . $this->renderList();
        echo "\n" . $this->renderFooter();
        if ($this->imageLocationBottom()) {
            echo $this->renderImg() . "\n";
        }
        echo "\n" . Html::endTag('div');

        $this->registerPlugin('card');
    }

    protected function imageLocationBottom()
    {
        return isset($this->img) && isset($this->img['location']) && $this->img['location'] === 'bottom';
    }

    /**
     * Renders the image HTML markup of the card
     * @return string the rendering result
     */
    protected function renderImg()
    {
        if (!isset($this->img)) {
            return '';
        }
        $imgOptions = [];
        if ($this->img['src']) { $imgOptions['src'] = $this->img['src']; }
        $imgOptions['alt'] = "";
        $imgOptions['class'] = $this->img['location']?'card-img-'.$this->img['location']:'card-img';
        $img = Html::tag('img', '', $imgOptions);
        $overlay = "";
        if (isset($this->img['imgOverlay'])) {
            $overlayInner = "";
            if (isset($this->img['imgOverlay']['title'])) {
                $overlayInner .= Html::tag('h5', $this->img['imgOverlay']['title'], ['class' => 'card-title']);
            }
            if (isset($this->img['imgOverlay']['body'])) {
                $overlayInner .= Html::tag('div', $this->img['imgOverlay']['body'], ['class' => 'card-text']);
            }
            $overlayOptions = $this->img['imgOverlay']['options'] ?? [];
            Html::addCssClass($overlayOptions, ['widget' => 'card-img-overlay']);
            $overlay .= Html::tag('div', $overlayInner, $overlayOptions);
        }

        return $img . $overlay;
    }

    /**
     * Renders the header HTML markup of the card
     * @return string the rendering result
     */
    protected function renderHeader()
    {
        if (!isset($this->header)) {
            return '';
        }

        $tag = $this->headerOptions['tag']??'div';
        unset($this->headerOptions['tag']);
        Html::addCssClass($this->headerOptions, ['widget' => 'card-header']);
        return Html::tag($tag, $this->header, $this->headerOptions);

    }

    /**
     * Renders the header HTML markup of the card
     * @return string the rendering result
     */
    protected function renderList()
    {

        if (!isset($this->list)) {
            return '';
        }


        $list = Html::beginTag('ul', ['class' => 'list-group list-group-flush']);

        foreach ($this->list as $n => $item) {
            $list .= Html::tag('li', $item, ['class' => 'list-group-item']);
        }

        $list .= Html::endTag('ul');

        return $list;

    }

    /**
     * Renders the opening tag of the card body.
     * @return string the rendering result
     */
    protected function renderBodyBegin()
    {
        if (isset($this->body)) {
            Html::addCssClass($this->bodyOptions, ['widget' => 'card-body']);
            return Html::beginTag('div', $this->bodyOptions);
        } else {
            return null;
        }
    }

    /**
     * Renders the closing tag of the card body.
     * @return string the rendering result
     */
    protected function renderBodyEnd()
    {
        if (isset($this->body)) {
            return $this->body . Html::endTag('div');
        } else {
            return null;
        }
    }

    /**
     * Renders the HTML markup for the footer of the card
     * @return string the rendering result
     */
    protected function renderFooter()
    {
        if (isset($this->footer)) {
            Html::addCssClass($this->footerOptions, ['widget' => 'card-footer']);
            return Html::tag('div', "\n" . $this->footer . "\n", $this->footerOptions);
        } else {
            return null;
        }
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
        Html::addCssClass($this->options, ['widget' => 'card']);
    }
}
