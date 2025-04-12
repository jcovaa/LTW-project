<?php

declare(strict_types=1);

class Message {
    public int $id;
    public int $senderId;
    public int $receiverId;
    public string $content;
    public string $sentAt;

    public function __construct(int $id, int $senderId, int $receiverId, string $content, string $sentAt) {
        $this->id = $id;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->content = $content;
        $this->sentAt = $sentAt;
    }

    
    public static function getConversation(PDO $db, int $user1, int $user2): array {
        $stmt = $db->prepare('
            SELECT * FROM Message
            WHERE (SenderId = ? AND ReceiverId = ?) OR (SenderId = ? AND ReceiverId = ?)
            ORDER BY SentAt ASC
        ');
        $stmt->execute([$user1, $user2, $user1, $user2]);

        $messages = [];
        while ($row = $stmt->fetch()) {
            $messages[] = new Message(
                $row['MessageId'],
                $row['SenderId'],
                $row['ReceiverId'],
                $row['Content'],
                $row['SentAt']
            );
        }

        return $messages;
    }

    
}


?>