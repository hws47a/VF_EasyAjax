/**
 * Vladimir Fishchenko extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   design
 * @package    base_default
 * @copyright  Copyright (C) 2012 Vladimir Fishchenko (http://fishchenko.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

var EasyAjax = Class.create(Ajax);

EasyAjax.Request = Class.create(Ajax.Request, {
    initialize: function($super, url, options) {
        this.action_content = options.action_content || [];
        this.custom_content = options.custom_content || [];
        $super(url, options);
    },
    request: function ($super, url)
    {
        var params = !Object.isString(this.options.parameters) ?
            this.options.parameters :
            this.options.parameters.toQueryParams();

        //add easy_ajax flat
        params['easy_ajax']= 1;

        //add action content params
        var actionContent = this.action_content;
        if (Object.isString(actionContent)) {
            actionContent = [actionContent];
        }
        for (var i = 0; i < actionContent.length; ++i) {
            params['action_content[' + i + ']'] = actionContent[i];
        }

        //add custom content params
        var customContent = this.custom_content;
        if (Object.isString(customContent)) {
            customContent = [customContent];
        }
        for (var i = 0; i < customContent.length; ++i) {
            params['custom_content[' + i + ']'] = customContent[i];
        }

        this.options.parameters = params;

        $super(url);
    }
});
