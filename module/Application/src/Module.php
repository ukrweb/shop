<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\I18n\Translator\{Translator as I18nTranslator, Resources};
use Zend\Mvc\I18n\Translator;
use Zend\Validator\AbstractValidator;

class Module
{
    const VERSION = '3.0.2dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap()
    {
        $i18nTranslator = new I18nTranslator();
        $i18nTranslator->setLocale('ru');
        $translator = new Translator($i18nTranslator);
        $translator->addTranslationFilePattern(
            'phpArray',
            Resources::getBasePath(),
            Resources::getPatternForValidator()
        );

        AbstractValidator::setDefaultTranslator($translator);
    }
}
