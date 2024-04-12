<?php
// 데이터베이스 연결 코드 여기에 포함
include 'connectionDB.php';

if(isset($_POST['content_id']) && isset($_POST['comment'])) {
    $contentId = $_POST['content_id'];
    $comment = $_POST['comment'];
    // 댓글 추가 로직 구현
    // 예를 들어, comments 테이블에 새로운 레코드 추가
    $query = "INSERT INTO comments (content_id, comment) VALUES ('$contentId', '$comment')";
    if(mysqli_query($conn, $query)) {
        echo "댓글 추가 성공";
    } else {
        echo "오류: " . mysqli_error($conn);
    }
}
?>
