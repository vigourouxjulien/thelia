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
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

/**
 * Class ConfigurationForm
 * @package PayementMangopay\Form
 * @author Vigouroux Julien <jvigouroux@openstudio.fr>
 */
class LegalUserMangopayCreationForm extends BaseForm
{

    protected function buildForm()
    {
        $this->formBuilder
            ->add("isdefault","text",array(
                "label" => Translator::getInstance()->trans('Default Wallet',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "isdefault",
                    "help" => Translator::getInstance()->trans('Default Wallet',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => false,
                "constraints" => array(),
                "attr" => array()
            ))
            ->add("Tag","text",array(
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
                "Email", "text",
                array(
                    "label" =>  Translator::getInstance()->trans('Email',[],PaymentMangopay::BO_DOMAIN_NAME),
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('Email',[],PaymentMangopay::BO_DOMAIN_NAME)
                    ],
                    "required" => true,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "Name", "text",
                array(
                    "label" =>  Translator::getInstance()->trans('Name',[],PaymentMangopay::BO_DOMAIN_NAME),
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('Name',[],PaymentMangopay::BO_DOMAIN_NAME)
                    ],
                    "required" => true,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "LegalPersonType", "text",
                array(
                    "label" =>  Translator::getInstance()->trans('LegalPersonType',[],PaymentMangopay::BO_DOMAIN_NAME),
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('LegalPersonType',[],PaymentMangopay::BO_DOMAIN_NAME)
                    ],
                    "required" => true,
                    "constraints" => array( new Choice(array('choices' => array('BUSINESS','ORGANIZATION')))),
                    "attr" => array()
                )
            )
            ->add("HeadquartersAddressAddressLine1","text",array(
                "label" => Translator::getInstance()->trans('HeadquartersAddressAddressLine1',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('HeadquartersAddressAddressLine1',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => true,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("HeadquartersAddressAddressLine2","text",array(
                "label" => Translator::getInstance()->trans('HeadquartersAddressAddressLine2',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('HeadquartersAddressAddressLine2',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => false,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("HeadquartersAddressCity","text",array(
                "label" => Translator::getInstance()->trans('HeadquartersAddressCity',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('HeadquartersAddressCity',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => true,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("HeadquartersAddressRegion","text",array(
                "label" => Translator::getInstance()->trans('HeadquartersAddressRegion',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('HeadquartersAddressRegion',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => false,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("HeadquartersAddressPostalCode","text",array(
                "label" => Translator::getInstance()->trans('HeadquartersAddressPostalCode',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('HeadquartersAddressPostalCode',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => true,
                "constraints" => array(),
                "attr" => array()
            ))
            ->add("HeadquartersAddressCountry","text",array(
                "label" => Translator::getInstance()->trans('HeadquartersAddressCountry',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('HeadquartersAddressCountry',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => true,
                "constraints" => array(),
                "attr" => array()
            ))
            ->add(
                "LegalRepresentativeFirstName", "text",
                array(
                    "label" => Translator::getInstance()->trans('LegalRepresentativeFirstName',[],PaymentMangopay::BO_DOMAIN_NAME),
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('LegalRepresentativeFirstName',[],PaymentMangopay::BO_DOMAIN_NAME)
                    ],
                    "required" => true,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "LegalRepresentativeLastName", "text",array(
                    "label" => Translator::getInstance()->trans('LegalRepresentativeLastName',[],PaymentMangopay::BO_DOMAIN_NAME),
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('LegalRepresentativeLastName',[],PaymentMangopay::BO_DOMAIN_NAME)
                    ],
                    "required" => true,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add("LegalRepresentativeAddressAddressLine1","text",array(
                "label" => Translator::getInstance()->trans('LegalRepresentativeAddressAddressLine1',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('LegalRepresentativeAddressAddressLine1',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => true,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("LegalRepresentativeAddressAddressLine2","text",array(
                "label" => Translator::getInstance()->trans('LegalRepresentativeAddressAddressLine2',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('LegalRepresentativeAddressAddressLine2',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => false,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("LegalRepresentativeAddressCity","text",array(
                "label" => Translator::getInstance()->trans('LegalRepresentativeAddressCity',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('LegalRepresentativeAddressCity',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => true,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("LegalRepresentativeAddressRegion","text",array(
                "label" => Translator::getInstance()->trans('LegalRepresentativeAddressRegion',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('LegalRepresentativeAddressRegion',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => false,
                "constraints" => array(
                    new Length(array('max'=>255))
                ),
                "attr" => array()
            ))
            ->add("LegalRepresentativeAddressPostalCode","text",array(
                "label" => Translator::getInstance()->trans('LegalRepresentativeAddressPostalCode',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('LegalRepresentativeAddressPostalCode',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => true,
                "constraints" => array(),
                "attr" => array()
            ))
            ->add("LegalRepresentativeAddressCountry","text",array(
                "label" => Translator::getInstance()->trans('LegalRepresentativeAddressCountry',[],PaymentMangopay::BO_DOMAIN_NAME),
                "label_attr" => [
                    "for" => "enabled",
                    "help" => Translator::getInstance()->trans('LegalRepresentativeAddressCountry',[],PaymentMangopay::BO_DOMAIN_NAME)
                ],
                "required" => true,
                "constraints" => array(),
                "attr" => array()
            ))
            ->add(
                "LegalRepresentativeEmail", "text",
                array(
                    "label" => Translator::getInstance()->trans('LegalRepresentativeEmail',[],PaymentMangopay::BO_DOMAIN_NAME),
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('LegalRepresentativeEmail',[],PaymentMangopay::BO_DOMAIN_NAME)
                    ],
                    "required" => false,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "LegalRepresentativeBirthday", "text",
                array(
                    "label" => Translator::getInstance()->trans('LegalRepresentativeBirthday',[],PaymentMangopay::BO_DOMAIN_NAME),
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('LegalRepresentativeBirthday',[],PaymentMangopay::BO_DOMAIN_NAME)
                    ],
                    "required" => true,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "LegalRepresentativeNationality", "text",
                array(
                    "label" => Translator::getInstance()->trans('LegalRepresentativeNationality',[],PaymentMangopay::BO_DOMAIN_NAME),
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('LegalRepresentativeNationality',[],PaymentMangopay::BO_DOMAIN_NAME)
                    ],
                    "required" => true,
                    "constraints" => array(),
                    "attr" => array()
                )
            )
            ->add(
                "LegalRepresentativeCountryOfResidence", "text",
                array(
                    "label" => Translator::getInstance()->trans('LegalRepresentativeCountryOfResidence',[],PaymentMangopay::BO_DOMAIN_NAME),
                    "label_attr" => [
                        "for" => "enabled",
                        "help" => Translator::getInstance()->trans('LegalRepresentativeCountryOfResidence',[],PaymentMangopay::BO_DOMAIN_NAME)
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
        return "mangopay_legaluser_creation";
    }
}
