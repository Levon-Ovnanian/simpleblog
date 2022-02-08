<?php
namespace MyProject\View;

class View
{
    private $templatesPath;
    private $extraVars = [];
    
    /**
     * Undocumented function
     *
     * @param string $templatesPath
     */
    public function __construct(string $templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @param [type] $value
     * @return void
     */
    public function setVar(string $name, $value): void
    {
        $this->extraVars[$name] = $value;
    }

    /**
     * Undocumented function
     *
     * @param [type] $data
     * @param integer $code
     * @return void
     */
    public function displayJson($data, int $code = 200)
    {
        header('Content-type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode($data);
    }

    /**
     * Undocumented function
     *
     * @param string $templateName
     * @param array $vars
     * @param integer $code
     * @return void
     */
    public function renderHtml(string $templateName, array $vars = [], int $code = 200): void
    {
        http_response_code($code);

        extract($this->extraVars);
        extract($vars);
        ob_start();
        include $this->templatesPath  . '/' . $templateName;
        $buffer = ob_get_contents();
        ob_end_clean();
        
        echo $buffer;   
    }
}
