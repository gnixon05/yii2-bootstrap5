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
 * Offcanvas renders an offcanvas window that can be toggled by clicking on a button.
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the offcanvas window:
 *
 * ~~~php
 * OffCanvas::begin([
 *     'title' => 'Hello world',
 *     'toggleButton' => ['label' => 'click me'],
 *     'bodyScrolling' => 'false',
 *     'backdrop' => 'true',
 *     'location' => 'start',
 * ]);
 *
 * echo 'Say hello...';
 *
 * OffCanvas::end();
 * ~~~
 *
 * @see https://getbootstrap.com/docs/5.0/components/offcanvas/
 * @author Gwinn Nixon <gwinn@gnixon.com>
 */
class Offcanvas extends Widget
{

    /**
     * @var string the tile content in the offcanvas window.
     */
    public $title;
    /**
     * @var array additional title options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $titleOptions = [];
    /**
     * @var array additional header options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $headerOptions = [];
    /**
     * @var array body options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $bodyOptions = [];
    /**
     * @var string the offcanvas location. Can be ['start', 'end', 'top', 'bottom'], or empty for default.
     */
    public $location = 'start';
    /**
     * @var array|false the options for rendering the close button tag.
     * The close button is displayed in the header of the offcanvas window. Clicking
     * on the button will hide the offcanvas window. If this is false, no close button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     */
    public $closeButton = [];
    /**
     * @var array|false the options for rendering the toggle button tag.
     * The toggle button is used to toggle the visibility of the offcanvas window.
     * If this property is false, no toggle button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to 'Show'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     */
    public $toggleButton = false;
    /**
     * @var boolean whether to make the offcanvas body scrollable
     *
     * When true the data-bs-scroll attribute will be added to the element
     */
    public $bodyScrolling = false;
    /**
     * @var boolean whether to have a backdrop on the page while the element is visible
     *
     * When true the data-bs-backdrop attribute will be added to the element
     */
    public $backdrop = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->initOptions();

        echo $this->renderToggleButton() . "\n";
        echo Html::beginTag('div', $this->options) . "\n";
        echo $this->renderHeader() . "\n";
        echo $this->renderBodyBegin() . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo "\n" . $this->renderBodyEnd();
        echo "\n" . Html::endTag('div');

        $this->registerPlugin('offcanvas');
    }

    /**
     * Renders the header HTML markup of the offcanvas
     * @return string the rendering result
     */
    protected function renderHeader()
    {
        $button = $this->renderCloseButton();
        if ($this->title !== null) {
            Html::addCssClass($this->titleOptions, ['widget' => 'offcanvas-title']);
            $header = Html::tag('h5', $this->title, $this->titleOptions);
        } else {
            $header = '';
        }

        if ($button !== null) {
            $header .= "\n" . $button;
        } elseif ($header === '') {
            return '';
        }
        Html::addCssClass($this->headerOptions, ['widget' => 'offcanvas-header']);
        return Html::tag('div', "\n" . $header . "\n", $this->headerOptions);
    }

    /**
     * Renders the opening tag of the offcanvas body.
     * @return string the rendering result
     */
    protected function renderBodyBegin()
    {
        Html::addCssClass($this->bodyOptions, ['widget' => 'offcanvas-body']);
        return Html::beginTag('div', $this->bodyOptions);
    }

    /**
     * Renders the closing tag of the offcanvas body.
     * @return string the rendering result
     */
    protected function renderBodyEnd()
    {
        return Html::endTag('div');
    }

    /**
     * Renders the toggle button.
     * @return string the rendering result
     */
    protected function renderToggleButton()
    {
        if (($toggleButton = $this->toggleButton) !== false) {
            $tag = ArrayHelper::remove($toggleButton, 'tag', 'button');
            $label = ArrayHelper::remove($toggleButton, 'label', 'Show');

            return Html::tag($tag, $label, $toggleButton);
        } else {
            return null;
        }
    }

    /**
     * Renders the close button.
     * @return string the rendering result
     */
    protected function renderCloseButton()
    {
        if (($closeButton = $this->closeButton) !== false) {
            $tag = ArrayHelper::remove($closeButton, 'tag', 'button');

            return Html::tag($tag, '', $closeButton);
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
        $this->options = array_merge([
            'class' => 'offcanvas-start',
            'tabindex' => -1,
        ], $this->options);
        Html::addCssClass($this->options, ['widget' => 'offcanvas']);

        if ($this->clientOptions !== false) {
            $this->clientOptions = array_merge(['show' => false], $this->clientOptions);
        }

        $this->titleOptions = array_merge([
            'id' => $this->options['id'] . '-label',
        ], $this->titleOptions);
        if (!isset($this->options['aria-label'], $this->options['aria-labelledby']) && $this->title !== null) {
            $this->options['aria-labelledby'] = $this->titleOptions['id'];
        }

        if ($this->closeButton !== false) {
            $this->closeButton = array_merge([
                'data-bs-dismiss' => 'offcanvas',
                'class' => 'btn-close text-reset',
                'type' => 'button',
                'aria-lavel' => 'Close',
            ], $this->closeButton);
        }

        if ($this->toggleButton !== false) {
            $this->toggleButton = array_merge([
                'data-bs-toggle' => 'offcanvas',
                'type' => 'button',
            ], $this->toggleButton);
            if (!isset($this->toggleButton['data-bs-target']) && !isset($this->toggleButton['href'])) {
                $this->toggleButton['data-bs-target'] = '#' . $this->options['id'];
            }
            if (!isset($this->toggleButton['aria-controls']) && !isset($this->toggleButton['href'])) {
                $this->toggleButton['aria-controls'] = $this->options['id'];
            }
        }

        if ($this->bodyScrolling) {
            Html::addCssClass($this->options, ['data-bs-scroll' => $this->bodyScrolling]);
        }
        if ($this->backdrop) {
            Html::addCssClass($this->options, ['data-bs-backdrop' => $this->backdrop]);
        }
    }
}
