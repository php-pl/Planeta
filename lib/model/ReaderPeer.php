<?php
class ReaderPeer extends BaseReaderPeer {
    public static function increment() {
        $conn = Propel::getConnection(self::DATABASE_NAME);
        $date = date('Y-m-d');
        
        $sql = 'UPDATE %1$s SET %2$s = %2$s + 1 WHERE %3$s = \'%4$s\'';
        $sql = sprintf($sql, self::TABLE_NAME, self::CNT, self::DATE, $date);
        
        if ($conn->executeUpdate($sql) == 0) {
            $conn->executeUpdate("INSERT INTO " . self::TABLE_NAME . " VALUES ('{$date}', 1)");
        }
    }
}
