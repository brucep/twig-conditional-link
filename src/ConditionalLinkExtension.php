<?php

namespace Brucep\Twig\ConditionalLink;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ConditionalLinkExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'conditional_link',
                [$this, 'conditionalLink'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    public function conditionalLink(
        ?string $text,
        bool $condition,
        ?string $href,
        array $attr = [],
        bool $rawText = false): string
    {
        if (!$rawText) {
            $text = htmlspecialchars($text, ENT_NOQUOTES | ENT_HTML5, '', false);
        }

        if (!$condition) {
            return $text;
        }

        foreach ($attr as $key => &$value) {
            $value = sprintf(
                ' %s="%s"',
                htmlspecialchars($key, ENT_QUOTES | ENT_HTML5),
                htmlspecialchars($value, ENT_QUOTES | ENT_COMPAT | ENT_HTML5)
            );
        }

        return sprintf('<a href="%s"%s>%s</a>', $href, implode('', $attr), $text);
    }
}
