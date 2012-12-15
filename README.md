# VF_EasyAjax Module

Allows frontend developers send ajax requests for every page and get Json response.

CURRENTLY UNDER DEVELOPMENT

In the Json response frontend developers can receive:
* All messages that were added to session
* Some block from current page layout
* Any block that should be added to special layout xml

An extension works fast, without load all layout. It loads only needed data.
  
# How to use:  
  
For any page url add easy_ajax=1 and this page returns json instead of html.  
It returns:  
1. {status: , message: } if on this page some message is added to any session model.  
2. {action_content_data: {}} if you add to params action_content[] with block names