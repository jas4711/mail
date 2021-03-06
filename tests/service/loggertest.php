<?php

namespace OCA\Mail\Tests\Service;

use OCA\Mail\Service\Logger;

class LoggerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider providesLoggerMethods
	 * @param $method
	 */
	public function testLoggerMethod($method, $param = '1') {

		$baseLogger = $this->getMock('\OCP\ILogger');
		$baseLogger->expects($this->once())
			->method($method)
			->with(
				$this->equalTo($param),
				$this->equalTo([
					'app' => 'mail',
					'key' => 'value',
				]));

		$logger = new \OCA\Mail\Service\Logger('mail', $baseLogger);
		$logger->$method($param, ['key' => 'value']);
    }

	public function providesLoggerMethods() {

		$methods = [
			['alert'],
			['warning'],
			['emergency'],
			['critical'],
			['error'],
			['notice'],
			['info'],
			['debug'],
		];
		if (version_compare(implode('.', \OCP\Util::getVersion()), '8.2', '>=')) {
			$methods[]= ['logException', new \Exception()];
		}

		return $methods;
	}

}
