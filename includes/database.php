<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Prepares and executes an SQL statement with placeholders
function query($sql, $data = [], $getStatement = false)
{
    global $dbh;

    $sth = $dbh->prepare($sql); // $sth: statement handle

    if (empty($data)) {
        $isSuccess = $sth->execute();
    } else {
        $isSuccess = $sth->execute($data);
    }

    if ($isSuccess && $getStatement) {
        return $sth;
    }

    return $isSuccess;
}

function insert($tableName, $dataInsert)
{
    $keyArr = array_keys($dataInsert);
    $fieldStr = implode(', ', $keyArr);
    $valueStr = ':' . implode(', :', $keyArr);

    $sql = 'INSERT INTO `' . $tableName . '` (' . $fieldStr . ') VALUES(' . $valueStr . ')';

    return query($sql, $dataInsert);
}

function update($tableName, $dataUpdate, $condition = '', $dataCondition = [])
{
    $keyArr = array_keys($dataUpdate);
    $updateStr = '';
    foreach ($keyArr as $key) {
        $updateStr .= $key . '=:' . $key . ', ';
    }
    // Strip commas from the end of $updateStr
    $updateStr = rtrim($updateStr, ', ');

    if (!empty($condition)) {
        $sql = 'UPDATE `' . $tableName . '` SET ' . $updateStr . ' WHERE ' . $condition;
        $dataUpdate = array_merge($dataUpdate, $dataCondition);
    } else {
        $sql = 'UPDATE `' . $tableName . '` SET ' . $updateStr;
    }

    return query($sql, $dataUpdate);
}

function delete($tableName, $condition = '', $dataCondition = [])
{
    if (!empty($condition)) {
        $sql = 'DELETE FROM `' . $tableName . '` WHERE ' . $condition;
    } else {
        $sql = 'DELETE FROM `' . $tableName . '`';
    }

    return query($sql, $dataCondition);
}

// Fetch a limited number of rows returned by a PDO statement object
function getLimitRows($sql, $limit, $offset, $data = [])
{
    global $dbh;
    
    $sth = $dbh->prepare($sql); // $sth: statement handle
    foreach ($data as $key => $value) {
        $sth->bindValue($key, $value);
    }
    $sth->bindValue('limit', (int)$limit, PDO::PARAM_INT);
    $sth->bindValue('offset', (int)$offset, PDO::PARAM_INT);
    $sth->execute();

    return $sth->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch all rows returned by a PDO statement object
function getAllRows($sql, $data = [])
{
    $statement = query($sql, $data, true);
    if (is_object($statement)) {
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    return false;
}

// Fetch first row returned by a PDO statement object
function getFirstRow($sql, $data = [])
{
    $statement = query($sql, $data, true);
    if (is_object($statement)) {
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    return false;
}

// Returns the number of rows affected by the last SQL statement
function getNumberOfRows($sql, $data = [])
{
    $statement = query($sql, $data, true);
    if (is_object($statement)) {
        return $statement->rowCount();
    }

    return false;
}

function getLastInsertedId()
{
    global $dbh;
    return $dbh->lastInsertId();
}
