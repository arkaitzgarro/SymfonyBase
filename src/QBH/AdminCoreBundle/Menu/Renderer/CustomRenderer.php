<?php

/**
 * This file is part of the Symfony Base project, and it's based on Elcodi project
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Arkaitz Garro <hola@arkaitzgarro.com>
 */
namespace QBH\AdminCoreBundle\Menu\Renderer;

use Knp\Menu\Renderer\RendererInterface;
use Knp\Menu\Renderer\Renderer;
use Knp\Menu\ItemInterface;

class CustomRenderer extends Renderer implements RendererInterface {

    protected $charset = 'UTF-8';
    protected $defaultOptions;

    /**
     * @param string $charset
     */
    public function __construct($charset = null)
    {
        $this->defaultOptions= array(
            'depth' => null,
            'currentAsLink' => true,
            'currentClass' => 'active',
            'ancestorClass' => 'open active',
            'firstClass' => 'first',
            'lastClass' => 'last',
            'compressed' => false,
            'allow_safe_labels' => false,
            'icon' => 'list'
        );

        if (null !== $charset) {
            $this->charset = (string) $charset;
        }
    }

    /**
     * Renders a menu with the specified renderer.
     *
     * @param \Knp\Menu\ItemInterface $item
     * @param array $options
     * @return string
     */
    public function render(ItemInterface $item, array $options = array())
    {
        $options = array_merge($this->defaultOptions, $options);

        return $this->renderList($item, $item->getChildrenAttributes(), $options);
    }

    protected function renderList(ItemInterface $item, array $attributes, array $options)
    {
        /**
         * Return an empty string if any of the following are true:
         *   a) The menu has no children eligible to be displayed
         *   b) The depth is 0
         *   c) This menu item has been explicitly set to hide its children
         */
        if (!$item->hasChildren() || 0 === $options['depth'] || !$item->getDisplayChildren()) {
            return '';
        }

        $html = $this->format('<ul>', 'ul', $item->getLevel(), $options);
        $html .= $this->renderChildren($item, $options);
        $html .= $this->format('</ul>', 'ul', $item->getLevel(), $options);

        return $html;
    }

    /**
     * Renders all of the children of this menu.
     *
     * This calls ->renderItem() on each menu item, which instructs each
     * menu item to render themselves as an <li> tag (with nested ul if it
     * has children).
     * This method updates the depth for the children.
     *
     * @param \Knp\Menu\ItemInterface $item
     * @param array $options The options to render the item.
     * @return string
     */
    protected function renderChildren(ItemInterface $item, array $options)
    {
        // render children with a depth - 1
        if (null !== $options['depth']) {
            $options['depth'] = $options['depth'] - 1;
        }

        $html = '';
        foreach ($item->getChildren() as $child) {
            $html .= $this->renderItem($child, $options);
        }

        return $html;
    }

    /**
     * Called by the parent menu item to render this menu.
     *
     * This renders the li tag to fit into the parent ul as well as its
     * own nested ul tag if this menu item has children
     *
     * @param \Knp\Menu\ItemInterface $item
     * @param array $options The options to render the item
     * @return string
     */
    protected function renderItem(ItemInterface $item, array $options)
    {
        // if we don't have access or this item is marked to not be shown
        if (!$item->isDisplayed()) {
            return '';
        }

        // create an array than can be imploded as a class list
        $class = (array) $item->getAttribute('class');

        if ($item->isCurrent()) {
            $class[] = $options['currentClass'];
        } else {
            $class[] = $options['ancestorClass'];
        }

        // if ($item->actsLikeFirst()) {
        //     $class[] = $options['firstClass'];
        // }
        // if ($item->actsLikeLast()) {
        //     $class[] = $options['lastClass'];
        // }

        // retrieve the attributes and put the final class string back on it
        $attributes = $item->getAttributes();
        if (!empty($class)) {
            $attributes['class'] = implode(' ', $class);
        }

        // opening li tag
        $html = $this->format('<li'.$this->renderHtmlAttributes($attributes).'>', 'li', $item->getLevel(), $options);

        // render the text/link inside the li tag
        //$html .= $this->format($item->getUri() ? $item->renderLink() : $item->renderLabel(), 'link', $item->getLevel());
        $html .= $this->renderLink($item, $options);

        // renders the embedded ul
        $childrenClass = (array) $item->getChildrenAttribute('class');
        $childrenClass[] = 'menu_level_'.$item->getLevel();

        $childrenAttributes = $item->getChildrenAttributes();
        $childrenAttributes['class'] = implode(' ', $childrenClass);

        $html .= $this->renderList($item, $childrenAttributes, $options);

        // closing li tag
        $html .= $this->format('</li>', 'li', $item->getLevel(), $options);

        return $html;
    }

    /**
     * Renders the link in a a tag with link attributes or
     * the label in a span tag with label attributes
     *
     * Tests if item has a an uri and if not tests if it's
     * the current item and if the text has to be rendered
     * as a link or not.
     *
     * @param \Knp\Menu\ItemInterface $item The item to render the link or label for
     * @param array $options The options to render the item
     * @return string
     */
    protected function renderLink(ItemInterface $item, array $options = array())
    {
        if ($item->getUri() && (!$item->isCurrent() || $options['currentAsLink'])) {
            $text = $this->renderLinkElement($item, $options);
        } else {
            $text = $this->renderSpanElement($item, $options);
        }

        return $this->format($text, 'link', $item->getLevel(), $options);
    }

    protected function renderLinkElement(ItemInterface $item, array $options)
    {
        return sprintf('<a href="%s"%s>%s</span></a>', $this->escape($item->getUri()), $this->renderHtmlAttributes($item->getLinkAttributes()), $this->renderLabel($item, $options));
    }

    protected function renderSpanElement(ItemInterface $item, array $options)
    {
        return sprintf('<a href="#"%s><i class="fa fa-th-%s"></i><span>%s</span><i class="arrow fa fa-chevron-right"></i></a>', $this->renderHtmlAttributes($item->getLabelAttributes()), $options['icon'], $this->renderLabel($item, $options));
    }

    protected function renderLabel(ItemInterface $item, array $options)
    {
        if ($options['allow_safe_labels'] && $item->getExtra('safe_label', false)) {
            return $item->getLabel();
        }

        return $this->escape($item->getLabel());
    }

    /**
     * If $this->renderCompressed is on, this will apply the necessary
     * spacing and line-breaking so that the particular thing being rendered
     * makes up its part in a fully-rendered and spaced menu.
     *
     * @param  string $html The html to render in an (un)formatted way
     * @param  string $type The type [ul,link,li] of thing being rendered
     * @param integer $level
     * @param array $options
     * @return string
     */
    protected function format($html, $type, $level, array $options)
    {
        if ($options['compressed']) {
            return $html;
        }

        switch ($type) {
            case 'ul':
            case 'link':
                $spacing = $level * 4;
                break;

            case 'li':
                $spacing = $level * 4 - 2;
                break;
        }

        return str_repeat(' ', $spacing).$html."\n";
    }
}
?>