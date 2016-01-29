use `webhobru_yii`;
drop procedure if exists `news_count_in_sections`;


delimiter ;;
create procedure `news_count_in_sections`()
begin
	select 
		`s`.`id`,
		`s`.`header`,
		count(distinct `n`.`id`) as `countnews`
	from
		`sec_news` `s`
		left join `news` `n` on `n`.`sec` = `s`.`id`
	group by
		`s`.`id`
	order by
        `s`.`id` asc;
end ;;


-- Example














-- USE `advocat4ru`;
-- DROP procedure IF EXISTS `categories_list`;
-- DROP procedure IF EXISTS `get_category`;
-- DROP procedure IF EXISTS `get_publication`;
-- DROP procedure IF EXISTS `publications_list_on_main`;
-- DROP procedure IF EXISTS `publications_list`;
-- DROP procedure IF EXISTS `sections_list`;
-- DROP procedure IF EXISTS `publications_list_in_section`;
-- DROP procedure IF EXISTS `comments_list`;
-- DROP procedure IF EXISTS `submit_comment`;



-- DELIMITER $$
-- CREATE PROCEDURE `categories_list` ()
-- BEGIN
-- 	SELECT 
-- 		`id`,
-- 		`parentid`,
-- 		`sid`,
-- 		`header`,
-- 		`mainmenushow`,
-- 		`menuheader`
-- 	FROM
-- 		`category`
-- 	WHERE
-- 		`show` = 'true'
-- 	ORDER BY
-- 		`order` ASC,
--         `id` ASC;
-- END$$

-- CREATE PROCEDURE `get_category` (in param_sid varchar(255))
-- BEGIN
-- 	SELECT
-- 		*
-- 	FROM
-- 		`category`
-- 	WHERE 
-- 		`sid` = param_sid;
-- END$$

