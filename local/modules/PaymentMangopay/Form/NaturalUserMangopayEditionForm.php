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
use PaymentMangopay\Form\NaturalUserMangopayCreationForm;

/**
 * Class ConfigurationForm
 * @package PayementMangopay\Form
 * @author Vigouroux Julien <jvigouroux@openstudio.fr>
 */
class NaturalUserMangopayEditionForm extends NaturalUserMangopayCreationForm
{

    protected function buildForm()
    {
        parent::buildForm();
        $this->formBuilder
            ->add(
                "id", "text"
            )
        ;
    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return "mangopay_naturaluser_edition";
    }
}
