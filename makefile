.PHONY: provision install assets

BIN=node_modules/.bin

THEME=content/themes/vac
SRC_DIR=$(THEME)/assets/src

JS_SRC=$(THEME)/assets/src/js
JS_BUNDLE=$(THEME)/assets/build/js
BROWSERIFY_DEPS=$(wildcard $(JS_SRC)/vac-main.js $(JS_SRC)/*.js $(JS_SRC)/**/*.js)

SASS_DIR=$(THEME)/assets/src/sass
CSS_DIR=$(THEME)/assets/build/css
SASS_DEPS=$(wildcard $(SASS_DIR)/vac-styles.scss $(SASS_DIR)/**/*.scss)

provision:
	@sh install.sh
	@vagrant up

server:
	@vagrant up

install: ./package.json
	@npm install --verbose

assets: $(JS_BUNDLE)/vac-bundle.js $(CSS_DIR)/vac-styles.css

develop: $(SRC_DIR)
	@$(BIN)/watch "make assets" $<

$(JS_BUNDLE)/vac-bundle.js: $(BROWSERIFY_DEPS)
	@$(BIN)/browserify $< -o $@

$(CSS_DIR)/vac-styles.css: $(SASS_DEPS)
	@$(BIN)/node-sass $< -o $(CSS_DIR)
