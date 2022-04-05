install:
	@composer install
	@cp phpunit.dist.xml phpunit.xml

swap:
	# @composer require --no-update
	# "laravel/framework:${{ matrix.laravel }}" "orchestra/testbench:${{ matrix.testbench }}"

test:
	@vendor/bin/phpunit

test-coverage:
	@vendor/bin/phpunit --config phpunit-coverage.dist.xml --coverage-html coverage

analyze:
	@vendor/bin/phpstan analyse
