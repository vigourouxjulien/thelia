<?php
/**
 * Created by PhpStorm.
 * User: E-FUSION-JULIEN
 * Date: 08/01/2016
 * Time: 16:11
 */

namespace Thelia\Controller\Admin;


use Symfony\Component\Filesystem\Filesystem;
use Thelia\Core\Template\TemplateDefinition;
use Thelia\Form\ThemeFrontCreationForm;
use Thelia\Model\ConfigQuery;

class ThemeController extends BaseAdminController
{

    public function indexAction(){
        return $this->render('themes');
    }

    public function toggleActivation(){
        $themeName = $this->getRequest()->get('themename');
        if(""!==$themeName){
            $frontTemplate = ConfigQuery::create()->findOneByName('active-front-template');
            $frontTemplate->setValue($themeName)
                ->save();
        }
        return $this->generateRedirectFromRoute('admin.theme');
    }

    /*
     * Add à theme front zip file
     */
    public function addTheme(){

        $request = $this->getRequest();
        $themeForm = new ThemeFrontCreationForm($request);

        $form = $this->validateForm($themeForm);

        $myData = $form->getData();
        $fileName = $myData['themezip']->getClientOriginalName();
        $fs = new Filesystem();

        $templateType = TemplateDefinition::FRONT_OFFICE;
        $templateDef = new TemplateDefinition('',$templateType);
        $templateDef->getAbsolutePath();
        $myData['themezip']->move($templateDef->getAbsolutePath(),$fileName);

        $zip = new \ZipArchive;
        if ($zip->open($templateDef->getAbsolutePath().$fileName) === TRUE) {
            $zip->extractTo($templateDef->getAbsolutePath());
            $zip->close();
        }

        $fs->remove($templateDef->getAbsolutePath().$fileName);

        return $this->generateRedirectFromRoute('admin.theme');
    }

    /*
     * Delete a theme
     */
    public function deleteTheme(){
        $themeName = $this->getRequest()->get('theme_name');
        /*
         * we can't delete the default theme
         */

        if(""!==$themeName && "default"!==$themeName){

            $templateType = TemplateDefinition::FRONT_OFFICE;
            $templateDef = new TemplateDefinition('',$templateType);
            $fs = new Filesystem();
            if($fs->exists($templateDef->getAbsolutePath() . $themeName)) {
                $fs->remove($templateDef->getAbsolutePath() . $themeName);

                /*
                 * If the deleted theme was the current theme, we switch on the default theme
                 */
                $frontTemplate = ConfigQuery::create()->findOneByName('active-front-template');
                if($frontTemplate->getValue() === $themeName){
                    $frontTemplate->setValue('default')
                        ->save();
                }

            }

        }

        return $this->generateRedirectFromRoute('admin.theme');
    }

}