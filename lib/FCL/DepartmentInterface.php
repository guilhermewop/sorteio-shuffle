<?php

namespace FCL;

interface DepartmentInterface
{
    public function getName();
    public function setName(string $name);
    public function addEmployee(EmployeeInterface $employes);
    public function getEmployees();
}
