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
 * @copyright  Copyright (C) 2016 Vladimir Fishchenko (http://fishchenko.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

var EasyAjax = Class.create(Ajax);

/**
 * Special class to send ajax requests with easy_ajax=1, action_content and custom_content parameters
 *
 * @type {Ajax.Request}
 */
EasyAjax.Request = Class.create(Ajax.Request, {
    request: function ($super, url) {

        var params = this.prepareParams(this.options);

        this.options.parameters = !Object.isString(this.options.parameters) ?
            this.options.parameters :
            this.options.parameters.toQueryParams();

        Object.extend(this.options.parameters, params || {});

        $super(url);
    }
});

/**
 * Prepare additional easy ajax params to send
 *
 * @param Object options
 * @returns {{easy_ajax: 1, ...}}
 */
EasyAjax.Request.prototype.prepareParams = function (options) {
    //add easy_ajax flag
    var params = {"easy_ajax": 1};

    Object.extend(params, this._prepareContentParams("action_content", options) || {});
    Object.extend(params, this._prepareContentParams("custom_content", options) || {});

    return params;
};

/**
 * Prepare content params to send
 *
 * @private
 * @param string key
 * @param Object options
 * @returns Object
 */
EasyAjax.Request.prototype._prepareContentParams = function (key, options) {
    var content = options[key] || [];
    if (Object.isString(content)) {
        content = [content];
    }

    var params = {};
    for (var i = 0; i < content.length; ++i) {
        params[key + "[" + i + "]"] = content[i];
    }

    return params;
};

/**
 * Automatically update data from url using mapping
 *
 * @param string url
 * @param object mapping
 */
EasyAjax.update = function (url, mapping) {
    var content = [];
    for (var key in mapping) {
        if (!mapping.hasOwnProperty(key)) {
            continue;
        }
        content.push(key);
    }
  new EasyAjax.Request(url, {
    method: 'get',
    action_content: content,
    onComplete: function (transport) {
      var json = transport.responseJSON;
      if (typeof json.action_content_data === "undefined") {
        return;
      }
      for (key in mapping) {
        if (!mapping.hasOwnProperty(key)) {
          continue;
        }
        if (!json.action_content_data[key]) {
            continue;
        }
        $$(mapping[key]).invoke('update', json.action_content_data[key]);
      }
    }
  });
};
