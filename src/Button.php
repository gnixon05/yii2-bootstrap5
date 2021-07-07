<?php

namespace gnixon\bootstrap5;

use yii\helpers\Html;

/**
 * Button renders a bootstrap button.
 *
 * For example,
 *
 * ```php
 * echo Button::widget()
 *     ->label('Action')
 *     ->options(['class' => 'btn-lg']);
 * ```
 */
class Button extends Widget
{
    private string $tagName = 'button';
    private string $label = 'Button';
    private bool $encodeLabels = true;
    private bool $encodeTags = false;
    private array $options = [];

    protected function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-button";
        }

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($this->options, ['widget' => 'btn']);

        return Html::tag(
            $this->tagName,
            $this->encodeLabels ? Html::encode($this->label) : $this->label,
            $this->options
        )->encode($this->encodeTags)->render();
    }

    /**
     * When tags Labels HTML should not be encoded.
     *
     * @return self
     */
    public function withoutEncodeLabels(): self
    {
        $new = clone $this;
        $new->encodeLabels = false;

        return $new;
    }

    /**
     * The button label
     *
     * @param string $value
     *
     * @return self
     */
    public function label(string $value): self
    {
        $new = clone $this;
        $new->label = $value;

        return $new;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
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
     * The tag to use to render the button.
     *
     * @param string $value
     *
     * @return self
     */
    public function tagName(string $value): self
    {
        $new = clone $this;
        $new->tagName = $value;

        return $new;
    }
}