<!--
DELIMITER //
CREATE PROCEDURE get_users
(IN user_id CHAR(20))
BEGIN
 select `users`.*, (select count(*) from `user_follows` where `users`.`id` = `user_follows`.`followed_id` and `user_id` = user_id) as `is_following_count` from `users` where `id` != user_id;
END //
DELIMITER ;

-->


<!--
DELIMITER //
CREATE PROCEDURE p_search_strain_survey
(IN query1 CHAR(50), query2 CHAR(50), query3 CHAR(50), query4 CHAR(50))
BEGIN
 SELECT
  *,
  (IF(`answer` LIKE '%query1%',1,0)+IF(`answer` LIKE '%query2%',1,0)+IF(`answer` LIKE '%query3%',1,0)+IF(`answer` LIKE '%query4%',1,0)) AS matched
FROM `strain_survey_answers`
WHERE `answer` LIKE '%query1%'
     OR `answer` LIKE '%query2%'
     OR `answer` LIKE '%query3%'
     OR `answer` LIKE '%query4%'
GROUP BY `question_id`, `strain_id`
ORDER BY matched DESC;
END //
DELIMITER ;

-->

<!--
DELIMITER //
CREATE PROCEDURE get_users_followes
(IN user_id CHAR(20))
BEGIN
SELECT user_follows.user_id, user_follows.followed_id, users.*
FROM user_follows
LEFT JOIN users ON user_follows.followed_id=users.id
WHERE user_follows.user_id= user_id;
END //
DELIMITER ;
-->