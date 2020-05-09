<?php

namespace Core\Templating;

class TemplateBuilder
{
    const TEMPLATE_DIR = __DIR__ . '/../../src/Views/';

    private $template;

    /**
     * @param string $view
     * @param array $params
     * @return false|string
     * @throws \Exception
     */
    public function render(string $view, array $params)
    {
        $this->getExtends($view);

        return $this->getOutput($params);
    }

    /**
     * @param string $view
     * @param array $params
     * @return false|string
     * @throws \Exception
     */
    public function getExtends(string $view): void
    {
        $file = file_get_contents(self::TEMPLATE_DIR . $view);

        if (preg_match("/{{ extends '((?!}}).)+' }}/i", $file, $extends)) {
            preg_match("/'.*'/i", $extends[0], $classToExtends);
            $classToExtends = trim($classToExtends[0], '\'');
        }

        if (!empty($classToExtends)) {
            preg_match_all('/{{ block \'.*\' }}[^}]*}}/i', $file, $blocks);
            $file = file_get_contents(self::TEMPLATE_DIR . $classToExtends);

            foreach ($blocks[0] as $block) {
                if (preg_match("/{{ block '((?!}}).)+' }}/i", $block, $blockName)) {
                    preg_match("/'.*'/i", $blockName[0], $blockName);
                    $blockName = trim($blockName[0], '\'');
                }
                preg_match('/}}[^{]*{{/i', $block, $content);

                $file = preg_replace(
                    "/{{ block '$blockName' }}[^}]*}}/i",
                    trim($content[0], '{}'),
                    $file
                );
            }
        }

        if (preg_match('/}|{/i', $file)) {
            throw new TemplateBuilderException(
                sprintf(
                    "Malformed template, check those points: \n
                        - check mustaches definitions in %s or extends template \n
                        - you didn't redeclare parents blocks",
                    $view
                )
            );
        }

        $this->template = $file;
    }

    /**
     * @param array $params
     * @return false|string
     */
    public function getOutput(array $params)
    {
        if ($params) {
            foreach ($params as $key => $val) {
                $name = $key;
                $$name = $val;
            }
        }

        ob_start();
        echo eval('?>' . $this->template);
        return ob_get_clean();
    }
}