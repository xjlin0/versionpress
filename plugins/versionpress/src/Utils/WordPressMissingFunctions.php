<?php

namespace VersionPress\Utils;

class WordPressMissingFunctions
{

    public static function getWpConfigPath()
    {
        $defaultWpConfigPath = realpath(ABSPATH . 'wp-config.php');
        $elevatedWpConfigPath = realpath(dirname(ABSPATH) . '/wp-config.php');

        if (is_file($defaultWpConfigPath)) {
            return $defaultWpConfigPath;
        }

        return $elevatedWpConfigPath;
    }

    public static function renderShortcode($shortcodeTag, $attributes)
    {
        $renderedAttributes = [];

        foreach ($attributes as $attribute => $value) {
            $renderedAttributes[] = sprintf('%s="%s"', $attribute, $value);
        }

        return sprintf('[%s %s]', $shortcodeTag, join(' ', $renderedAttributes));
    }

    public static function pipeAction($source, $destination)
    {
        return add_action($source, function () use ($destination) {
            $args = func_get_args();
            array_unshift($args, $destination);

            return call_user_func_array('do_action', $args);
        });
    }

}
