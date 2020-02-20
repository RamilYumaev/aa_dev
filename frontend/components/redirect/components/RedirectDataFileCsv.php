<?php
namespace frontend\components\redirect\components;

use yii\helpers\Url;
use frontend\components\redirect\components\interfaces\IRedirectNewUrl;

class RedirectDataFileCsv  implements  IRedirectNewUrl
{ 

    public $fileObject; 
    
     /**
     * @var string
     */
    private  $url;
    
    /**
     * RedirectDataFileCsv  constructor.
     *
     * @param string $file
     */
   
    public function __construct($file) {
       $ext = pathinfo($file, PATHINFO_EXTENSION);
        if ($ext === 'csv' && file_exists($file)) {
         $this->fileObject = new \SplFileObject($file);
         $this->fileObject->setFlags(\SplFileObject::READ_CSV);
        } else {
            echo 'not is file '.$file;
        }
    }
    
    /**
     * @return string
     */

    public function getUrlTo () : string
    {
        return $this->url = Url::to();        
    }
 
    /**
     * @return array
     */
    private function getData(): array
    {       
        $data = [];
            while (!$this->fileObject->eof()) {
                $data[] = $this->fileObject->fgetcsv();
                $this->fileObject->next();
            }
    
        return $data;
    }

    private function filterUrl () 
    {
    if (!empty($this->getUrlTo())) {
            $data = array_filter($this->getData(), function ($value) {
                $conditions = [true];
                    $conditions[] = strpos($value[0], $this->url) !== false;
                return array_product($conditions);
            });
         return $data;
         }
    }
    
    /**
     * @return string
     */

    public function newUrl() : string
     {
        $string = "";
        foreach ($this->filterUrl() as $url) {
            if (strpos($url[2], "301") !== false) {
                $string = $url[1];
            }
        } 
        return $string;
    }
    
}