<?php

namespace FCL;

class RandomEmployees implements Iterator, Countable
{
    private $position        = 0;
    private $departments     = array();
    private $awardsAmount    = 1;
    private $employeesAmount = 0;
    private $employeesBucket = array();

    private function __construct($awardsAmount)
    {
        $this->awardsAmount = $awardsAmount;
    }

    public static function withAwardsAmount($amount)
    {
        return new self($amount);
    }

    public function setAwardsAmount(int $amount)
    {
        if($amount < 1) {
            $amount = 1;
        }
        $this->awardsAmount = $amount;
    }

    public function addDeparment(DepartmentInterface $department)
    {
        $this->departments[] = $department;
        $this->employeesAmount += count($department->getEmployees());
    }

    private function getBucketRatio()
    {
        return $this->employeesAmount / $this->awardsAmount;
    }

    public function shuffle()
    {
        foreach($this->departments as $department) {
            $employees = $department->getEmployees();
            shuffle($employees);
            $ratio = round($this->getBucketRatio() * count($employees));
            $this->employeesBucket = array_merge($this->employeesBucket, array_slice($employees, 0, $ratio));
        }
        shuffle($this->employeesBucket);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->employeesBucket[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->employeesBucket[$this->position]);
    }

    public function count()
    {
        return count($this->employeesBucket);
    }
}
