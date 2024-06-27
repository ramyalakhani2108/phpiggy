<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine
{
    public function __construct(private string $basePath)
    {
    }


    public function render(string $template, array $data = [])
    {
        // $secret = "dsasadss"; //we cannot pass the variable like this to the file we wanted 
        extract($data, EXTR_SKIP); //this function is very help ful it will take every key as variable and make it variable and assign value to it

        // output buffers : 
        // we may want to wait for everyline of PHP code to be executed after the php is finished  running.
        //this feature called output buffer
        //it instructs php not to send the document in bits and pieces 
        // instead , the content will stored in memory after the   code finished running, the content will be sent to the browser. 
        // it can be stored in a variable as a string and we can return it from the function

        ob_start(); //this will prevent php to sending code to the browser until we finished running the code or output buffering stop command 





        include $this->resolve($template);
        // directly include the file doesn't give developer to perform action further on for that purpose "output buffers" are used 

        $output = ob_get_contents(); //it will return the content of output buffer

        ob_end_clean(); //it will stop outputbuffering to stop running and make it buffer cleaning

        return $output;
    } //this is just a custom method to render file using simple include statement 

    public function resolve(string $path)
    {
        return "{$this->basePath}/{$path}";
    }
}
