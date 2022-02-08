<?php
namespace MyProject\Services;

use MyProject\Models\Users\User;

class EmailSender
{
    /**
     * Undocumented function
     *
     * @param User $receiver
     * @param string $subject
     * @param string $templateName
     * @param array $templateVars
     * @return void
     */
    public static function send(
        User $receiver,
        string $subject,
        string $templateName,
        array $templateVars = []
    ): void
    {
        extract($templateVars);

        ob_start();
        require __DIR__ . '/../../../templates/mail/' . $templateName;
        $body = ob_get_contents();
        ob_end_clean();
    
        mail($receiver->getEmail(), $subject, $body, 'Content-Type: text/html; charset=UTF-8');  
    }
      
    /**
     * Undocumented function
     *
     * @param array $receivers
     * @param string $subject
     * @param string $templateName
     * @param array $templateVars
     * @return void
     */
    public static function multiplePostageToFollowers(
        array $receivers,
        string $subject,
        string $templateName,
        array $templateVars = []  
    ): void
    {
        for ($index = 0; $index != count($receivers); $index++) {
            extract($templateVars);
            
            ob_start();
            require __DIR__ . '/../../../templates/mail/' . $templateName;
            $body = ob_get_contents();
            ob_end_clean();
            mail($receivers[$index]->getFollowerEmail(), $subject, $body, 'Content-Type: text/html; charset=UTF-8');
        }  
    }  
}