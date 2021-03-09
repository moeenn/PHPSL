test:
	./vendor/bin/phpunit

analyze:
	./vendor/bin/phpmd ./includes/ json rulesets.xml
	./vendor/bin/phpmd ./tests/ json rulesets.xml