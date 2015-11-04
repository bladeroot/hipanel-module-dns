<?php

namespace hipanel\modules\dns\validators;

use Yii;
use yii\validators\RegularExpressionValidator;

/**
 * Validates part of the domain name
 *
 * @package hipanel\modules\dns\validators
 */
class DomainPartValidator extends RegularExpressionValidator
{
    /**
     * @inheritdoc
     */
    public $pattern = '/^(@|\*|([a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?(\.[a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?){0,4})?|(\*\.([a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?(\.[a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?){0,4})?))$/i';

    /**
     * @var string
     */
    public $extendedPattern = '/^(@|\*|([_a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?(\.[_a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?){0,4})?)$/i';

    /**
     * Whether to use [[extendedPattern]]
     * @var boolean
     */
    public $extended = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->message = Yii::t('app', '{attribute} is not a valid domain name part');
        if ($this->extended) {
            $this->pattern = $this->extendedPattern;
        }
    }
}