# File:		Makefile
# Author:	Honza Remes (xremes00@stud.fit.vutbr.cz)
# Project:	VIP Posts
#
# This Makefile is created to automate deploying the extension

ZIPNAME = vipposts.zip

USED = acp \
	   adm \
	   composer.json \
	   config \
	   event \
	   language \
	   LICENSE \
	   migrations \
	   styles

.PHONY: all pack clean

all: pack

pack:
	$(MAKE) clean
	mkdir -p ext/ciakval/vipposts
	cp -r $(USED) ext/ciakval/vipposts
	zip -r $(ZIPNAME) ext

clean:
	rm -rf ext $(ZIPNAME)
