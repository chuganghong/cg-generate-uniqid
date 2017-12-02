<?php
namespace GlobalIdGenerator;
/**
 * @author cg
 * @date 2017-12-02 20:02
 * @description 分布式系统全局ID生成器
 */

class GlobalIdGenerator
{
	private $timestampPartBit;		// 毫秒时间戳, 41bit，固定的
	private $servicePartBit;		// 业务线, 4bit
	private $engineRoomPartBit;	// 机房，2bit
	private $computerPartBit;		// 机器，7bit
	private $reservePartBit;		// 预留，8bit，减少为6bit
	private $genPartBit;			// 基因，3bit

	public function __construct($servicePartBit, $engineRoomPartBit, $computerPartBit, $reservePartBit, $genPartBit)
	{
		$this->servicePartBit = $servicePartBit;
		$this->engineRoomPartBit = $engineRoomPartBit;
		$this->computerPartBit = $computerPartBit;
		$this->reservePartBit = $reservePartBit;
		$this->genPartBit = $genPartBit;
	}


	// 获取全局ID
	public function getGlobalId($serviceId, $engineRoomId, $computerId, $reserveId, $value)
	{
		$timestampPart = $this->generateTimestampPart();
		$servicePart = $this->generateServicePart($serviceId);
		$engineRoomPart = $this->generateEngineRoomPart($engineRoomId);
		$computerPart = $this->generateComputerPart($computerId);
		$reservePart = $this->generateReservePart($reserveId);
		$genPart = $this->generateGenPart($value);

		var_dump($timestampPart, $servicePart, $engineRoomPart, $computerPart, $reservePart, $genPart);

		$globalId = $timestampPart . $servicePart . $engineRoomPart . $computerPart . $reservePart . $genPart;

		return $globalId;
	}

	private function generateTimestampPart()
	{
		$timestamp = microtime();
		$timestampArr = explode(' ', $timestamp);		
		list($msec, $second) = $timestampArr;
		// $msecTimestamp = sprintf("%d%03d", $second, $msec * 1000);	
		$msecTimestamp = $second * 1000;
		var_dump($second, $msec, $msecTimestamp);
		$msecTimestampDecbin = decbin($msecTimestamp);
		$timestampPart = sprintf("%041d", $msecTimestampDecbin);	

		return $timestampPart;
	}

	private function generateServicePart($serviceId)
	{
		$serviceIdDecbin = decbin($serviceId);
		$bits = $this->servicePartBit;		
		$servicePart = sprintf("%0{$bits}d", $serviceIdDecbin);

		return $servicePart;
	}

	private function generateEngineRoomPart($engineRoomId)
	{
		$engineRoomIdDecbin = decbin($engineRoomId);
		$bits = $this->engineRoomPartBit;
		$engineRoomPart = sprintf("%0{$bits}d", $engineRoomIdDecbin);

		return $engineRoomPart;
	}

	private function generateComputerPart($computerId)
	{
		$computerIdDecbin = decbin($computerId);
		$bits = $this->computerPartBit;
		$computerPart = sprintf("%0{$bits}d", $computerIdDecbin);

		return $computerPart;
	}

	private function generateReservePart($reserveId)
	{
		$reverseIdDecbin = decbin($reserveId);
		$bits = $this->reservePartBit;
		$reservePart = sprintf("%0{$bits}d", $reverseIdDecbin);

		return $reservePart;
	}

	private function generateGenPart($value)
	{
		$md5Str = md5($value, true);
		$suffix = substr($md5Str, -1, 3);

		$genBits = 3;
		$genDecbin = decbin($suffix);
		$genPart = sprintf("%0{$genBits}d", $genDecbin);

		return $genPart;
	}

	public function test()
	{
		/*
		$timestamp = $this->generateTimestampPart();

		var_dump($timestamp);
		var_dump(decbin($timestamp));

		$t = $this->generateServicePart(2);
		var_dump($t);
		*/
	}

}

