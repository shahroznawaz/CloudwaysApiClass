<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

Class CloudwaysAPI
	{
	private $client = null;
	const API_URL = "https://api.cloudways.com/api/v1";
	protected $auth_key;
	protected $auth_email;
	protected $accessToken;

	public function __construct($email, $key)
		{
		$this->auth_email = $email;
		$this->auth_key = $key;
		$this->client = new Client();
		$this->prepareAccessToken();
		}

	public

	function prepareAccessToken()
		{
		try
			{
			$url = self::API_URL . "/oauth/access_token";
			$data = ['email' => $this->auth_email, 'api_key' => $this->auth_key];
			$response = $this->client->post($url, ['query' => $data]);
			$result = json_decode($response->getBody()->getContents());
			$this->accessToken = $result->access_token;
			}

		catch(RequestException $e)
			{
			$response = $this->StatusCodeHandling($e);
			return $response;
			}
		}

	public

	function statusCodeHandling($e)
		{
		if ($e->getResponse()->getStatusCode() == '400')
			{
			$this->PrepareAccessToken();
			}
		elseif ($e->getResponse()->getStatusCode() == '422')
			{
			$response = json_decode($e->getResponse()->getBody(true)->getContents());
			return $response;
			}
		elseif ($e->getResponse()->getStatusCode() == '500')
			{
			$response = json_decode($e->getResponse()->getBody(true)->getContents());
			return $response;
			}
		elseif ($e->getResponse()->getStatusCode() == '401')
			{
			$response = json_decode($e->getResponse()->getBody(true)->getContents());
			return $response;
			}
		elseif ($e->getResponse()->getStatusCode() == '403')
			{
			$response = json_decode($e->getResponse()->getBody(true)->getContents());
			return $e->getResponse()->getStatusCode();
			}
		}

	public function getServers()
		{
		try
			{
			$url = self::API_URL . "/server";
			$option = array(
				'exceptions' => false
			);
			$header = array(
				'Authorization' => 'Bearer ' . $this->accessToken
			);
			$response = $this->client->get($url, array(
				'headers' => $header
			));
			$result = json_decode($response->getBody()->getContents());
			return $result;
			}

		catch(RequestException $e)
			{
			$response = $this->StatusCodeHandling($e);
			return $response;
			}
		}

		public function deleteServer($serverId)
{
	try
	{
		$url = self::API_URL . "/server/$serverId";
		$option = array('exceptions' => false);
		$header = array('Authorization'=>'Bearer ' . $this->accessToken);
		$response = $this->client->delete($url, array('headers' => $header));
		$result = json_decode($response->getBody()->getContents());
		return $result;
	}
	catch (RequestException $e)
	{
		$response = $this->StatusCodeHandling($e);
		return $response;
	}
}

	public function getServerSettings($serverId)
{
	try
	{
		$url = self::API_URL . "/server/manage/settings";
		$option = array('exceptions' => false);
		$data = ['server_id' => $server_id];
		$header = array('Authorization'=>'Bearer ' . $this->accessToken);
		$response = $this->client->get($url, array('query' => $data, 'headers' => $header));
		$result = json_decode($response->getBody()->getContents());
		return $result;
	}
	catch (RequestException $e)
	{
		$response = $this->StatusCodeHandling($e);
		return $response;
	}
}
 
public function setServersSettings($serverid,$datetimezone,$displayerrors,$apc_shmsize,$executionlimit,$memorylimit,$maxinput_vars,$maxinput_time,$modxdebug,$uploadsize)
{
	try
	{
		$url = self::API_URL . "/server/manage/settings";
		$option = array('exceptions' => false);
		$data = [
					'server_id' => $serverid,
					'date_timezone' => $datetimezone,
					'display_errors' => $displayerrors,
					'apc_shm_size' => $apc_shmsize,
					'execution_limit' => $executionlimit,
					'memory_limit' => $memorylimit,
					'max_input_vars' => $maxinput_vars,
					'max_input_time' => $maxinput_time,
					'mod_xdebug' => $modxdebug,
					'upload_size' => $uploadsize
				];
		$header = array('Authorization'=>'Bearer ' . $this->accessToken);
		$response = $this->client->post($url, array('query' => $data, 'headers' => $header));
		$result = json_decode($response->getBody()->getContents());
		return $result;
	}
	catch (RequestException $e)
	{
		$response = $this->StatusCodeHandling($e);
		return $response;
	}
}

	public

	function getApplications()
		{
		try
			{
			$url = self::API_URL . "/apps";
			$header = array(
				'Authorization' => 'Bearer ' . $this->accessToken
			);
			$response = $this->client->get($url, array(
				'headers' => $header
			));
			return json_decode($response->getBody()->getContents());
			}

		catch(RequestException $e)
			{
			$response = $this->StatusCodeHandling($e);
			return $response;
			}
		}

	public

	function addApplication($serverid, $application, $app_version, $app_name)
		{
		try
			{
			$url = self::API_URL . "/app";
			$data = ['server_id' => $serverid, 'application' => $application, 'app_version' => $app_version, 'app_label' => $app_name];
			$header = array(
				'Authorization' => 'Bearer ' . $this->accessToken
			);
			$response = $this->client->post($url, array(
				'query' => $data,
				'headers' => $header
			));
			return json_decode($response->getBody()->getContents());
			}

		catch(RequestException $e)
			{
			$response = $this->StatusCodeHandling($e);
			return $response;
			}
		}

	public

	function deleteApplication($serverid, $applicationid)
		{
		try
			{
			$url = self::API_URL . "/app/$applicationid";
			$data = ['server_id' => $serverid];
			$header = array(
				'Authorization' => 'Bearer ' . $this->accessToken
			);
			$response = $this->client->delete($url, array(
				'query' => $data,
				'headers' => $header
			));
			return json_decode($response->getBody()->getContents());
			}

		catch(RequestException $e)
			{
			$response = $this->StatusCodeHandling($e);
			return $response;
			}
		}
	} ?>
