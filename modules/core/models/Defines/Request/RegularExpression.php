<?php

namespace application\modules\core\models\Defines\Request;

/**
 * Class RegularExpression
 *
 * @package application\modules\rest\models\Defines\Request
 */
class RegularExpression
{
    /**
     * Regular expression to remove tags from str
     *
     * @var string
     */
    const TEXT_CLEANUP_TAGS = '/(<[a-zA-Z]+(src=?.[a-zA-Z ]+?.|href=?.[a-zA-Z ]+?.|class=?.[a-zA-Z ]+?.| )*\/?>|' .
    '<\/[a-zA-Z]+>)|(<[a-zA-Z]+(src=?.[a-zA-Z ]+?.|href=?.[a-zA-Z ]+?.|class=?.[a-zA-Z ]+?.|)?([\w\W]+?)\/>)/';

    /**
     * SSML tags
     */
    const SSML_TAGS = '<break><emphasis><lang><mark><p><phoneme><prosody><s><say-as><say><speak><sub><w>' .
    '<amazon:breaths><amazon:auto-breaths><amazon:domain<amazon:effect>';

    /**
     * Returns list of attributes, that could be used for xss attacks
     *
     * @return string[]
     */
    public static function xssAttributesList(): array
    {
        return [
            // Window Event Attributes
            'onafterprint',
            'onbeforeprint',
            'onbeforeunload',
            'onerror',
            'onhaschange',
            'onload',
            'onmessage',
            'onoffline',
            'onpagehide',
            'onpageshow',
            'onpopstate',
            'onredo',
            'onresize',
            'onstorage',
            'onundo',
            'onunload',

            // Form Events
            'onblur',
            'onchange',
            'oncontextmenu',
            'onfocus',
            'onformchange',
            'onforminput',
            'oninput',
            'oninvalid',
            'onreset',
            'onselect',
            'onsubmit',

            // Keyboard Events
            'onkeydown',
            'onkeypress',
            'onkeyup',

            // Mouse Events
            'onclick',
            'ondblclick',
            'ondrag',
            'ondragend',
            'ondragenter',
            'ondragleave',
            'ondragover',
            'ondragstart',
            'ondrop',
            'onmousedown',
            'onmousemove',
            'onmouseout',
            'onmouseover',
            'onmouseup',
            'onmousewheel',
            'onscroll',

            // Media Events
            'onabort',
            'oncanplay',
            'oncanplaythrough',
            'ondurationchange',
            'onemptied',
            'onended',
            'onerror',
            'onloadeddata',
            'onloadedmetadata',
            'onloadstart',
            'onpause',
            'onplay',
            'onplaying',
            'onprogress',
            'onratechange',
            'onreadystatechange',
            'onseeked',
            'onseeking',
            'onstalled',
            'onsuspend',
            'ontimeupdate',
            'onvolumechange',
            'onwaiting',
        ];
    }

    /**
     * List of html tags to remove from html
     *
     * @return string[]
     */
    public static function htmlTagsToRemove(): array
    {
        return [
            'applet',
            'script',
            'style',
            'link',
            'iframe',
        ];
    }

    /**
     * List of html tags to leave in html
     *
     * @return string[]
     */
    public static function htmlTagsToLeave(): array
    {
        return [

        ];
    }

    /**
     * Returns regular expression for removing xss attributes from HTML
     *
     * @return string
     */
    public static function xssAttributes(): string
    {
        $attributesList = implode('|', RegularExpression::xssAttributesList());
        return '/((' . $attributesList . ')[ ]*=[ ]*[" ]?)([a-zA-Z0-9:;!&?\.\s\(\)\-\,\'\"]*[" ]?)[ ]?/im';
    }

    /**
     * Expression to remove tags from html
     *
     * @return string
     */
    public static function htmlCleanupExpression(): string
    {
        $tagList = implode('|', RegularExpression::htmlTagsToRemove());

        return '/<(' . $tagList . ').*?>|<\/(' . $tagList . ').*?>/';
    }

    /**
     * Expression to leave tags in html
     *
     * @return string
     */
    public static function htmlLeaveTagsExpression(): string
    {
        $tagList = implode('|', RegularExpression::htmlTagsToLeave());

        return '/<(?!(' . $tagList . ')|\/(' . $tagList . ').*?>/';
    }
}
