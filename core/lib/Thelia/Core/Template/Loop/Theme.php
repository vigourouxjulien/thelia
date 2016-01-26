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

namespace Thelia\Core\Template\Loop;

use Symfony\Component\Filesystem\Filesystem;
use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Core\Template\TemplateDefinition;
use Thelia\Model\ConfigQuery;
use Thelia\Type;

class Theme extends BaseLoop implements ArraySearchLoopInterface
{
    /**
     * @return ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection();
    }

    public function buildArray()
    {
        $templateType = TemplateDefinition::FRONT_OFFICE;
        $templateListe = $this->container->get('thelia.template_helper')->getList($templateType);

        $Themes = array();
        $fs = new Filesystem();
        foreach($templateListe as $aTemplate){

            //var_dump($aTemplate->getAbsolutePath());
            $absPath = $aTemplate->getAbsolutePath();
            if($fs->exists($absPath . DS . 'theme.json')){
                $jsonContent = $file = file_get_contents($absPath . DS . 'theme.json');
                $object = json_decode($jsonContent);
                $object->path = $absPath;
                $Themes[] = $object;
                //var_dump($Themes);
            }

        }

        return $Themes;
    }

    public function parseResults(LoopResult $loopResult)
    {
        //Get the shop url
        $urlSite = ConfigQuery::getConfiguredShopUrl();
        //Remove the "/web" if exist
        $urlSite = str_replace("/web","",$urlSite);

        //Get the default front template
        $defaultFrontTemplate = ConfigQuery::create()->findOneByName('active-front-template')->getValue();

        foreach ($loopResult->getResultDataCollection() as $template) {
            $loopResultRow = new LoopResultRow($template);

            $active = 0;
            if($template->name === $defaultFrontTemplate)
                $active = 1;

            $screen = 0;
            if($template->screen)
                $screen = 1;

            $loopResultRow
                ->set("NAME", $template->name)
                ->set("PATH", $template->path)
                ->set("SCREEN", $screen)
                //->set("SCREENURL", $urlSite.'/templates/frontOffice/'.$template->name.'/'.$template->screen)
                ->set("DESCRIPTION", $template->description)
                ->set("KEYWORD", $template->keyword)
                ->set("VERSION", $template->version)
                ->set("AUTHOR", $template->author)
                ->set("AUTHORURL", $template->authorurl)
                ->set("AUTHOREMAIL", $template->authoremail)
                ->set("THEMZURL", $template->themeurl)
                ->set("ACTIVE",$active)
            ;
            $this->addOutputFields($loopResultRow, $template);

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}