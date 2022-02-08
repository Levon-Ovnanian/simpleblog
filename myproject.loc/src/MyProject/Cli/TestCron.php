<?php

namespace MyProject\Cli;

class TestCron extends AbstractCommand
{
    private const BIRTH = '01.11.1989';

    protected function checkParams()
    {
        $this->ensureParamExists('name');
        $this->ensureParamExists('date');
        $this->checkDate();
    }

    private function checkDate()
    {
        
        if($this->getParam('name') === 'Levon' AND $this->getParam('date') == self::BIRTH) {
            $this->execute();
        }
       else {echo 'wrong';}
    }

    public function execute()
    {
        var_dump(self::BIRTH);
        file_put_contents('D:\\1.log', $this->getParam('name') . $this->getParam('date'), FILE_APPEND);
    }
}