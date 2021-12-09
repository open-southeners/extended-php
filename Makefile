install:
	@composer install

swap:
	# @composer require --no-update
	# "laravel/framework:${{ matrix.laravel }}" "orchestra/testbench:${{ matrix.testbench }}"

test:
	@vendor/bin/phpunit

analyze:
	@vendor/bin/phpstan
