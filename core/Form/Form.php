<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 14/12/18
 * Time: 14:27
 */

namespace Core\Form;

class Form
{
    /**
     * @var string $html
     */
    private $html;

    /**
     * @param array $params
     * @return $this
     * @throws FormException
     */
    public function createForm(array $params)
    {
        if (!$params["method"]) {
            throw new FormException("The method does not exist");
        }

        $this->html = "<form method='" . $params["method"] . "'";
        $this->html .= ">";

        return $this;
    }

    /**
     * @param array $params
     * @return $this
     * @throws FormException
     */
    public function addInput(array $params)
    {
        if (!$params['type'] || !$params['name']) {
            throw new FormException("Please provide a type and a name for input tag");
        }

        $this->html .= "<input type='" . $params["type"] . "' name='" . $params['name'] . "'";
        if (!empty($params['class'])) {
            $this->html .= " class='" . $params['class'] . "'";
        }

        $this->html .= ">";
        return $this;
    }

    /**
     * @return string
     */
    public function renderForm(): string
    {
        return $this->html . "</form>";
    }

}