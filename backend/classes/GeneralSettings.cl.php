<?php

/**
 *
 */

class GeneralSettings extends DB_CONN
{

    protected function read()
    {
        try {
            $data = [];
            $s_rows = null;
            $s_stmt = $this->connect()->prepare("SELECT * FROM general_settings LIMIT 1 ");
            $s_stmt->execute();
            if ($s_stmt->rowCount() > 0) {
                $s_rows=$s_stmt->fetch(PDO::FETCH_ASSOC);
            }

            array_push($data, $s_rows);
           
            $s_stmt = null;
            return $data;
            exit();
        } catch (PDOException $e) {
            $error = 'E0x0000000CxGENSET1: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return ['code'=>404, 'msg'=>$error];
        exit();
    }

}
