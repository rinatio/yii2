<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\bootstrap;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Alert renders an alert bootstrap component.
 *
 * For example,
 *
 * ```php
 * echo Alert::widget(array(
 *     'body' => 'Say hello...',
 *     'closeButton' => array(
 *         'label' => '&times;',
 *         'tag' => 'a',
 *     ),
 * ));
 * ```
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the alert box:
 *
 * ```php
 * Alert::begin(array(
 *     'closeButton' => array(
 *         'label' => '&times;',
 *     ),
 * ));
 *
 * echo 'Say hello...';
 *
 * Alert::end();
 * ```
 *
 * @see http://twitter.github.io/bootstrap/javascript.html#alerts
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @since 2.0
 */
class Alert extends Widget
{
	/**
	 * @var string the body content in the alert component. Note that anything between
	 * the [[begin()]] and [[end()]] calls of the Alert widget will also be treated
	 * as the body content, and will be rendered before this.
	 */
	public $body;
	/**
	 * @var array the options for rendering the close button tag.
	 * The close button is displayed in the header of the modal window. Clicking
	 * on the button will hide the modal window. If this is null, no close button will be rendered.
	 *
	 * The following special options are supported:
	 *
	 * - tag: string, the tag name of the button. Defaults to 'button'.
	 * - label: string, the label of the button. Defaults to '&times;'.
	 *
	 * The rest of the options will be rendered as the HTML attributes of the button tag.
	 * Please refer to the [Alert plugin help](http://twitter.github.com/bootstrap/javascript.html#alerts)
	 * for the supported HTML attributes.
	 */
	public $closeButton = array();


	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();

		$this->initOptions();

		echo Html::beginTag('div', $this->options) . "\n";
		echo $this->renderBodyBegin() . "\n";
	}

	/**
	 * Renders the widget.
	 */
	public function run()
	{
		echo "\n" . $this->renderBodyEnd();
		echo "\n" . Html::endTag('div');

		$this->registerPlugin('alert');
	}

	/**
	 * Renders the close button if any before rendering the content.
	 * @return string the rendering result
	 */
	protected function renderBodyBegin()
	{
		return $this->renderCloseButton();
	}

	/**
	 * Renders the alert body (if any).
	 * @return string the rendering result
	 */
	protected function renderBodyEnd()
	{
		return $this->body . "\n";
	}

	/**
	 * Renders the close button.
	 * @return string the rendering result
	 */
	protected function renderCloseButton()
	{
		if ($this->closeButton !== null) {
			$tag = ArrayHelper::remove($this->closeButton, 'tag', 'button');
			$label = ArrayHelper::remove($this->closeButton, 'label', '&times;');
			if ($tag === 'button' && !isset($this->closeButton['type'])) {
				$this->closeButton['type'] = 'button';
			}
			return Html::tag($tag, $label, $this->closeButton);
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
		$this->options = array_merge(array(
			'class' => 'fade in',
		), $this->options);

		$this->addCssClass($this->options, 'alert');

		if ($this->closeButton !== null) {
			$this->closeButton = array_merge(array(
				'data-dismiss' => 'alert',
				'aria-hidden' => 'true',
				'class' => 'close',
			), $this->closeButton);
		}
	}
}
