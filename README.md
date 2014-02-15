# Magento Twilio Integration

## About

This extension is an attempt at integrating Magento with Twilio.  The extension is primarily to enable SMS notifications for events that occur in Magento such as new orders and customer signups.  It should also notify customers via SMS for events they'll be interested in such as when their order is shipped out.  The extension is currently in alpha phase and is still being developed.  

### Features:
- SMS Notification to store admin when a new order is placed.
- SMS Notification to store admin when a new customer/subscriber signs up.

## Installation

1. Install module using [modman](https://github.com/colinmollenhour/modman):
	
	```
	cd /path/to/magento/directory  
	modman init  
	modman clone git@github.com:kojoman/magento-twilio-integration.git  
	```

2. Signup for a [twilio](https://www.twilio.com/try-twilio) account if you don't already have one. 

3. Sign into your admin page and go to System -> Configuration -> Services -> Twilio 

4.  Enable the extension and add your Twilio Account SID, Twilio Auth Token and a Verified Twilio Number that will be used to send messages. You can find this information [Twilio's Account Dashboard](https://www.twilio.com/user/account) or check their website for more information.  


### Planned Features / To-Do

-  Send SMS when a new customer signs up
-  Send SMS when a new customer subscribes
-  Send SMS when a new sale is made
-  Send SMS after order is shipped

## Contributing 

As mentioned earlier, this project is still in alpha phase and as a result is not feature-complete as well as having some bugs.  Please use GitHub issues to report any problems and submit pull requests.  The ideal workflow is to fork the repo and create a branch and develop off of that branch.  Then, you can make a pull request.  
