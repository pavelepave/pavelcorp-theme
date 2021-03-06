#!/usr/local/bin/node

var https = require('https');
var parser = require('node-html-parser');
var path = require('path');
var fs = require('fs');

var req = https.request(process.argv[2], function(res) {
	var body = '';

	res.on('data', function(chunk) {
		body += chunk.toString();
	});

	res.on('end', function() {
		var html = parser.parse(body);
		var bg = html.querySelector('[data-bg]')._attrs['data-bg'];
		var filename = path.basename(bg);


		https.request(bg, function(img) {
			img.pipe(fs.createWriteStream('./Downloads/' + filename)).on('close', function() {
				console.log('downloaded %s, ', filename)
			});
		}).end();

	});

	res.on('error', function() {
		console.log('error with %s', link)
	})
});

req.end();