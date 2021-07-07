<?php

namespace gnixon\bootstrap5;

use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

#use function implode;
#use function is_array;

/**
 * ButtonToolbar Combines sets of button groups into button toolbars for more complex components.
 * Use utility classes as needed to space out groups, buttons, and more.
 *
 * For example,
 *
 * ```php
 * // a button toolbar with items configuration
 * echo ButtonToolbar::widget()
 *     ->buttonGroups([
 *         [
 *             'buttons' => [
 *                 ['label' => '1', 'class' => ['btn-secondary']],
 *                 ['label' => '2', 'class' => ['btn-secondary']],
 *                 ['label' => '3', 'class' => ['btn-secondary']],
 *                 ['label' => '4', 'class' => ['btn-secondary']]
 *             ],
 *              'class' => ['mr-2']
 *         ],
 *         [
 *             'buttons' => [
 *                 ['label' => '5', 'class' => ['btn-secondary']],
 *                 ['label' => '6', 'class' => ['btn-secondary']],
 *                 ['label' => '7', 'class' => ['btn-secondary']]
 *             ],
 *             'class' => ['mr-2']
 *         ],
 *         [
 *             'buttons' => [
 *                 ['label' => '8', 'class' => ['btn-secondary']]
 *             ]
 *         ]
 *     ]);
 * ```
 *
 * Pressing on the button should be handled via JavaScript. See the following for details:
 */
class ButtonToolbar extends Widget
{
    private bool $encodeTags = false;
    private array $buttonGroups = [];
    private array $options = [];

    protected function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-button-toolbar";
        }

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($this->options, ['widget' => 'btn-toolbar']);

        if (!isset($this->options['role'])) {
            $this->options['role'] = 'toolbar';
        }

        return Html::div($this->renderButtonGroups(), $this->options)
            ->encode($this->encodeTags)
            ->render();
    }

    /**
     * List of buttons groups. Each array element represents a single group which can be specified as a string or an
     * array of the following structure:
     *
     * - buttons: array list of buttons. Either as array or string representation
     * - options: array optional, the HTML attributes of the button group.
     * - encodeLabels: bool whether to HTML-encode the button labels.
     *
     * @param array $value
     *
     * @return self
     */
    public function buttonGroups(array $value): self
    {
        $new = clone $this;
        $new->buttonGroups = $value;

        return $new;
    }

    /**
     * The HTML attributes for the container tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * Generates the button groups that compound the toolbar as specified on {@see buttonGroups}.
     *
     * @throws InvalidConfigException
     *
     * @return string the rendering result.
     */
    private function renderButtonGroups(): string
    {
        $buttonGroups = [];

        foreach ($this->buttonGroups as $group) {
            if (is_array($group)) {
                if (!isset($group['buttons'])) {
                    continue;
                }

                $options = ArrayHelper::getValue($group, 'options', []);
                $buttonGroups[] = ButtonGroup::widget()
                    ->buttons($group['buttons'])
                    ->options($options)
                    ->render();
            } else {
                $buttonGroups[] = $group;
            }
        }

        return implode("\n", $buttonGroups);
    }
}