# VF_EasyAjax Module

Allows frontend developers send ajax requests for every page and get Json response.  
You don't need to work with app/code section of Manento and change any PHP code.  
Make all what you need works via Ajax using only layout xmls, theme templates and javascript.  

In the Json response frontend developers can receive:
* All messages that were added to session
* Some blocks from current page layout
* Any block that should be added to special layout xml

CURRENTLY IT WORKS MINIMUM ON 4 PROJECTS  
  
See the example of using Easy Ajax extension: [Ajax Cart extension with only one JS file and without any PHP code](https://github.com/hws47a/VF_AjaxCart).  
  
To easy update this module later, install it from [Magento Connect](http://www.magentocommerce.com/magento-connect/catalog/product/view/id/16401/s/easy-ajax-6790/)
  
Developer: [Vladimir Fishchenko](http://fishchenko.com/)  
  
# What's new?  
  
* Fixed compartability with prototype 1.6 (Magento < 1.6)
* Fixed checking that module is enabled
* Fixed compartability with Magento < 1.6
* Added 'redirect' param with url where controller want to redirect
* Fixed issue with custom layout when cache is enabled
  
  
# How to use:  
  
For any page url add easy_ajax=1 and this page returns json instead of html.  
It returns:  
1. messages: [{type: , code: }] if on this page some message is added to any session model.  
2. action_content_data: {} if you add to params action_content[] with block names  
3. custom_content_data: {} if you add to params custom_content[] with block names

## Custom layout:
You can use additional layout handlers for easy ajax requests:
* \<easy_ajax_default> - blocks from it can be loaded from any easy ajax request
* \<easy_ajax_ROUTE_CONTROLLER_ACTION> - you can specify a layout for each action. blocks from it can be loaded only from ROUTE_CONTROLLER_ACTION request.
  
## Example  
  
For add product to cart via Ajax use default add to cart url and add this params:  
* easy_ajax: 1  
* action_content[0]:cart_sidebar  
* action_content[1]:top.links  

You will get json response with 
* messages: [{type: 'success', code: 'Massage that product was successfully added to cart.'}]  
* action_content_data: {cart_sidebar: "\<div ... \</div>", top.links: "\<ul ... \</ul>"}  
  
So with response data you can simple update needed blocks: 
* cart_sidebar with items recently added to cart
* top.links with count of items near link to My Cart

## Custom layout example

Add to layout handler \<easy_ajax_default> some block with name "test_default"  
Add to layout handler \<easy_ajax_checkout_cart_add> some block with name "test"  
Add to request 2 additional fields:  
* custom_content[0]: test_default
* custom_content[1]: test

You will get response with additional field:
* custom_content_data: {test_default: "...", test: "..."}

## JS Wrapper for requests

Using `EasyAjax.Request` instead of `Ajax.Request` you don't need to specify easy_ajax=1 param and you can add action_content and custom_content params easy.
To add action_content and/or custom_content params just add it to options list as arrays.  

Example:
<pre>        new EasyAjax.Request(href, {
             method: 'post',
             action_content: ['cart_sidebar', 'top.links'],
             parameters: params,
             onComplete: function (transport) {
                //some code...
             }
         });
</pre>

## RESTful requests  
  
Instead of using easy_ajax=1 in params you can use RESTful interface and .json to action name.  
Example: instead of `customer/account/loginPost?easy_ajax=1` you can use `customer/account/loginPost.json`

NOTE: This feature is disabled by default, to enable it just uncomment default/web/routers/json in config.xml
