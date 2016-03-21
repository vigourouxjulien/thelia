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
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Length;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

/**
 * Class ConfigurationForm
 * @package PayementMangopay\Form
 * @author Vigouroux Julien <jvigouroux@openstudio.fr>
 */
class AddressMangopayForm extends BaseForm
{
    /*
    protected function buildForm()
    {
        // TODO: Implement buildForm() method.
    }
    */

    protected function buildForm(){
        $this->formBuilder
            ->add("addressline1","text",array(
                "label" => "AddressLine1",
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('addressline1',[],PaymentMangopay::DOMAIN_NAME)
                ],
                "required" => false,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("addressline2","text",array(
                "label" => "AddressLine2",
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('addressline2',[],PaymentMangopay::DOMAIN_NAME)
                ],
                "required" => false,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("city","text",array(
                "label" => "City",
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('city',[],PaymentMangopay::DOMAIN_NAME)
                ],
                "required" => false,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("region","text",array(
                "label" => "Region",
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('region',[],PaymentMangopay::DOMAIN_NAME)
                ],
                "required" => false,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("postalCode","text",array(
                "label" => "PostalCode",
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('postalCode',[],PaymentMangopay::DOMAIN_NAME)
                ],
                "required" => false,
                "constraints" => array(),
                "attr" => array()
            ))
            ->add("country","text",array(
                "label" => "Country",
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('country',[],PaymentMangopay::DOMAIN_NAME)
                ],
                "required" => false,
                "constraints" => array(),
                "attr" => array()
            ))
        ;
        //return $this->formBuilder;
    }
    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return "mangopay_address_creation";
    }
}