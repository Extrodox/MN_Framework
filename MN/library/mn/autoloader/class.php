<?php 
class MN_Autoloader_Class{
        private static $object;
        private function __construct(){
            
        }
        public static function factory(){
            if(!(self::$object instanceof self)){
                self::$object=new self();
            }
            return self::$object;
        }
        public static function run() {
            $object=self::factory();
            spl_autoload_register(array($object, 'loader'));
        }
        private function loader($className) {
           try{
                $file=$this->getFileLocation($className);
                require_once $file;

                if(!class_exists($className) && !interface_exists($className)){
                    throw new Exception("No class or interface exist called $className at location :".$file);
                }
            }catch(Exception $e){
                MN_Debug_Class::show($e->getMessage());
                die();
            }            
        }
        private function getFileLocation($class){

            $file=self::fileName($class);
            if(file_exists($file)){
                return $file;
            }else{
                throw new Exception("No such file found at location :".$file);
            }
        }
        public static function fileName($class){
            preg_match("/^[^_]*/",$class,$namespace);
            $n=MN_Namespaces_Class::factory();
            $namespacePath=$n->getPath($namespace[0]);
            $file=preg_replace(array("/^[^_]*/","/_/"),
                    array($namespacePath,DS),
                    strtolower($class));
            //$file.=DS.$this->bootstrapfile;
            return $file.=".php";
        }
    }
    MN_Autoloader_Class::run();

   