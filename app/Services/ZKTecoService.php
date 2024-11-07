<?php

namespace App\Services;

use Rats\Zkteco\Lib\ZKTeco;

class ZKTecoService
{
    protected $zk;

    /**
     * ZKTecoService constructor.
     *
     * @param string $ip Device IP Address
     * @param int $port Device Port (default 4370)
     */
    public function __construct(string $ip, int $port = 4370)
    {
        $this->zk = new ZKTeco($ip, $port);
    }

    /**
     * Connect to the device.
     *
     * @return bool
     */
    public function connect(): bool
    {
        return $this->zk->connect();
    }

    /**
     * Disconnect from the device.
     *
     * @return bool
     */
    public function disconnect(): bool
    {
        return $this->zk->disconnect();
    }

    /**
     * Enable the device.
     *
     * @return bool
     */
    public function enableDevice(): bool
    {
        return $this->zk->enableDevice();
    }

    /**
     * Disable the device.
     *
     * @return bool
     */
    public function disableDevice(): bool
    {
        return $this->zk->disableDevice();
    }

    /**
     * Get the device version.
     *
     * @return mixed
     */
    public function getDeviceVersion()
    {
        return $this->zk->version();
    }

    /**
     * Get the device OS version.
     *
     * @return mixed
     */
    public function getDeviceOsVersion()
    {
        return $this->zk->osVersion();
    }

    /**
     * Power off the device.
     *
     * @return bool
     */
    public function powerOff(): bool
    {
        return $this->zk->shutdown();
    }

    /**
     * Restart the device.
     *
     * @return bool
     */
    public function restartDevice(): bool
    {
        return $this->zk->restart();
    }

    /**
     * Put the device to sleep.
     *
     * @return bool
     */
    public function sleepDevice(): bool
    {
        return $this->zk->sleep();
    }

    /**
     * Resume the device from sleep.
     *
     * @return bool
     */
    public function resumeDevice(): bool
    {
        return $this->zk->resume();
    }

    /**
     * Perform a voice test.
     *
     * @return bool
     */
    public function testVoice(): bool
    {
        return $this->zk->testVoice();
    }

    /**
     * Get the platform.
     *
     * @return mixed
     */
    public function getPlatform()
    {
        return $this->zk->platform();
    }

    /**
     * Get the firmware version.
     *
     * @return mixed
     */
    public function getFirmwareVersion()
    {
        return $this->zk->fmVersion();
    }

    /**
     * Get the work code.
     *
     * @return mixed
     */
    public function getWorkCode()
    {
        return $this->zk->workCode();
    }

    /**
     * Get the SSR.
     *
     * @return mixed
     */
    public function getSSR()
    {
        return $this->zk->ssr();
    }

    /**
     * Get the pin width.
     *
     * @return mixed
     */
    public function getPinWidth()
    {
        return $this->zk->pinWidth();
    }

    /**
     * Get the device serial number.
     *
     * @return mixed
     */
    public function getSerialNumber()
    {
        return $this->zk->serialNumber();
    }

    /**
     * Get the device name.
     *
     * @return mixed
     */
    public function getDeviceName()
    {
        return $this->zk->deviceName();
    }

    /**
     * Get the device time.
     *
     * @return mixed
     */
    public function getDeviceTime()
    {
        return $this->zk->getTime();
    }

    /**
     * Set the device time.
     *
     * @param string $time Format "Y-m-d H:i:s"
     * @return bool
     */
    public function setDeviceTime(string $time): bool
    {
        return $this->zk->setTime($time);
    }

    /**
     * Get users from the device.
     *
     * @return array
     */
    public function getUsers(): array
    {
        return $this->zk->getUser();
    }

    /**
     * Set a user on the device.
     *
     * @param int $uid
     * @param int|string $userid
     * @param string $name
     * @param int|string $password
     * @param int $role
     * @param int $cardno
     * @return bool
     */
    public function setUser(int $uid, $userid, string $name, $password, int $role = 0, int $cardno = 0): bool
    {
        return $this->zk->setUser($uid, $userid, $name, $password, $role, $cardno);
    }

    /**
     * Clear all admins.
     *
     * @return bool
     */
    public function clearAdmins(): bool
    {
        return $this->zk->clearAdmin();
    }

    /**
     * Clear all users.
     *
     * @return bool
     */
    public function clearAllUsers(): bool
    {
        return $this->zk->clearUser();
    }

    /**
     * Remove a user by UID.
     *
     * @param int $uid
     * @return bool
     */
    public function removeUser(int $uid): bool
    {
        return $this->zk->removeUser($uid);
    }

    /**
     * Get the attendance log.
     *
     * @return array
     */
    public function getAttendanceLog(): array
    {
        return $this->zk->getAttendance();
    }

    /**
     * Clear the attendance log.
     *
     * @return bool
     */
    public function clearAttendanceLog(): bool
    {
        return $this->zk->clearAttendance();
    }
}
