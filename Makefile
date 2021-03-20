test:
	./vendor/bin/phpunit;

analyze:
	./vendor/bin/phpmd ./includes/ text phpmd_rulesets/rulesets.xml;

loc:
	phploc ./ --exclude vendor;

coverage:
	./vendor/bin/phpunit --coverage-text;