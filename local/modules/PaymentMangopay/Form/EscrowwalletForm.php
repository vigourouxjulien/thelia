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
use PaymentMangopay\Model\MangopayEscrowwalletQuery;
use PaymentMangopay\PaymentMangopay;
use Propel\Runtime\Map\TableMap;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

/**
 * Class ConfigurationForm
 * @package PayementMangopay\Form
 * @author Vigouroux Julien <jvigouroux@openstudio.fr>
 */
class EscrowwalletForm extends BaseForm
{

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                "id",
                "hidden"
            )
            ->add(
                "user",
                "text",
                array(
                    "label" => "Fees",
                    "label_attr" => [
                        "for" => "user",
                        "help" => Translator::getInstance()->trans('User', [], PaymentMangopay::DOMAIN_NAME)
                    ],
                    "required" => false,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "wallet",
                "text",
                array(
                    "label" => "Client Id",
                    "label_attr" => [
                        "for" => "wallet",
                        "help" => Translator::getInstance()->trans('wallet', [], PaymentMangopay::DOMAIN_NAME)
                    ],
                    "required" => false,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
        ;

        $myObject = MangopayEscrowwalletQuery::create()->findPk(1);

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
        return "mangopay_escrowwallet";
    }
}
