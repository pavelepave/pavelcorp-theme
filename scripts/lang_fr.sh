#!/bin/bash

msgfmt ./fr_FR.po -o fr_FR.mo

po2json fr_FR.po pavelcorp-fr_FR-pavelcorpscripts.json -f jed1.x -d pavelcorp -p --fallback-to-msgid
