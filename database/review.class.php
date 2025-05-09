<?php

class Review
{
    public int $id;
    public int $serviceId;
    public int $clientId;
    public ?string $clientName;
    public int $rating;
    public string $comment;


    public function __construct(int $id, int $serviceId, int $clientId, ?string $clientName = null ,int $rating, string $comment)
    {
        $this->id = $id;
        $this->serviceId = $serviceId;
        $this->clientId = $clientId;
        $this->clientName = $clientName;
        $this->rating = $rating;
        $this->comment = $comment;
    }

    public static function getReview(PDO $db, int $id): Review {
        $stmt = $db->prepare('
            SELECT 
                Review.ReviewId, 
                Review.ServiceId, 
                Review.ClientId, 
                Review.Rating, 
                Review.Comment, 
                User.Name as ClientName
            FROM Review
            JOIN User ON Review.ClientId = User.UserId
            WHERE Review.ReviewId = ?
        ');

        $stmt->execute([$id]);

        $review = $stmt->fetch();

        if (!$review) {
            throw new Exception("Review not found.");
        }

        return new Review(
            $review['ReviewId'],
            $review['ServiceId'],
            $review['ClientId'],
            $review['ClientName'],
            intval($review['Rating']),
            $review['Comment']
        );
    }

    public static function getServiceReviews(PDO $db, int $serviceId): array {
        $stmt = $db->prepare('
            SELECT 
                Review.ReviewID, 
                Review.ServiceId, 
                Review.ClientId, 
                Review.Rating, 
                Review.Comment, 
                User.Name as ClientName
            FROM Review
            JOIN User ON Review.ClientId = User.UserId
            WHERE Review.ServiceId = ?
        ');
    
        $stmt->execute([$serviceId]);
    
        $reviews = [];
        while ($row = $stmt->fetch()) {
    
            if (!isset($row['ReviewID'], $row['ServiceId'], $row['ClientId'], $row['Rating'], $row['Comment'])) {
                continue; 
            }
    
            $reviews[] = new Review(
                intval($row['ReviewID']),
                intval($row['ServiceId']),
                intval($row['ClientId']),
                $row['ClientName'] ?? null,
                intval($row['Rating']),
                $row['Comment']
            );
        }
    
        return $reviews;
    }

    public static function getReviewCountsByRating(PDO $db, int $serviceId): array {
        $stmt = $db->prepare('
            SELECT Rating, COUNT(*) as Count
            FROM Review
            WHERE ServiceId = ?
            GROUP BY Rating
            ORDER BY Rating DESC
        ');

        $stmt->execute([$serviceId]);

        $counts = [];
        while ($row = $stmt->fetch()) {
            $counts[intval($row['Rating'])] = intval($row['Count']);
        }

        for ($i = 1; $i <= 5; $i++) {
            if (!isset($counts[$i])) {
                $counts[$i] = 0;
            }
        }

        return $counts;
    }
    
    public static function getRatingsData(PDO $db, int $serviceId): array {
        $ratingCounts = self::getReviewCountsByRating($db, $serviceId);
    
        $totalReviews = 0;
        $overallRating = 0;
        $percentages = [];
    
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($ratingCounts[$i])) {
                $ratingCounts[$i] = 0;
            }
        }
    
        foreach ($ratingCounts as $stars => $count) {
            $totalReviews += $count;
            $overallRating += $stars * $count;
        }
    
        $overallRating = $totalReviews > 0 ? round($overallRating / $totalReviews, 1) : 0;
    
        for ($i = 1; $i <= 5; $i++) {
            $percentages[$i] = $totalReviews > 0 ? round(($ratingCounts[$i] / $totalReviews) * 100, 2) : 0;
        }
    
        return [
            'totalReviews' => $totalReviews,
            'overallRating' => $overallRating,
            'ratingCounts' => $ratingCounts,
            'percentages' => $percentages,
        ];
    }

    public static function addReview(PDO $db, int $serviceId, int $clientId, int $rating, string $comment): bool {
        $checkStmt = $db->prepare('
            SELECT COUNT(*) as count
            FROM Review
            WHERE ServiceId = ? AND ClientId = ?
        ');
        $checkStmt->execute([$serviceId, $clientId]);
        $result = $checkStmt->fetch();

        if ($result['count'] > 0) {
            $stmt = $db->prepare('
                UPDATE Review
                SET Rating = ?, Comment = ?
                WHERE ServiceId = ? AND ClientId = ?
            ');
            return $stmt->execute([$rating, $comment, $serviceId, $clientId]);
        } else {
            $stmt = $db->prepare('
                INSERT INTO Review (ServiceId, ClientId, Rating, Comment)
                VALUES (?, ?, ?, ?)
            ');
            return $stmt->execute([$serviceId, $clientId, $rating, $comment]);
        }
    }
}

?>
