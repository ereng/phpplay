<?php
namespace Tests\Unit;

use Tests\SetUp;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APIAuthTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->registrationData=array(
			"name"=>'Some Random Fellow',
			"email"=>'some@random.fellow',
			"password"=>'password',
		);

		$this->loginData=array(
			"username"=>'admin@blis.local',
			"password"=>'password',
		);
	}

	public function testRegister()
	{
		$response=$this->post('/api/register',$this->registrationData);
		$this->assertEquals(201,$response->getStatusCode());
	}
}