<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace PaymentMangopay\Form;

use PaymentMangopay\Model\MangopayConfigurationQuery;
use PaymentMangopay\PaymentMangopay;
use Propel\Runtime\Map\TableMap;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

/**
 * Class ConfigurationForm
 * @package PayementMangopay\Form
 * @author Vigouroux Julien <jvigouroux@openstudio.fr>
 */
class ConfigurationForm extends BaseForm
{

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                "id",
                "hidden"
            )
            ->add(
                "fees",
                "text",
                array(
                    "label" => "Fees",
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('Amout of fees', [], PaymentMangopay::DOMAIN_NAME)
                    ],
                    "required" => false,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "clientid",
                "text",
                array(
                    "label" => "Client Id",
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('Client Id', [], PaymentMangopay::DOMAIN_NAME)
                    ],
                    "required" => false,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "clientpassword",
                "text",
                array(
                    "label" => "Client Password",
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('Client Password', [], PaymentMangopay::DOMAIN_NAME)
                    ],
                    "required" => false,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "temporaryfolder",
                "text",
                array(
                    "label" => "Temporary Folder",
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('Temporary Folder', [], PaymentMangopay::DOMAIN_NAME)
                    ],
                    "required" => false,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "deferred_payment",
                "text",
                array(
                    "label" => "Deferred payment",
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('Deferred payment', [], PaymentMangopay::DOMAIN_NAME)
                    ],
                    "required" => false,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "days",
                "text",
                array(
                    "label" => "Days",
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('Days', [], PaymentMangopay::DOMAIN_NAME)
                    ],
                    "required" => false,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
        ;

        $myObject = MangopayConfigurationQuery::create()->findPk(1);

		if($myObject){
			$arrayData = $myObject->toArray(TableMap::TYPE_FIELDNAME);
			$this->formBuilder->setData($arrayData);
		}

    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return "mangopay_configuration";
    }
}
