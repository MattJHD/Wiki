<?php

namespace WikiBundle\Upload;

use WikiBundle\Entity\Article;
//use WikiBundle\Entity\User;

/**
 * Class ContactMailer
 *
 */
class UploadFile
{
    private $kernelRootDir;
    
    public function __construct($kernelRootDir )      
    {
        $this->kernelRootDir = $kernelRootDir;
    }
    
    public function uploadArticle(Article $article)
    {
        if(null !== $file = $article->getMedia())
            {
                $path=$this->upload($file, '/img/Article/', $article->getPathname() );
                
                $article->setPathname($path);
                
                $article->setMedia(null);
            }
    }
    
            
            
            private function upload($file, $chemin, $currentPath)
            {
                
                        $appPath = $this->kernelRootDir;

                        $webPath = $appPath . '/../web';

                        $imgPath = $webPath . $chemin;

                        if(null === $currentPath)
                        {
                            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                        }else{
                            $filename = basename($webPath . $currentPath);
                        }
                        dump($file);
                        die();

                        $file->move($imgPath, $filename);

                        return $chemin . $filename;
                    
            }
    
    
}