-- CREATE PROCEDURE `get_publication` (in param_sid varchar(255))
-- BEGIN
-- 	SELECT
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`text`,
-- 		`p`.`author`,
--         `p`.`title`,
--         `p`.`description`,
--         `p`.`keywords`,
-- 		CONCAT( DATE_FORMAT(`date`, '%e '), ELT(MONTH(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), DATE_FORMAT(`date`, ', %Y')) AS `textdate`
-- 	FROM
-- 		`publications` `p`
-- 	WHERE
-- 		`p`.`sid` = param_sid;
-- END$$

-- CREATE PROCEDURE `publications_list_on_main` ()
-- BEGIN
-- 	SELECT
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`intro`,
-- 		`p`.`author`,
-- 		CONCAT( DATE_FORMAT(`date`, '%e '), ELT(MONTH(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), DATE_FORMAT(`date`, ', %Y')) AS `textdate`,
--         COUNT(DISTINCT `c`.`id`) AS `commentscount`
-- 	FROM
-- 		`publications` `p`
-- 		left join `comments` `c` on `p`.`id` = `c`.`publication`
-- 	GROUP BY `p`.`id`
-- 	ORDER BY `p`.`date` DESC, p.id DESC
-- 	LIMIT 0, 5;
-- END$$

-- CREATE PROCEDURE `publications_list` (in param_from int, in param_limit int)
-- BEGIN
-- 	SELECT SQL_CALC_FOUND_ROWS
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`intro`,
-- 		`p`.`author`,
-- 		CONCAT( DATE_FORMAT(`date`, '%e '), ELT(MONTH(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), DATE_FORMAT(`date`, ', %Y')) AS `textdate`,
--         COUNT(DISTINCT `c`.`id`) AS `commentscount`
-- 	FROM
-- 		`publications` `p`
-- 		left join `comments` `c` on `p`.`id` = `c`.`publication`
-- 	GROUP BY `p`.`id`
-- 	ORDER BY `p`.`date` DESC, p.id DESC
-- 	LIMIT param_from, param_limit;
-- END$$

-- CREATE PROCEDURE `publications_list_in_section` (in param_from int, in param_limit int, in param_sid varchar(255))
-- BEGIN
-- 	SELECT SQL_CALC_FOUND_ROWS
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`intro`,
-- 		`p`.`author`,
-- 		CONCAT( DATE_FORMAT(`date`, '%e '), ELT(MONTH(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), DATE_FORMAT(`date`, ', %Y')) AS `textdate`,
--         COUNT(DISTINCT `c`.`id`) AS `commentscount`
-- 	FROM
-- 		`publications` `p`
-- 		left join `comments` `c` on `p`.`id` = `c`.`publication`
--         inner join `pubsec` `ps` on `ps`.`pub`= `p`.`id`
--         inner join `sections` `s` on `s`.`id` = `ps`.`sec`
-- 	WHERE `s`.`sid` = param_sid
-- 	GROUP BY `p`.`id`
-- 	ORDER BY `p`.`date` DESC, p.id DESC
-- 	LIMIT param_from, param_limit;
-- END$$

-- create PROCEDURE `sections_list` ()
-- BEGIN
-- 	SELECT
-- 		s.*,
--         count(DISTINCT p.id) as countpub
-- 	FROM
-- 		`sections` `s`
-- 		inner join `pubsec` `ps` on `ps`.`sec` = `s`.`id`
--         inner join `publications` `p` on `p`.`id` = `ps`.`pub`
-- 	where `p`.`show` = 'true'
-- 	GROUP BY `s`.`id`
-- 	ORDER BY `s`.`order` ASC;
-- END$$

-- CREATE PROCEDURE `comments_list` (in param_id int)
-- BEGIN
-- 	SELECT
-- 		`c`.`id`,
-- 		`c`.`datatime`,
-- 		`c`.`author`,
-- 		`c`.`text`,
-- 		`c`.`publication`
--     FROM
-- 		`comments` `c`
-- 	WHERE `c`.`publication` = param_id
--     ORDER BY `c`.`datatime` ASC;
-- END$$

-- CREATE PROCEDURE `submit_comment` (in param_name varchar(45), in param_text text, in param_pubid int)
-- BEGIN
-- 	INSERT INTO `comments` (`author`, `text`, `publication`) VALUES (param_name,param_text,param_pubid);
-- END$$


-- DELIMITER ;










-- delimiter ;;
-- create procedure `categories_list`()
-- begin
-- 	select 
-- 		`id`,
-- 		`parentid`,
-- 		`sid`,
-- 		`header`,
-- 		`mainmenushow`,
-- 		`menuheader`
-- 	from
-- 		`category`
-- 	where
-- 		`show` = 'true'
-- 	order by
-- 		`order` asc,
--         `id` asc;
-- end ;;

-- create procedure `comments_list`(in param_id int)
-- begin
-- 	select
-- 		`c`.`id`,
-- 		`c`.`datatime`,
-- 		`c`.`author`,
-- 		`c`.`text`,
-- 		`c`.`publication`
--     from
-- 		`comments` `c`
-- 	where `c`.`publication` = param_id
--     order by `c`.`datatime` asc;
-- end ;;

-- create procedure `get_category`(in param_sid varchar(255))
-- begin
-- 	select
-- 		*
-- 	from
-- 		`category`
-- 	where 
-- 		`sid` = param_sid;
-- end ;;

-- create procedure `get_publication`(in param_sid varchar(255))
-- begin
-- 	select
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`text`,
-- 		`p`.`author`,
--         `p`.`title`,
--         `p`.`description`,
--         `p`.`keywords`,
-- 		concat( date_format(`date`, '%e '), elt(month(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), date_format(`date`, ', %y')) as `textdate`
-- 	from
-- 		`publications` `p`
-- 	where
-- 		`p`.`sid` = param_sid;
-- end ;;

-- create procedure `publications_list`(in param_from int, in param_limit int)
-- begin
-- 	select sql_calc_found_rows
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`intro`,
-- 		`p`.`author`,
-- 		concat( date_format(`date`, '%e '), elt(month(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), date_format(`date`, ', %y')) as `textdate`,
--         count(distinct `c`.`id`) as `commentscount`
-- 	from
-- 		`publications` `p`
-- 		left join `comments` `c` on `p`.`id` = `c`.`publication`
-- 	group by `p`.`id`
-- 	order by `p`.`date` desc, p.id desc
-- 	limit param_from, param_limit;
-- end ;;

-- create procedure `publications_list_in_section`(in param_from int, in param_limit int, in param_sid varchar(255))
-- begin
-- 	select sql_calc_found_rows
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`intro`,
-- 		`p`.`author`,
-- 		concat( date_format(`date`, '%e '), elt(month(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), date_format(`date`, ', %y')) as `textdate`,
--         count(distinct `c`.`id`) as `commentscount`
-- 	from
-- 		`publications` `p`
-- 		left join `comments` `c` on `p`.`id` = `c`.`publication`
--         inner join `pubsec` `ps` on `ps`.`pub`= `p`.`id`
--         inner join `sections` `s` on `s`.`id` = `ps`.`sec`
-- 	where `s`.`sid` = param_sid
-- 	group by `p`.`id`
-- 	order by `p`.`date` desc, p.id desc
-- 	limit param_from, param_limit;
-- end ;;

-- create procedure `publications_list_on_main`()
-- begin
-- 	select
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`intro`,
-- 		`p`.`author`,
-- 		concat( date_format(`date`, '%e '), elt(month(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), date_format(`date`, ', %y')) as `textdate`,
--         count(distinct `c`.`id`) as `commentscount`
-- 	from
-- 		`publications` `p`
-- 		left join `comments` `c` on `p`.`id` = `c`.`publication`
-- 	group by `p`.`id`
-- 	order by `p`.`date` desc, p.id desc
-- 	limit 0, 5;
-- end ;;

-- create procedure `sections_list`()
-- begin
-- 	select
-- 		s.*,
--         count(distinct p.id) as countpub
-- 	from
-- 		`sections` `s`
-- 		inner join `pubsec` `ps` on `ps`.`sec` = `s`.`id`
--         inner join `publications` `p` on `p`.`id` = `ps`.`pub`
-- 	where `p`.`show` = 'true'
-- 	group by `s`.`id`
-- 	order by `s`.`order` asc;
-- end ;;

-- create procedure `submit_comment`(in param_name varchar(45), in param_text text, in param_pubid int)
-- begin
-- 	insert into `comments` (`author`, `text`, `publication`) values (param_name,param_text,param_pubid);
-- end ;;
-- delimiter ;
