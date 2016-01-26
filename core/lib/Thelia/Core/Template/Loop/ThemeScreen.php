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

use Faker\Provider\File;
use Symfony\Component\Filesystem\Filesystem;
use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Core\Template\TemplateDefinition;
use Thelia\Model\ConfigQuery;
use Thelia\Model\ModuleQuery;
use Thelia\Tools\Version\Version;
use Thelia\Type;

class ThemeScreen extends BaseLoop implements ArraySearchLoopInterface
{
    /**
     * @return ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        $myArgs = new ArgumentCollection();
        $myArgs->addArgument(Argument::createAnyTypeArgument("theme",''));

        return $myArgs;
    }

    public function buildArray()
    {
        $Themes = array();

        if("" !== $this->getTheme()){

            //Get the shop url
            $urlSite = ConfigQuery::getConfiguredShopUrl();
            //Remove the "/web" if exist
            $urlSite = str_replace("/web","",$urlSite);

            $templateType = TemplateDefinition::FRONT_OFFICE;
            $templateDef = new TemplateDefinition('',$templateType);

            $fs = new Filesystem();
            $absPath = $templateDef->getAbsolutePath() . $this->getTheme();
            if($fs->exists($absPath . DS . 'theme.json')){
                $jsonContent = $file = file_get_contents($absPath . DS . 'theme.json');
                $object = json_decode($jsonContent);

                $myScreens = [];
                if($object->screens){
                    $i = 0;
                    foreach($object->screens as $screens){
                        $myScreens['numscreen'] = $i;
                        $myScreens['src'] = $urlSite.'/templates/frontOffice/'.$this->getTheme().'/'.$screens->src;
                        $myScreens['caption'] = $screens->caption;
                        $Themes[] = $myScreens;
                        $i++;
                    }
                }

            }

        }
        return $Themes;
    }

    public function parseResults(LoopResult $loopResult)
    {


        foreach ($loopResult->getResultDataCollection() as $required) {
            $loopResultRow = new LoopResultRow($required);

            $loopResultRow
                ->set("NUMSCREEN", $required['numscreen'])
                ->set("SRC", $required['src'])
                ->set("CAPTION", $required['caption'])
            ;
            $this->addOutputFields($loopResultRow, $required);

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}