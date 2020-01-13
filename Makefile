VERSION_FILE=VERSION
VER=`cat $(VERSION_FILE)`

release: init prepare archive cleanup

init:
	mkdir dist

prepare:
	cp VERSION payabbhi
	zip -r payabbhi.zip payabbhi
	markdown-pdf README.md


archive:
	zip -r payabbhi-opencart-$(VER).zip payabbhi.zip README.pdf
	tar -cvzf payabbhi-opencart-$(VER).tar.gz payabbhi.zip README.pdf


cleanup:
	mv payabbhi-opencart-$(VER).zip dist
	mv payabbhi-opencart-$(VER).tar.gz dist
	rm payabbhi/VERSION
	rm README.pdf
	rm payabbhi.zip


clean:
	rm -rf dist
