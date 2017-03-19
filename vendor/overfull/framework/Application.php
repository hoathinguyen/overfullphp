<?php
/*----------------------------------------------------
* The application object class
* This class is highest in framework. First, this class will be call,
* and run some require and logic of framework
* ----------------------------------------------------
*/
namespace Overfull;

class Application extends \Overfull\Foundation\Base\BaseObject
{
    /**
     * __construct
     * @param string $appRoot
     * @param string $appNamespace
     */
    public function __construct($appRoot = 'src/App', $appNamespace = 'src\App')
    {
        \Bag::config()->set('app.root', $appRoot);
        \Bag::config()->set('app.namespace', $appNamespace);
        \Bag::config()->runFile(ROOT.DS.'config'.DS.'main.php');
    }

    /*
    * Run method
    * This method perform all of process on a transaction
    * @return void
    */
    public function run()
    {
        try{
            $this->registerException();
            // Get route info
            \Bag::init();
            $this->getAppConfig();

            if(!file_exists(ROOT.DS.\Bag::config()->get('app.root'))){
                throw new \Overfull\Exception\AppNotFoundException(\Bag::config()->get('app.root'));
            }

            // Get config
            $this->getConfigForApp();
            \Bag::pattern();

            // Get result in route
            \Bag::route()->run();

            if(\Bag::route()->response){
                foreach (\Bag::route()->response as $key => $value) {
                        \Bag::$response->{$key} = $value;
                }
            }

            // Run pattern
            \Bag::pattern()->run();

            // return result
            \Bag::response()->send();
        } catch(\Overfull\Exception\AppNotFoundException $e){
                \Overfull\Exception\Handler\ExceptionHandler::showExceptionObject($e);
        } catch(\Overfull\Exception\ConfigFileNotFoundException $e){
                \Overfull\Exception\Handler\ExceptionHandler::showExceptionObject($e);
        } catch(\Overfull\Exception\PageNotFoundException $e){
                \Overfull\Exception\Handler\ExceptionHandler::showExceptionObject($e);
        } catch(\Overfull\Exception\PatternNotFoundException $e){
                \Overfull\Exception\Handler\ExceptionHandler::showExceptionObject($e);
        } catch(\Exception $e){
                \Overfull\Exception\Handler\ExceptionHandler::showExceptionObject($e);
        }
    }

    /*
    * Get config method
    * This method will be call config object and set value config to this config object.
    */
    private function getConfigForApp()
    {
        $func = \Bag::config()->loadApp(\Bag::config()->get('app.as'), false);
    }

    /*
    * Get config method
    * This method will be call config object and set value config to this config object.
    */
    private function getAppConfig()
    {
        // Check if have config in app
        if(!empty($app = \Bag::config()->get('domain')))
        {
            $uri = \Bag::request()->uriArray();
            $currentDomain = strtolower(\Bag::request()->host());
            foreach ($app as $key => $config) {
                if(is_object($config)){
                    $config = $config();
                }

                // Check if is list of domain
                if(is_numeric($key)){
                    foreach ($config['domain'] as $domain) {
                        if($this->isValidDomain($domain, $currentDomain, $uri, $config)){
                            return;
                        }
                    }
                } else {
                    if($this->isValidDomain($key, $currentDomain, $uri, $config)){
                        return;
                    }
                }
            }
        }

        $config['base'] = 0;
        $config['route'] = '';
        $config['root'] = \Bag::config()->get('app.root');
        $config['namespace'] = \Bag::config()->get('app.namespace');
        \Bag::config()->set('app', $config);
    }

    /**
     * IsValidDomain
     * This method check url is valid
     * @param string $domain
     * @param string $currentDomain
     * @param array $uri
     * @param array $config
     * @return boolean
     */
    private function isValidDomain($domain, $currentDomain, $uri, $config)
    {
        if(is_string($config)){
                $keyValDo = explode(";", $config);
                $config = [];
                foreach ($keyValDo as $appOrRootValue) {
                    $appExplode = explode('=', $appOrRootValue);
                    $config[$appExplode[0]] = $appExplode[1];
                }
        }

        $regex = str_replace('{sub}', '([a-zA-Z0-9\-]+)', $domain);
        $regex = str_replace('{domain}', '([a-zA-Z0-9\-]+)', $regex);
        $regex = str_replace('{ext}', '([a-zA-Z0-9]+)', $regex);
        $regex = str_replace('{folder}', '([a-zA-Z0-9\-]+)', $regex);
        // $regex = preg_replace("/\W+/", '\\$1', $regex);
        // $regex = str_replace('[', '|(', $regex);
        // $regex = str_replace(']', ')', $regex);

        $exRegex = explode('/', $regex);
        $base = count($exRegex) - 1;

        // Check if correct domain
        if(preg_match("/^".$exRegex[0]."$/", $currentDomain)){
            array_shift($exRegex);
            if(count($exRegex) > 0){
                    $isValid = true;
                    $prefix = '';
                    foreach ($exRegex as $index => $folder) {
                        if(empty($uri[$index]) || !preg_match("/^".$folder."$/", strtolower($uri[$index]))){
                            $isValid = false;
                            break;
                        }
                        $prefix = ($prefix != '') ? $prefix.'/'.$uri[$index] : $uri[$index];
                    }

                    if($isValid){
                        //$prefix = explode('/', $key);
                        $config['base'] = $base;
                        $config['prefix'] = $prefix;
                        \Bag::config()->set('app', $config);
                        return true;
                    }
            } else {
                $config['base'] = $base;
                $config['prefix'] = '';
                \Bag::config()->set('app', $config);
                return true;
            }
        }
        return false;
    }
    
    /*
    * Get config method
    * This method will be call config object and set value config to this config object.
    */
    private function registerException()
    {
        @set_exception_handler(array('\Overfull\Exception\Handler\ExceptionHandler','exceptionHandler'));

        @set_error_handler(array('\Overfull\Exception\Handler\ExceptionHandler','errorHandler'));

        @register_shutdown_function(array('\Overfull\Exception\Handler\ExceptionHandler','shutdown'));
    }
}