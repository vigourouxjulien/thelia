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
use PaymentMangopay\Form\AddressMangopayForm;
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
class NaturalUserMangopayCreationForm  extends BaseForm
{

    protected function buildForm()
    {
        $this->formBuilder
            ->add("tag","text",array(
                "label" => Translator::getInstance()->trans('Tag',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('Tag',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => false,
                "constraints" => array(),
                "attr" => array()
            ))
            ->add(
                "email", "text",
                array(
                    "label" =>  Translator::getInstance()->trans('email',[],PaymentMangopay::BO_DOMAIN_NAME),
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('email',[],PaymentMangopay::BO_DOMAIN_NAME)
                    ],
                    "required" => true,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "firstname", "text",
                array(
                    "label" => Translator::getInstance()->trans('firstname',[],PaymentMangopay::BO_DOMAIN_NAME),
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('firstname',[],PaymentMangopay::BO_DOMAIN_NAME)
                    ],
                    "required" => true,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "lastname", "text",array(
                    "label" => Translator::getInstance()->trans('lastname',[],PaymentMangopay::BO_DOMAIN_NAME),
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('lastname',[],PaymentMangopay::BO_DOMAIN_NAME)
                    ],
                    "required" => true,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add("addressline1","text",array(
                "label" => Translator::getInstance()->trans('addressline1',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('addressline1',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => true,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("addressline2","text",array(
                "label" => Translator::getInstance()->trans('addressline2',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('addressline2',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => false,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("city","text",array(
                "label" => Translator::getInstance()->trans('city',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('city',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => true,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("region","text",array(
                "label" => Translator::getInstance()->trans('region',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('region',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => false,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("postalcode","text",array(
                "label" => Translator::getInstance()->trans('postalcode',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('postalcode',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => true,
                "constraints" => array(),
                "attr" => array()
            ))
            ->add("country","text",array(
                "label" => Translator::getInstance()->trans('country',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('country',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => true,
                "constraints" => array(),
                "attr" => array()
            ))
            ->add(
                "birthday", "text",
                array(
                    "label" => Translator::getInstance()->trans('birthday',[],PaymentMangopay::BO_DOMAIN_NAME),
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('birthday',[],PaymentMangopay::BO_DOMAIN_NAME)
                    ],
                    "required" => true,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "nationality", "text",
                array(
                    "label" => Translator::getInstance()->trans('nationality',[],PaymentMangopay::BO_DOMAIN_NAME),
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('nationality',[],PaymentMangopay::BO_DOMAIN_NAME)
                    ],
                    "required" => true,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "countryofresidence", "text",
                array(
                    "label" => Translator::getInstance()->trans('countryofresidence',[],PaymentMangopay::BO_DOMAIN_NAME),
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('countryofresidence',[],PaymentMangopay::BO_DOMAIN_NAME)
                    ],
                    "required" => true,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
        ;

    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return "mangopay_naturaluser_creation";
    }
}
