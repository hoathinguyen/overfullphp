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

            // Check if run as
            $app = \Bag::route()->getDomainConfig()->getValid();
            
            if($app)
            {
                \Bag::config()->set('app', $app->get());
            }
            else
            {
                \Bag::config()->set('app.base', 0);
                \Bag::config()->set('app.route', '');
            }
            
            if(!file_exists(ROOT.DS.\Bag::config()->get('app.root'))){
                throw new \Overfull\Exception\AppNotFoundException(\Bag::config()->get('app.root'));
            }

            // Get config
            $this->getConfigForApp();

            \Bag::pattern();

            \Bag::event()->sign(\Overfull\Events\EventKeys::START);

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

            \Bag::event()->sign(\Overfull\Events\EventKeys::END);
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
        $func = \Bag::config()->loadApp(\Bag::config()->get('app.alias'), false);

        // Config timezone
        date_default_timezone_set(\Bag::config()->get('core.timezone'));
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