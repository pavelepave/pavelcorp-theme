#!/bin/bash
#
curl -X POST \
	-H 'Content-Type: application/json' \
	-d '{
 		"name": "website_message",
  	"label": "Message from user",
  	"description": "Message left by the user on the contact form at junto.fr",
  	"groupName": "contactinformation",
  	"type": "string",
  	"fieldType": "text",
  	"formField": true,
  	"displayOrder": 6,
  	"options": []
	}' \
	"https://api.hubapi.com/properties/v1/contacts/properties?hapikey=$api_key"
